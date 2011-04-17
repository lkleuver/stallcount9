<?php 


class SC9_Strategy_Bracket implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	
	public function calculateNumberOfRounds($teamCount) {
		$r = $teamCount;
		while($r > 1) {
			$this->numberOfRounds++;
			$r = $r / 2;
		}
		return $this->numberOfRounds;
	}
	
	public function createMatchups($pool) {
		
	}
}