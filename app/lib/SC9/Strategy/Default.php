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
		return null;		
	}
	
	public function nameMatches($pool) {
		return null;
	}
	
	public function standingsAfterRound($pool, $roundNr) {
		$standings=array();
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'name' => $poolteam->Team->name, 'spirit' => 0, 'rank' => $poolteam->rank, 'seed' => $poolteam->seed);
		}		
		return $standings;
	}
	
	public function createSMS($pool,$roundId) {
		return null;
	}
	
}