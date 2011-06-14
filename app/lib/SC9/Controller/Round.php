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