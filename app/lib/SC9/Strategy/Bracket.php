<?php 


class SC9_Strategy_Bracket implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	const DEBUG = false;
	
	private function debprint($msg) {
		if (self::DEBUG) {
			print $msg."<br>";
		}
	}
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	public function getName() {
		return "Bracket";
	}
	
	public function calculateNumberOfRounds($teamCount) {
		$r = $teamCount;
		while($r > 1) {
			$this->numberOfRounds++;
			$r = $r / 2;
		}
		return $this->numberOfRounds;
	}
	
	public function standingsAfterRound($pool, $roundnr) {
		// initialize standings arrays
		// note that rank is initialized with seed, as we are computing everything from scratch
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'name' => $poolteam->Team->name, 'games' => 0, 'wins' => 0, 'losses' => 0, 'spirit' => 0, 'rank' => $poolteam->seed, 'seed' => $poolteam->seed);
		}
		
//		echo "<pre>";
//		print_r($standings);
//		echo "</pre>";
		
		if ($roundnr == 0) {
			// note that sorting destroys the link with the $team_id keys, so the counting code in the "else" part does not work
			// if we sort beforehand!
			
			// sort according to incoming rank 
			usort($standings, create_function('$a,$b','return $a[\'seed\']==$b[\'seed\']?0:($a[\'seed\']<$b[\'seed\']?-1:1);'));			
		} else {
			for ($i=0; $i < $roundnr; $i++) { // go through all rounds up to $roundnr	
				$curRound = $pool->Rounds[$i];
				// set wins and losses of all teams to 0
				foreach($pool->PoolTeams as $poolteam) {
					$standings[$poolteam->team_id]['wins'] = 0;
					$standings[$poolteam->team_id]['losses'] = 0;
				}				
				
				foreach($curRound->Matches as $match) {
					if ($match->home_team_id == null || $match->away_team_id == null) { break; }
					// update home team stats
					$standings[$match->home_team_id]['games']++;					
					$standings[$match->home_team_id]['spirit'] += $match->homeSpirit;				
					// update away team stats
					$standings[$match->away_team_id]['games']++;					
					$standings[$match->away_team_id]['spirit'] += $match->awaySpirit;
					if ($match->homeScore > $match->awayScore) {
						$standings[$match->home_team_id]['wins']++;
						$standings[$match->away_team_id]['losses']++;
					}elseif ($match->homeScore < $match->awayScore) {
						$standings[$match->home_team_id]['losses']++;
						$standings[$match->away_team_id]['wins']++;					
					}else {
						echo 'no ties allowed in playoffs, counting as home loss and continuing for testing purposes...';
						$standings[$match->home_team_id]['losses']++;
						$standings[$match->away_team_id]['wins']++;										
					}
	
					// update ranks
					$smallerrank = min($standings[$match->home_team_id]['rank'], $standings[$match->away_team_id]['rank']);
					$largerrank = max($standings[$match->home_team_id]['rank'], $standings[$match->away_team_id]['rank']);  
					if ($standings[$match->home_team_id]['wins'] < $standings[$match->away_team_id]['wins']) {
						$standings[$match->home_team_id]['rank']=$largerrank;
						$standings[$match->away_team_id]['rank']=$smallerrank;
					} elseif ($standings[$match->home_team_id]['wins'] > $standings[$match->away_team_id]['wins']) {
						$standings[$match->home_team_id]['rank']=$smallerrank;
						$standings[$match->away_team_id]['rank']=$largerrank;					
					} else {
						// if tied, ranks remain the same as they were before
					}
				} 
			}
			
			// sort standings according to rank and number of wins
			usort($standings, array($this,'CompareTeamsPlayoffs'));					
		}		

		// fill in ranks
//		$rank=1;
//		$standings[0]['rank']=1;  // assuming that it was sorted before, so the list starts with 0					
//		for ($i=1; $i<count($standings) ; $i++) {
//			if ($this->CompareTeamsPlayoffs($standings[$i-1],$standings[$i])!=0) {
//				$rank=$i+1;
//			}
//			$standings[$i]['rank']=$rank;		
//		}
		
		return $standings;
		
	}
	
	
	public function createMatchups($pool) {
		$curRoundNr = $pool->currentRound;		
		$curRound = $pool->Rounds[$curRoundNr-1];
		
		$nrTeams=count($pool->PoolTeams);
		$nrRounds=$this->calculateNumberOfRounds($nrTeams);
		
		// delete matchups and results of current round and all following rounds of the pool
		foreach($pool->Rounds as $round) {
			if ($round->rank >= $curRoundNr) {
				for ($i=0; $i < count($round->Matches); $i++) {
					$round->Matches[$i]->home_team_id = null;
					$round->Matches[$i]->away_team_id = null;	
					$round->Matches[$i]->homeScore = null;
					$round->Matches[$i]->awayScore = null;					
					$round->save();
				}		
			}
		};
				
		$this->debprint("number of matches: ".count($curRound->Matches));
		
		// get standings up to currentRound
		$standings = $this->StandingsAfterRound($pool, $curRoundNr-1);
		
		// fill in matchups
		if (Brackets::getMatchup($nrTeams, $nrRounds, 1, 1) != false)  { 
			// we know what to do
			// assuming that when the first matchup for the first round is defined, 
			// then the rest of the bracket is defined as well
			for($i=0; $i < count($round->Matches); $i++) { // go through all matches
				$matchup = Brackets::getMatchup($nrTeams, $nrRounds, $curRoundNr, $i+1);
				$curRound->Matches[$i]->home_team_id = $standings[$matchup['home']-1]['team_id'];
				$curRound->Matches[$i]->away_team_id = $standings[$matchup['away']-1]['team_id'];				

				// fill in random scores for testing				
				$curRound->Matches[$i]->homeScore = rand(0,15);
				$curRound->Matches[$i]->awayScore = rand(0,15);							
			}
		} else { // we don't know what to do
			die('no bracket structure defined yet');
		}
		
		$curRound->save();		
		
		$this->debprint("number of matches: ".count($curRound->Matches));
		
		// increase current round
		$this->calculateNumberOfRounds(count($pool->PoolTeams));
		if ($curRoundNr < $this->numberOfRounds) { 
			$pool->currentRound = ($curRoundNr + 1);
		} else { // or set to 0 if total number of rounds is reached
			$pool->currentRound = 0;
		}
		$pool->save();
		
	}
	
	private function compareTeamsPlayoffs($a, $b) {
		//sort according to 
		// 1. rank
		// 2. number of wins
		if ($a['rank'] != $b['rank']) {
			return ($a['rank'] < $b['rank']) ? -1 : 1;
		} else {
			if ($a['wins'] != $b['wins']) {
				return ($a['wins'] > $b['wins']) ? -1 : 1;
			} else { return 0; }			
		}
	}
	
}