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
		} else {
			// initialize standings arrays
			foreach($pool->PoolTeams as $poolteam) {
				$standings[$poolteam->team_id] = array('games' => 0, 'vp' => 0, 'margin' => 0, 'scored' => 0);
			}
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					echo $match->home_team_id." vs ".$match->away_team_id." was ".$match->homeScore." - ".$match->awayScore;
					
					// update home team stats
					$standings[$match->home_team_id]['games']++;					
					$standings[$match->home_team_id]['vp'] += VictoryPoints::getByMargin($match->homeScore - $match->awayScore);
					$standings[$match->home_team_id]['margin'] += $match->homeScore - $match->awayScore;
					$standings[$match->home_team_id]['scored'] += $match->homeScore;
					
					// update away team stats
					$standings[$match->away_team_id]['games']++;					
					$standings[$match->away_team_id]['vp'] += VictoryPoints::getByMargin($match->awayScore - $match->homeScore);
					$standings[$match->away_team_id]['margin'] += $match->awayScore - $match->homeScore;
					$standings[$match->away_team_id]['scored'] += $match->awayScore;					
				}
			}
			
			print_r($standings);
			
			return;
			
//			$pool->Rounds
//			$q = Doctrine_Query::create()
//			    ->from('Round r')
//			    ->leftJoin('r.Matches m')
//			    ->where('r.pool_id = ?', $poolId)
//			    ->orderBy('r.rank ASC, m.rank ASC');
//			echo $q->getSqlQuery();
//			return;
//			echo $q->execute();			
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
		// sorted according to currentRank
		$poolteams=PoolTeam::getSortedTeamsByPool($pool->id);
		
		// fill in match ups
		$teamcounter=0;
		for ($i=0; $i < count($curRound->Matches); $i++) {
			$curRound->Matches[$i]->home_team_id = $pool->PoolTeams[$teamcounter++]->team_id;
			$curRound->Matches[$i]->away_team_id = $pool->PoolTeams[$teamcounter++]->team_id;	
			
			// fill in random scores for testing
			$curRound->Matches[$i]->homeScore = rand(0,15);
			$curRound->Matches[$i]->awayScore = rand(0,15);
			
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