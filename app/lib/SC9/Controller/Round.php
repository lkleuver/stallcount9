<?php


class SC9_Controller_Round extends SC9_Controller_Core {
	
	public $roundId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->roundId = count($params) > 0 ? $params[0] : "";
	}
	
	public function createAction() {
		$poolId=$this->request('poolId');
		if ($poolId == "") {
			die('a poolId has to be provided');
		}
		$pool = Pool::getById($poolId);
		if ($pool->PoolRuleset->title !== "FlexPool") {
			die('individual rounds can only be created in FlexPools. This is a '.$pool->PoolRuleset->title.' pool...');
		}
			
		$round = new Round();
		$round->rank = count($pool->Rounds)+1;		
		$nrMatches=ceil($pool->spots/2);
		$timeslots= Windmill::getWomenTimeSlots();
		$fields=Windmill::getWomenFieldsByRound($round->rank);
		
		for ($i=0 ; $i < $nrMatches ; $i++) {
			$match = new RoundMatch();
			$match->link('Round', array($round->id));
			$match->rank = ($i+1);
			$match->matchName = 'Match rank '.($i+1);
			$match->scheduledTime = $timeslots[$round->rank-1]['scheduledTime'];
			$match->field_id = ($i<count($fields) ? $fields[$i]['id'] : null);
			$round->Matches->add($match);
		} 
			
		if($this->post("roundSubmit") != "") {
			foreach($round->Matches as $match) {				
				$match->home_team_id=$this->post('hometeam'.$match->rank);
				$match->away_team_id=$this->post('awayteam'.$match->rank);
				if ($match->home_team_id == 0 ) { $match->home_team_id = null; }
				if ($match->away_team_id == 0 ) { $match->away_team_id = null; }
				if ($match->home_team_id == null && $match->away_team_id == null) {
					FB::warn('both teams are null');
				}
				$match->field_id=$this->post('field'.$match->rank);
				if ($match->field_id == 0 ) { $match->field_id = null; }
				$match->scheduledTime=$this->post('time'.$match->rank);
				$match->save();
			}		
			
			$round->link('Pool',array($poolId));
			$round->save();			
			$pool->Rounds->add($round);
			$pool->currentRound = $round->rank;
			$pool->save();
			
			$this->relocate("/pool/detail/".$poolId.
				"&divisionId=".$pool->Stage->Division->id.
				"&stageId=".$pool->Stage->id.
				"&tournamentId=".$pool->Stage->Division->tournament_id );
		} elseif ($this->post("cancel") != "") {
			// delete stuff we have created before
			$round->delete();
			$this->relocate("/pool/detail/".$poolId.
				"&divisionId=".$pool->Stage->Division->id.
				"&stageId=".$pool->Stage->id.
				"&tournamentId=".$pool->Stage->Division->tournament_id );
		}
		
		$template = $this->output->loadTemplate('round/create.html');
		$template->display(array("division" => $pool->Stage->Division, "round" => $round, "pool" => $pool,
			"timeslots" => $timeslots, "fields" => $fields));
		
	}
	
	public function editAction() {
		$roundId=$this->request('roundId');
		if ($roundId == "") {
			die('a roundId has to be provided');
		}
		$round = Round::getRoundById($roundId);
		$pool = Pool::getById($round->pool_id);
		$poolId=$pool->id;
		if ($round->Pool->PoolRuleset->title !== "FlexPool") {
			die('individual rounds can only be edited in FlexPools. This is a '.$pool->PoolRuleset->title.' pool...');
		}
			
		$timeslots= Windmill::getWomenTimeSlots();
		$fields=Windmill::getWomenFieldsByRound($round->rank);
		
		if($this->post("roundSubmit") != "") {
			foreach($round->Matches as $match) {
				$match->home_team_id=$this->post('hometeam'.$match->rank);
				if ($match->home_team_id == 0 ) { $match->home_team_id = null; }
				$match->away_team_id=$this->post('awayteam'.$match->rank);
				if ($match->away_team_id == 0 ) { $match->away_team_id = null; }
				$match->field_id=$this->post('field'.$match->rank);
				if ($match->field_id == 0 ) { $match->field_id = null; }
				$match->scheduledTime=$this->post('time'.$match->rank);
				$match->save();
			}		
			
			$round->save();
			
			$this->relocate("/pool/detail/".$poolId.
				"&divisionId=".$pool->Stage->Division->id.
				"&stageId=".$pool->Stage->id.
				"&tournamentId=".$pool->Stage->Division->tournament_id );
		} elseif ($this->post("cancel") != "") {
			$this->relocate("/pool/detail/".$poolId.
				"&divisionId=".$pool->Stage->Division->id.
				"&stageId=".$pool->Stage->id.
				"&tournamentId=".$pool->Stage->Division->tournament_id );
		}
		
		$template = $this->output->loadTemplate('round/edit.html');
		$template->display(array("division" => $pool->Stage->Division, "round" => $round, "pool" => $round->Pool,
			"timeslots" => $timeslots, "fields" => $fields));
		
	}
	
	
	public function randomScoreAction() {				
//		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$roundId=$this->request('roundId');		
		$round=Round::getRoundById($roundId);
		
		$round->randomScoreFill();	
		FB::log("filled in random results for round ".$roundId);		
//		$this->relocate("/pool/detail/".$round->Pool->id.
//			"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
//			"&divisionId=".$round->Pool->Stage->Division->id.
//			"&stageId=".$round->Pool->Stage->id);
	}
		
	
	public function announceAction() {				
//		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$roundId=$this->request('roundId');
		if ($roundId == "") {
			$stageId=$this->request('stageId');
			$roundRank=$this->request('roundRank');
			if (is_null($stageId) || is_null($roundRank) ) {
				FB::error('illegal call of round/announce, please provide correct parameters');
				die('illegal call of round/announce, please provide correct parameters');
			}
			// go through all rounds of $stageId with $roundRank and announce them
			$stage=Stage::getById($stageId);
			foreach($stage->Pools as $pool) {
				$round=Round::getRoundByRank($pool->id, $roundRank);
				$round->announce();
			}
		} else { // call with simple RoundId, then just announce that round
			$round=Round::getRoundById($roundId);
			$round->announce();
		}
		
		$this->relocate("/division/active/".$round->Pool->Stage->Division->id.
				"&tournamentId=".$round->Pool->Stage->Division->Tournament->id);
		
//		$this->relocate("/stage/detail/".$stageId.
//			"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
//			"&divisionId=".$round->Pool->Stage->Division->id.
//			"&stageId=".$round->Pool->Stage->id);
	}

	public function finishAction() {				
		$roundId=$this->request('roundId');
		if ($roundId == "") {
			$stageId=$this->request('stageId');
			$roundRank=$this->request('roundRank');
			if (is_null($stageId) || is_null($roundRank) ) {
				FB::error('illegal call of round/announce, please provide correct parameters');
				die('illegal call of round/announce, please provide correct parameters');
			}
			// go through all rounds of $stageId with $roundRank and announce them
			$stage=Stage::getById($stageId);
			foreach($stage->Pools as $pool) {
				$round=Round::getRoundByRank($pool->id, $roundRank);
				$round->finish();
			}
			$this->relocate("/division/active/".$stage->Division->id.
				"&tournamentId=".$stage->Division->Tournament->id);
			
		} else { // call with simple RoundId, then just announce that round
			$round=Round::getRoundById($roundId);
			if ($round->finish()) { // there is a next round
				$this->relocate("/division/active/".$round->Pool->Stage->Division->id.
						"&tournamentId=".$round->Pool->Stage->Division->Tournament->id);				
			} else { // there is no next round
				$this->relocate("/stage/detail/".$round->Pool->Stage->id.
					"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
					"&divisionId=".$round->Pool->Stage->Division->id.
					"&stageId=".$round->Pool->Stage->id);				
			}
		}
		
	}
	
	public function createMatchupsAction() {
		$roundId=$this->request('roundId');
		$round=Round::getRoundById($roundId);
		
		$round->createMatchups();
		
//		echo "matchup computed, see FireBug output for debug info.";
//		
//		echo "<br>";
//		echo "<a href='index.php?n=/pool/detail/".$round->Pool->id."&tournamentId=".$round->Pool->Stage->Division->Tournament->id."&divisionId=".$round->Pool->Stage->Division->id."&stageId=".$round->Pool->Stage->id."'>back to pool</a>";		

		$this->relocate("/division/active/".$round->Pool->Stage->Division->id.
		"&tournamentId=".$round->Pool->Stage->Division->Tournament->id);
		
//		$this->relocate("/pool/detail/".$round->Pool->id.
//			"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
//			"&divisionId=".$round->Pool->Stage->Division->id.
//			"&stageId=".$round->Pool->Stage->id);
				
	}
	
}