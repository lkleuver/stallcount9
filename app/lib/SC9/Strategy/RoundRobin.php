<?php 


class SC9_Strategy_Roundrobin implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	
	public function calculateNumberOfRounds($teamCount) {
		$this->numberOfRounds = $teamCount - 1;
		return $this->numberOfRounds;
	}
	
	public function createMatchups($pool) {
		
	}
}