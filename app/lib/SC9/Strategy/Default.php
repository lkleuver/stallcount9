<?php 


class SC9_Strategy_Default implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	public function getName() {
		return "Default";
	}
	
	public function calculateNumberOfRounds($teamCount) {
		return $this->numberOfRounds;
	}
	
	public function createMatchups($pool) {
		
	}
	
	public function standingsAfterRound($pool, $roundNr) {
		return null;
	}
}