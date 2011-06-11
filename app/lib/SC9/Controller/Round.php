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
		echo "filled in random resulst for round ".$roundId;		
//		$this->relocate("/pool/detail/".$round->Pool->id."&tournamentId=".$round->Pool->Stage->Division->Tournament->id."&divisionId=".$round->Pool->Stage->Division->id."&stageId=".$round->Pool->Stage->id);
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
		echo "exported Matchups of this round to SQL file<br>";
		
		exit;
		$this->relocate("/stage/detail/".$stageId);
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
		
		echo "<br>";
		echo "<a href='index.php?n=/pool/detail/".$round->Pool->id."&tournamentId=".$round->Pool->Stage->Division->tournament_id."&divisionId=".$round->Pool->Stage->Division->id."&stageId=".$round->Pool->Stage->id."'>back to pool</a>";
		
		exit;
		$this->relocate("/stage/detail/".$stageId);
	}
	
	public function computeMatchupsAction() {
		$roundId=$this->request('roundId');
		$round=Round::getRoundById($roundId);
		
		$round->createMatchups();
		
		echo "matchup computed, see FireBug output for debug info.";
		
		echo "<br>";
		echo "<a href='index.php?n=/pool/detail/".$round->Pool->id."&tournamentId=".$round->Pool->Stage->Division->Tournament->id."&divisionId=".$round->Pool->Stage->Division->id."&stageId=".$round->Pool->Stage->id."'>back to pool</a>";		
				
		//$this->relocate("/pool/detail/".$this->poolId);
		
	}
	
}