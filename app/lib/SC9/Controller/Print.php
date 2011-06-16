<?php



class SC9_Controller_Print extends SC9_Controller_Core {
	
	
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
	}
	
	
	
	public function scheduleAction() {
		$stage = Stage::getById($this->request("stageId"));
		$roundRank = $this->request("roundRank");
		
		$rounds = array();
		
		
		foreach($stage->Pools as $pool) {
			$round = Round::getRoundByRank($pool->id, $roundRank, true);
			$rounds[] = $round;
		}

		$pdf = new SC9_Output_MatchupsPDF($rounds, $roundRank, $stage->Division->title);
		
		$pdf->Output($stage->Division->title.'_schedule_round_'.$roundRank,'I');
	}
	
	public function resultsAction() {
		$stage = Stage::getById($this->request("stageId"));
		$roundRank = $this->request("roundRank");
		
		$rounds = array();
		
		
		foreach($stage->Pools as $pool) {
			$round = Round::getRoundByRank($pool->id, $roundRank, true);
			$rounds[] = $round;
		}

		$pdf = new SC9_Output_ResultsPDF($rounds, $roundRank, $stage->Division->title);
		
		$pdf->Output($stage->Division->title.'_results_round_'.$roundRank,'I');
	}
	
	public function standingsAction() {
		$stage = Stage::getById($this->request("stageId"));
		$roundRank = $this->request("roundRank");
		
		$standings = array();
		foreach($stage->Pools as $pool) {
			$standings[] = $pool->standingsAfterRound($roundRank); 
		}

		$pdf = new SC9_Output_StandingsPDF($standings, $roundRank, $stage->Division->title);
		$pdf->Output($stage->Division->title.'_standings_after_round_'.$roundRank,'I');
		
		//$pdf->Output("standings_after_round_".$roundRank.".pdf", "D");
		exit;
	}
	
}