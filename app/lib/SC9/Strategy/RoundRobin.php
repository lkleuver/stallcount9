<?php 


class SC9_Strategy_Roundrobin implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	public function getName(){
		return "RoundRobin";
	}
	
	public function calculateNumberOfRounds($teamCount) {
		if ($teamCount%2 == 0) { // nr of teams even
			$this->numberOfRounds = $teamCount - 1;
		} else { // nr of teams odd
			$this->numberOfRounds = $teamCount;
		}		
		return $this->numberOfRounds;
	}
	
	public function nameMatches($pool) {
		$this->createMatchups($pool,true);
	}
	
	public function createMatchups($pool,$naming=false) {
		// in Round Robin: matchups for all rounds can be created once and for all
		
		// therefore, if the first match is filled in, all of them should be filled in
		if ($pool->Rounds[1]->Matches[1]->home_team_id != null) {
			echo "matchups have already been created. Previous games will be overwritten now! <br>";
		}
		
		FB:: log("naming is ".(($naming) ? "on" : "off"));
		
		// we follow the algorithm described on http://en.wikipedia.org/wiki/Round-robin_tournament
		// If n is the number of competitors, a pure round robin tournament requires \begin{matrix} 
		// \frac{n}{2} \end{matrix}(n - 1) games. If n is even, then in each of (n - 1) rounds, 
		// \begin{matrix} \frac{n}{2} \end{matrix} games can be run in parallel, provided there 
		// exist sufficient resources (e.g. courts for a tennis tournament). If n is odd, there will be 
		// n rounds with \begin{matrix} \frac{n - 1}{2} \end{matrix} games, and one competitor having 
		// no game in that round.

		// The standard algorithm for round-robins is to assign each competitor a number, and pair them off in the first round …
		//
		//Round 1. (1 plays 14, 2 plays 13, ... )
		// 1  2  3  4  5  6  7
		// 14 13 12 11 10 9  8
		//
		//… then fix one competitor (number one in this example) and rotate the others clockwise …
		//
		//Round 2. (1 plays 13, 14 plays 12, ... )
		// 1  14 2  3  4  5  6
		// 13 12 11 10 9  8  7
		//
		//Round 3. (1 plays 12, 13 plays 11, ... )
		// 1  13 14 2  3  4  5
		// 12 11 10 9  8  7  6
		//
		// until you end up almost back at the initial position
		//
		//Round 13. (1 plays 2, 3 plays 14, ... )
		// 1  3  4  5  6  7  8
		// 2 14  13 12 11 10 9
		//
		// If there are an odd number of competitors, a dummy competitor can be added, whose scheduled opponent in a 
		// given round does not play and has a bye. The schedule can therefore be computed as though the dummy were 
		// an ordinary player, either fixed or rotating. The upper and lower rows can indicate home/away in sports, 
		// white/black in chess, etc.; to ensure fairness, this must alternate between rounds since competitor 1 
		// is always on the first row. If, say, competitors 3 and 8 were unable to fulfill their fixture in the 
		// third round, it would need to be rescheduled outside the other rounds, since both competitors would 
		// already be facing other opponents in those rounds. More complex scheduling constraints may require more complex algorithms.
		
		
		// initialize first row with team_id's of first half of teams
		// initialize second row with team_id's of second half of teams
		
		$nrTeams = count($pool->PoolTeams);  // might be zero if no teams have been moved into this pool yet
		if ($nrTeams == 0 && !$naming) {
			die('number of teams should not be zero when we are not just naming matches');
		}
		
		for ($i=0 ; $i<$nrTeams/2 ; $i++) {
			$row1[]=$pool->PoolTeams[$i]->team_id;
			if ($i+ceil($nrTeams/2) < $nrTeams) {
				$row2[]=$pool->PoolTeams[$i+ceil($nrTeams/2)]->team_id; 
			} else {  
				$row2[]=null; // add a BYE team
			}
		}
		
		if ($naming) { // no teams have been filled in so far
			$nrTeams=$pool->spots;			
			for ($i=0 ; $i < $nrTeams/2 ; $i++) {
				$row1[]=$i+1;
				if ($i+ceil($nrTeams/2) < $nrTeams) {
					$row2[]=$i+ceil($nrTeams/2)+1; 
				} else {  
					$row2[]=null; // add a BYE team
				}
			}
		}
		
		FB::table('row1',$row1);
		FB::table('row2',$row2);
		
		if ($this->numberOfRounds == 0) { 
			$this->numberOfRounds = $this->calculateNumberOfRounds($nrTeams); 
		}
		
		for ($i=0 ; $i<$this->numberOfRounds ; $i++) {
			// read of pairings of this round
			for ($j=0 ; $j < ceil($nrTeams/2) ; $j++) {
				if ($naming) {
					$pool->Rounds[$i]->Matches[$j]->homeName = (($row1[$j]>0) ? "Team ".$row1[$j] : "BYE");
					$pool->Rounds[$i]->Matches[$j]->awayName = (($row2[$j]>0) ? "Team ".$row2[$j] : "BYE");

					$pool->Rounds[$i]->Matches[$j]->matchName = (($row1[$j]*$row2[$j]>0) ? "Match rank ".($j + 1) : "BYE match");
				} else {
					$pool->Rounds[$i]->Matches[$j]->link('HomeTeam', array($row1[$j]));
					$pool->Rounds[$i]->Matches[$j]->link('AwayTeam', array($row2[$j]));
					$pool->Rounds[$i]->Matches[$j]->save();
//					$pool->Rounds[$i]->Matches[$j]->home_team_id = $row1[$j];
//					$pool->Rounds[$i]->Matches[$j]->away_team_id = $row2[$j];
	
					if ($pool->Rounds[$i]->Matches[$j]->away_team_id != null && $pool->Rounds[$i]->Matches[$j]->home_team_id != null) {
						// fill in random scores for testing
						$pool->Rounds[$i]->Matches[$j]->homeScore = rand(0,15);
						$pool->Rounds[$i]->Matches[$j]->awayScore = rand(0,15);	
						$pool->Rounds[$i]->Matches[$j]->scoreSubmitTime = time();
					}
				}

			}
			
			// shift all but the first element of the first row by one				
			$lastElementRow1=array_pop($row1);     // pop last element off the first row			
			array_push($row2,$lastElementRow1);   // push it onto the end of second row

			$firstElementRow2=array_shift($row2);  // pop first element off the second row			
			$firstElementRow1=array_shift($row1);  // temporarily save first element of first row
			array_unshift($row1,$firstElementRow2); // fill up the first row again
			array_unshift($row1,$firstElementRow1);

			FB::log("after Round ".($i+1));
			FB::table('row1',$row1);
			FB::table('row2',$row2);
			
			
		}
		
		
		$pool->save();
		
	}
	
	public function standingsAfterRound($pool, $roundnr) {
				
		// initialize standings arrays
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'name' => $poolteam->Team->name, 'games' => 0, 'points' => 0, 'margin' => 0, 'scored' => 0, 'spirit' => 0, 'rank' => $poolteam->rank, 'seed' => $poolteam->seed);
		}
		
		if ($roundnr == 0) {
			// note that sorting destroys the link with the $team_id keys, so the counting code in the "else" part does not work
			// if we sort beforehand!
			
			// sort according to incoming seed 
			usort($standings, create_function('$a,$b','return $a[\'seed\']==$b[\'seed\']?0:($a[\'seed\']<$b[\'seed\']?-1:1);'));			
		} else {
			
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					
					if ($match->scoreSubmitTime != null && $match->home_team_id != null & $match->away_team_id != null) {
						// update home team stats
						$standings[$match->home_team_id]['games']++;					
						$standings[$match->home_team_id]['margin'] += $match->homeScore - $match->awayScore;
						$standings[$match->home_team_id]['scored'] += $match->homeScore;
						$standings[$match->home_team_id]['spirit'] += $match->homeSpirit;
						
						// update away team stats
						$standings[$match->away_team_id]['games']++;					
						$standings[$match->away_team_id]['margin'] += $match->awayScore - $match->homeScore;
						$standings[$match->away_team_id]['scored'] += $match->awayScore;
						$standings[$match->away_team_id]['spirit'] += $match->awaySpirit;					
	
						if ($match->homeScore > $match->awayScore) {
							$standings[$match->home_team_id]['points'] += 2;
						}elseif ($match->homeScore < $match->awayScore) {
							$standings[$match->away_team_id]['points'] += 2;					
						}else {
							$standings[$match->home_team_id]['points'] += 1;
							$standings[$match->away_team_id]['points'] += 1;										
						}
					}
					
				}
			}
			
			// sort standings according to #games, vp, opp_vp, margin, scored, spirit
			usort($standings, array($this,'CompareTeamsRoundRobin'));
						
		}

		// fill in ranks, also in PoolTeam
		$rank=1;
		$standings[0]['rank']=1;  // assuming that it was sorted before, so the list starts with 0
		$poolteam = PoolTeam::getBySeed($pool->id, $standings[0]['seed']);
		$poolteam['rank']=$rank;
		$poolteam->save();					
	
		for ($i=1; $i<count($standings) ; $i++) {
			if ($this->CompareTeamsRoundRobin($standings[$i-1],$standings[$i])!=0) {
				$rank=$i+1;
			}
			$standings[$i]['rank']=$rank;

			$poolteam = PoolTeam::getBySeed($pool->id, $standings[$i]['seed']);
			$poolteam['rank']=$rank;
			$poolteam->save();					
		}
		
		return $standings;
		
	}
	
	public function createSMS($pool,$roundId) {
		return null;
	}
	

	private function compareTeamsRoundRobin($a, $b) {
	
		//sort according to
		// 1. points
		// 2. margin
		// 3. total points scored
		// 4. spirit score
		// 5. less number of games
			
		if($a['points'] != $b['points']) {
			return ($a['points'] > $b['points']) ? -1 : 1;
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
						if ($a['games'] != $b['games']) {
							return ($a['games'] < $b['games']) ? -1 : 1;
						}else{
							return 0;
						}
					}
				}	
			}
		}
	}
	
}