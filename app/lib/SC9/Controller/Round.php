<?php


class SC9_Controller_Round extends SC9_Controller_Core {
	
	public $roundId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->roundId = count($params) > 0 ? $params[0] : "";
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
		$round=Round::getRoundById($roundId);
		
		$round->createSMS();		
		Export::exportSMSToMySQL($roundId);
		echo "exported SMS of this round to SQL file<br>";
		$log = Logger::getLogger('myLogger');
		$log->info('exported SMS of this round to SQL file');    	
		
		Export::exportRoundMatchupsToMySQL($roundId);
//		echo "exported Matchups of this round to SQL file<br>";
//		
//		exit;
		$this->relocate("/division/active/".$round->Pool->Stage->Division->id.
				"&tournamentId=".$round->Pool->Stage->Division->Tournament->id);
		
//		$this->relocate("/stage/detail/".$stageId.
//			"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
//			"&divisionId=".$round->Pool->Stage->Division->id.
//			"&stageId=".$round->Pool->Stage->id);
	}

	public function finishAction() {				
//		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$roundId=$this->request('roundId');
		$round=Round::getRoundById($roundId);
			
		Export::exportRoundResultsToMySQL($roundId);
		echo "exported results of this round to SQL file<br>";
		
		if ($round->Pool->PoolRuleset->title != "Bracket" || ($round->Pool->Stage->placement && count($round->Pool->Rounds)==$round->rank) ) { 
			// if it's either not a playoff round
			// or the last playoff round of a placement pool
			echo "exported standings of this round to SQL file<br>";			
			Export::exportStandingsAfterRoundToMySQL($roundId);			
		}
		
		$round->Pool->currentRound++;
		$round->Pool->save();
		
		$nextRound = Round::getRoundByRank($round->pool_id, $round->Pool->currentRound);
		
		if ($nextRound === false ) { // there is no next round
			$this->relocate("/stage/detail/".$round->Pool->Stage->id.
				"&tournamentId=".$round->Pool->Stage->Division->Tournament->id.
				"&divisionId=".$round->Pool->Stage->Division->id.
				"&stageId=".$round->Pool->Stage->id);
		} else {
			// create matchups for next round
			$nextRound->createMatchups();
			$this->relocate("/division/active/".$round->Pool->Stage->Division->id.
					"&tournamentId=".$round->Pool->Stage->Division->Tournament->id);
			
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