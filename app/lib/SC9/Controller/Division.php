<?php


class SC9_Controller_Division extends SC9_Controller_Core {
	public $divisionId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->divisionId = isset($_REQUEST["divisionId"]) ? $_REQUEST["divisionId"] : "";
	}
	

	public function scheduleAction() {
		$division = Division::getById($this->divisionId);
		$division->schedule();
		
		echo 'if no error is displayed, games have been successfully scheduled (see FireBug for debug info)<br>';
		
		echo "<br>";
		echo "<a href='index.php?n=/division/detail/".$this->divisionId."'>back to division</a>";
		
		exit;
		$this->relocate("/division/detail/".$this->divisionId);
	}

	public function detailAction() {
		$division = Division::getById($this->divisionId);
		
		$template = $this->output->loadTemplate('division/detail.html');
		$template->display(array("division" => $division ));
	}
	

	public function importAction() {
		$division = Division::getById($this->divisionId);
		
		if($this->post("divisionImport") != "") {
			// if there exists a CSV file, import it
			$fileHandle=$this->file('CSVFile');
			FB::table('fileHandle ',$fileHandle);
			if ($fileHandle['size'] > 0) {
				FB::group('importing CSV stuff');
				FB::log('FILEname '.$fileHandle['tmp_name']);
				$targetFileName=dirname(__FILE__).'/../../../import/division.csv';		
				FB::log('moving uploaded file '.move_uploaded_file($fileHandle['tmp_name'], $targetFileName));			
				$delimiter=",";
			} else {
				$fileHandle = $this->file('TABFile');
				if ($fileHandle['size'] == 0) {
					trigger_error('no file uploaded');
					die;
				}
				FB::group('importing TAB stuff');
				FB::log('FILEname '.$fileHandle['tmp_name']);		
				$targetFileName=dirname(__FILE__).'/../../../import/division.tab';
				FB::log('moving uploaded file '.move_uploaded_file($fileHandle['tmp_name'], $targetFileName));
				$delimiter="\t";			
			}
			$row = 1;
			if (($handle = fopen($targetFileName, "r")) !== FALSE) {
				$data = fgetcsv($handle, 0, $delimiter); // pop off the first line with the header information
				foreach($data as $item) {
					FB::log('header data '.$item);
				}
				// make sure header data is of the right format
				assert(stristr($data[0],'name') !== false);
				assert(stristr($data[1],'mail') !== false);
				assert(stristr($data[2],'mail') !== false);
				assert(stristr($data[3],'contact') !== false);
				assert(stristr($data[5],'city') !== false);
				assert(stristr($data[6],'country') !== false);
				assert(stristr($data[7],'mobile') !== false);
				assert(stristr($data[8],'mobile') !== false);
				assert(stristr($data[9],'mobile') !== false);
				assert(stristr($data[10],'comment') !== false);
				assert(stristr($data[14],'short') !== false);
								
				$teamcount=count($division->Stages[0]->Pools[0]->PoolTeams); // in registration pool of seeding stage
			    while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {			    	
			    	if ($data[0] == "") {
			    		FB::log('this record does not contain a team name, ignoring.');
			    	} else {
			    		$team=Team::teamNameExists($this->divisionId, $data[0]);
				    	if ($team === false) {
					    	FB::log('adding a new team ',$data[0]);				    	
					    	// create new team
							$team = new Team();
							$team->name=$data[0];
							$team->save();
	
							//now add this team to the registration seeding pool
							$poolTeam = new PoolTeam();
							$poolTeam->team_id = $team->id;
							$poolTeam->pool_id = $division->getSeedPoolId();
							$poolTeam->seed = ++$teamcount;			
							$poolTeam->rank = $teamcount;
							$poolTeam->save();						
				    	} else {
				    		FB::log('team '.$team->name.' already exists in this division. Updating its data...');
				    	}
						$team->email1=$data[1];
						$team->email2=$data[2];
						$team->contactName=$data[3];
						$team->city=$data[5];
						$team->country=$data[6];
						$team->mobile1=$data[7];
						$team->mobile2=$data[8];
//						$morenumbers=explode(",",$data[9]);
//						if (count($morenumbers) > 0) {							
//							FB::table('more mobile nrs ',$morenumbers);
//						}
						$team->comment=$data[10];
						$team->shortName=$data[14];				
						$team->link('Division', array($this->post("divisionId")));
						$team->save();
			    	}								
			    }
			    fclose($handle);
			}
			
			FB::groupEnd();
			
			FB::log('divisionId '.$this->post("divisionId"));
			
			echo "data imported, see FirePHP for info";
			echo "<br>";
			echo "<a href='index.php?n=/division/detail/".$this->post("divisionId")."'>back to division</a>";
			exit;
//			$this->relocate("/division/detail/".$this->post("divisionId"));
		}
		
		$template = $this->output->loadTemplate('division/import.html');
		$template->display(array("division" => $division));
	}

	public function createAction() {
		$tournament = Tournament::getById($this->request("tournamentId"));
		$division = new Division(); 
		
		
		if($this->post("divisionSubmit") != "") {
			$division->title = $this->post("divisionTitle");
			$division->link('Tournament', array($tournament->id));
			$division->save();
			
			$division->initializeDivision();
			
			$this->relocate("/tournament/detail/".$tournament->id);
		}
		
		$template = $this->output->loadTemplate('division/create.html');
		$template->display(array("tournament" => $tournament, "division" => $division));
	}
	
	
	public function nextstageAction() {
		$division = Division::getById($this->divisionId);
		$seedingStageId = $this->get("seedingStageId");
		$division->seedNextStage();
		
	}
	
	public function removeAction() {
		$division = Doctrine_Core::getTable("Division")->find($this->divisionId);
		$tournamentId = $division->Tournament->id; //needed? to lazy to check if delete also empties the object
		$division->delete();
		$this->relocate("/tournament/detail/".$tournamentId);
	}
	
	
	public function activeAction() {
		$division = Division::getById($this->divisionId);
		$stage = $division->getActiveStage();
		$currentRound = $stage->getActiveRound();
		
		$roundName=(($stage->title == "Playoff") ? Brackets::getName($currentRound,3) : null);
		
		$rounds = array();
		foreach($stage->Pools as $pool) {
			$rounds[] = Round::getRoundByRank($pool->id, $currentRound);
		}
		
		$template = $this->output->loadTemplate('division/active.html');
		$template->display(array("division" => $division, "activeStage" => $stage, "currentRound" => $currentRound, "rounds" => $rounds, "roundName" => $roundName));
	}
	
	public function excelAction() {
		$division = Division::getById($this->divisionId);
		
		$resultsDB=array();
		foreach($division->Stages as $stage) {
			foreach($stage->Pools as $pool) {
				foreach($pool->Rounds as $round) {
					if ($round->allTeamsFilledIn()) {
						foreach($round->Matches as $match) {
//							$resultsDB[]=Export::getAbbreviationForRound($round)."\t".$match->HomeTeam->name."\t".$match->homeScore."\t". 
//								$match->AwayTeam->name."\t".$match->awayScore."\t".Field::getFieldNrFromTitle($match->Field->title)."\n";
							$resultsDB[]=array(Export::getAbbreviationForRound($round),$match->HomeTeam->name,$match->homeScore, 
								$match->AwayTeam->name,$match->awayScore,Field::getFieldNrFromTitle($match->Field->title));
						}
					}
				}
			}
		}
		
		$standingsDB=array();
		$swissPool=$division->Stages[1]->Pools[0];
		assert($swissPool->title == "Swissdraw");
		for($i=1 ; $i <= 5 ; $i++) {
			$standings=$swissPool->getStrategy()->standingsAfterRound($swissPool,$i);
			$standingsDB[]=$standings;
		}
				
		
		$template =$this->output->loadTemplate('division/excel.html');
		$template->display(array("division" => $division, "resultsDB" => $resultsDB, "standingsDB" => $standingsDB));
	} 
	
	
}