<?php 


class SC9_Strategy_SwissDraw implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct($numberOfRounds) {
		$this->numberOfRounds = $numberOfRounds;
	}
	
	
	public function calculateNumberOfRounds($teamCount) {
		return $this->numberOfRounds;
	}
}