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
	public function StandingsUpToRound($pool, $roundnr) {
		// initialize standings arrays
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('games' => 0, 'vp' => 0, 'opp_vp' => 0, 'margin' => 0, 'scored' => 0, 'spirit' => 0, 'rank' => 0);
		}

		if ($roundnr > 1) {
			
			for ($i=0; $i<$roundnr-1; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					echo $match->home_team_id." vs ".$match->away_team_id." was ".$match->homeScore." - ".$match->awayScore."<br>";
									
					
					// update home team stats
					$standings[$match->home_team_id]['games']++;					
					$standings[$match->home_team_id]['vp'] += VictoryPoints::getByMargin($match->homeScore - $match->awayScore);
					$standings[$match->home_team_id]['margin'] += $match->homeScore - $match->awayScore;
					$standings[$match->home_team_id]['scored'] += $match->homeScore;
					$standings[$match->home_team_id]['spirit'] += $match->homeSpirit;
					
					// update away team stats
					$standings[$match->away_team_id]['games']++;					
					$standings[$match->away_team_id]['vp'] += VictoryPoints::getByMargin($match->awayScore - $match->homeScore);
					$standings[$match->away_team_id]['margin'] += $match->awayScore - $match->homeScore;
					$standings[$match->away_team_id]['scored'] += $match->awayScore;
					$standings[$match->away_team_id]['spirit'] += $match->awaySpirit;					
				}
			}
			
			// compute sum of opponent's victory points
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					// update home team stats
					$standings[$match->home_team_id]['opp_vp'] += $standings[$match->away_team_id]['vp'];
					
					// update away team stats
					$standings[$match->away_team_id]['opp_vp'] += $standings[$match->home_team_id]['vp'];
				}
			}
			
			// sort standings according to #games, vp, opp_vp, margin, scored, spirit
			usort($standings, array($this,'CompareTeamsSwissdraw'));
			
			
						
			echo "<pre>";
			print_r($standings);
			echo "</pre>";
			
			
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

		// fill in ranks
		for ($i=0; $i<count($standings) ; $i++) {
			$standings[$i]['rank']=$i;
		}
		
		return $standings;
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


	private function CompareTeamsSwissdraw($a, $b)
	{//distinguish between first round and the rest
	
		if ($a['games']==1 && $b['games']==1){		
		//sort according to 
		// 1. victory points
		// 2. margin
		// 3. total points scored
		// 4. spirit score		
			if ($a['vp'] != $b['vp']) {
				return ($a['vp'] > $b['vp']) ? -1 : 1;
			} else {
				if ($a['margin'] != $b['margin']) {
					return ($a['margin'] > $b['margin']) ? -1 : 1;
				} else {
					if ($a['scored'] != $b['scored']) {
						return ($a['scored'] > $b['scored']) ? -1 : 1;
					} else {
						if ($a['spirit'] != $b['spirit']) {
							return ($a['spirit'] > $b['spirit']) ? -1 : 1;
						} else {
							return 0;
						}
					}
				}
			}		
		}else{
			//sort according to
			// 0. number of games 
			// 1. victory points
			// 2. opponent's victory points
			// 3. total points scored
			// 4. spirit score
			
			if ($a['games'] != $b['games']) {
				return ($a['games'] > $b['games']) ? -1 : 1;
			}else{
				if($a['vp'] != $b['vp']) {
					return ($a['vp'] > $b['vp']) ? -1 : 1;
				} else {
				if ($a['opp_vp'] != $b['opp_vp']) {
					return ($a['opp_vp'] > $b['opp_vp']) ? -1 : 1;
				} else {
					if ($a['scored'] != $b['scored']) {
						return ($a['scored'] > $b['scored']) ? -1 : 1;
					} else {
						if ($a['spirit'] != $b['spirit']) {
							return ($a['spirit'] > $b['spirit']) ? -1 : 1;
						} else {
							return 0;
						}
						}
					}	
				}
			}
		}
	}

}