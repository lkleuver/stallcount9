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
			FB::group('importing CSV stuff');
			$fileHandle=$this->file('CSVFile');
			FB::log('FILEname '.$fileHandle['tmp_name']);
			
			FB::log('moving uploaded file '.move_uploaded_file($fileHandle['tmp_name'], dirname(__FILE__) . '/../../../import/division.csv'));
			
			FB::log('trying to open '.dirname(__FILE__) . '/../../../import/division.csv');
			$row = 1;
			if (($handle = fopen(dirname(__FILE__) . '/../../../import/division.csv', "r")) !== FALSE) {
				$data = fgetcsv($handle, 0, ","); // pop off the first line with the header information
				// make sure header data is of the right format
				assert(stristr($data[0],'name') !== false);
				assert(stristr($data[1],'mail') !== false);
				assert(stristr($data[2],'mail') !== false);
				assert(stristr($data[3],'contact') !== false);
				assert(stristr($data[5],'city') !== false);
				assert(stristr($data[6],'country') !== false);
				assert(stristr($data[7],'mobile') !== false);
				assert(stristr($data[8],'mobile') !== false);
				assert(stristr($data[10],'comment') !== false);
								
			    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
					$team = Team::teamNameExists($this->divisionId, $data[0]);
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
						$poolTeam->seed = count($division->Teams) + 1;			
						$poolTeam->rank = count($division->Teams) + 1;
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
					$team->comment=$data[10];					
					$team->link('Division', array($this->post("divisionId")));
					$team->save();								

			    }
			    fclose($handle);
			}
			
			FB::groupEnd();
			
			FB::log('divisionId '.$this->post("divisionId"));
			exit;
			$this->relocate("/division/detail/".$this->post("divisionId"));
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
	
}