<?php 


class SC9_Strategy_SwissDraw implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct($numberOfRounds) {
		$this->numberOfRounds = $numberOfRounds;
	}
	
	public function getName() {
		return "Swissdraw";
	}
	
	public function calculateNumberOfRounds($teamCount) {
		return $this->numberOfRounds;
	}
	
	/**
	 * sets currentRank of teams in $pool up to 
	 * their rank computed from results up to round $roundnr
	 * 
	 * @author Chris
	 *
	 */	
	public function computeStandingsUpToRound($pool, $roundnr) {
		if ($roundnr == 1) {
			foreach($pool->PoolTeams as $poolteam) {
				$poolteam->currentRank = $poolteam->rank;
			}
		}
		
		$pool->save();
		return null;		
	}
	
	public function createMatchups($pool) {
		$curRoundNr = $pool->currentRound;
		$allRounds = Round::getRounds($pool->id);
		$curRound = $allRounds[$curRoundNr-1];

		// Chris: the following line should do the same, but doesn't work, and I don't understand why
		// $curRound = Round::getParticularRound($pool->id,$curRoundNr+1);
		
		$this->computeStandingsUpToRound($pool, $curRoundNr);
//		foreach($pool->PoolTeams as $poolteam) {
//			echo $poolteam->team_id  ."   ";
//			echo $poolteam->currentRank . "<br />";
//		}
		
		// get list of teams including names etc.
		// sorted according to currentrank
		$poolteams=PoolTeam::getSortedTeamsByPool($pool->id);
		
		// fill in match ups
		$teamcounter=0;
		for ($i=0; $i < count($curRound->Matches); $i++) {
			$curRound->Matches[$i]->home_team_id = $pool->PoolTeams[$teamcounter++]->team_id;
			$curRound->Matches[$i]->away_team_id = $pool->PoolTeams[$teamcounter++]->team_id;	
			$curRound->save();		
		};
		
		// increase current round
		if ($curRoundNr < $this->numberOfRounds) { 
			$pool->currentRound = ($curRoundNr + 1);
		} else { // or set to 0 if total number of rounds is reached
			$pool->currentRound = 0;
		}
		$pool->save();
	}
}