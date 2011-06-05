<?php 


class SC9_Strategy_Bracket implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	public function getName() {
		return "Bracket";
	}
	
	public function calculateNumberOfRounds($nrTeams) {
		// check if there is such a bracket structure
		
		$this->numberOfRounds = Brackets::getNrOfRounds($nrTeams);		
//		
//		$this->numberOfRounds=0;
//		$r = $teamCount;
//		while($r > 1) {
//			$this->numberOfRounds++;
//			$r = $r / 2;
//		}

//		echo "hello ".Brackets::getNrOfRounds($nrTeams)."<br>";
		return $this->numberOfRounds;
	}
	
	public function nameMatches($pool) {
		FB::log('naming matches in Bracket');
		
		$nrTeams=$pool->spots;
		$nrRounds=$this->calculateNumberOfRounds($nrTeams);
		
		FB::log('nrTeams '.$nrTeams. ', nrRounds '.$nrRounds);
		
		$matchup=Brackets::getMatchupByRank(9, 3, 2, 5);
		FB::log('test '.$matchup['home'].$matchup['away']);
		
		if (Brackets::getMatchup($nrTeams, $nrRounds, 1, 1) != false)  { 
				for($j=0 ; $j<$nrRounds; $j++) { // go through rounds
				// we know what to do
				// assuming that when the first matchup for the first round is defined, 
				// then the rest of the bracket is defined as well
					for($i=0; $i < count($pool->Rounds[0]->Matches); $i++) { // go through all matches
						$matchup = Brackets::getMatchup($nrTeams, $nrRounds, $j+1, $i+1);
						$pool->Rounds[$j]->Matches[$i]->homeName = ($matchup['home'] === null ? "BYE" : Brackets::getOrigin($nrTeams, $nrRounds, $j+1, $matchup['home']));
						$pool->Rounds[$j]->Matches[$i]->awayName = ($matchup['away'] === null ? "BYE" : Brackets::getOrigin($nrTeams, $nrRounds, $j+1, $matchup['away']));
						$pool->Rounds[$j]->Matches[$i]->matchName = Brackets::getName($j+1, $nrRounds)." ".(($matchup['home'] === null || $matchup['away'] === null) ? "BYE match" : ($i+1));

						// fill in possible ranks
						$offsetRank = $pool->offsetRank();
						$possibleRanks=Brackets::getPossibleRanks($nrTeams, $nrRounds, $j+1, $i+1);
						$pool->Rounds[$j]->Matches[$i]->bestPossibleRank = $possibleRanks['best']+$offsetRank; 
						$pool->Rounds[$j]->Matches[$i]->worstPossibleRank = $possibleRanks['worst']+$offsetRank; 						
					}
				}
				$pool->save();
		} else { // we don't know what to do
			die('no bracket structure defined yet');
		}		
		
	}
	
	
	public function standingsAfterRound($pool, $roundnr) {

		// TODO: cope with requests of too high $roundnr
		// make sure only rounds that are played are taken into account
		
		FB::group('compute Bracket standings of pool '.$pool->id.' after round '.$roundnr);
		
		$nrTeams=count($pool->PoolTeams);
		if ($nrTeams == 0) {
			return null;
		}
		$nrRounds=$this->calculateNumberOfRounds($nrTeams);
		
		
		// initialize standings arrays
		// note that rank is initialized with seed, as we are computing everything from scratch
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'name' => $poolteam->Team->name, 'games' => 0, 'wins' => 0, 'losses' => 0, 'spirit' => 0, 'rank' => $poolteam->seed, 'seed' => $poolteam->seed);
		}
		
//		echo "<pre>";
//		print_r($standings);
//		echo "</pre>";
		
		if ($roundnr == -1) {
			FB::groupEnd();
			return null;
		} elseif ($roundnr == 0) {
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
					if ($match->home_team_id === null) {
						// BYE - awayTeam:
						// just check if we need to adjust the final rank
						$matchup=Brackets::getMatchup($nrTeams, $nrRounds, $i+1, $match->rank);
						if (!is_null($matchup['winplace'])) {
							$standings[$match->away_team_id]['rank']=$matchup['winplace'];
						}												
						
					}elseif ($match->away_team_id === null) {
						// homeTeam - BYE:
						// just check if we need to adjust the final rank
						$matchup=Brackets::getMatchup($nrTeams, $nrRounds, $i+1, $match->rank);
						if (!is_null($matchup['winplace'])) {
							$standings[$match->home_team_id]['rank']=$matchup['winplace'];
						}						
												
					}else { 
						// regular game:
					
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
						
						// also check if there is a final rank assignment in the Brackets DB (and apply it)
						$matchup=Brackets::getMatchup($nrTeams, $nrRounds, $i+1, $match->rank);
						
						// a quick sanity check
						$smaller=min($matchup['home'],$matchup['away']);
						$bigger=max($matchup['home'],$matchup['away']);
						if ($smaller != $smallerrank || $bigger != $largerrank) {
							die('we are not looking up the right matchup');
						}
						
						if ($standings[$match->home_team_id]['wins'] < $standings[$match->away_team_id]['wins']) {
							$standings[$match->home_team_id]['rank']=$largerrank;
							$standings[$match->away_team_id]['rank']=$smallerrank;
							if ($matchup['winplace'] != null) {
								$standings[$match->away_team_id]['rank']=$matchup['winplace'];
							}
							if ($matchup['loseplace'] != null) {
								$standings[$match->home_team_id]['rank']=$matchup['loseplace'];							
							}												
						} elseif ($standings[$match->home_team_id]['wins'] > $standings[$match->away_team_id]['wins']) {
							$standings[$match->home_team_id]['rank']=$smallerrank;
							$standings[$match->away_team_id]['rank']=$largerrank;
							if ($matchup['winplace'] != null) {
								$standings[$match->home_team_id]['rank']=$matchup['winplace'];
							}
							if ($matchup['loseplace'] != null) {
								$standings[$match->away_team_id]['rank']=$matchup['loseplace'];							
							}												
						} else {
							// if tied, ranks remain the same as they were before
						}
											
					}					
				} 
			}
			
//			echo "<pre>";
//			print_r($standings);
//			echo "</pre>";
			
			// sort standings according to rank and number of wins
			usort($standings, array($this,'CompareTeamsPlayoffs'));					
		}		

		// fill in ranks in PoolTeams
		for ($i=0; $i<count($standings) ; $i++) {
			$poolteam = PoolTeam::getBySeed($pool->id, $standings[$i]['seed']);
			$poolteam['rank']=$i+1;
			$poolteam->save();
		}					
		
		FB::table('standings',$standings);
		FB::groupEnd();
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
					// or use unlink here?
//					$round->Matches[$i]->unlink('HomeTeam');
//					$round->Matches[$i]->unlink('AwayTeam');
					$round->Matches[$i]->home_team_id = null;
					$round->Matches[$i]->away_team_id = null;
					$round->Matches[$i]->homeScore = null;
					$round->Matches[$i]->awayScore = null;					
					$round->save();
				}		
			}
		};
				
		FB::log("number of matches: ".count($curRound->Matches));
		
		// get standings up to currentRound
		$standings = $this->StandingsAfterRound($pool, $curRoundNr-1);
		
		// fill in matchups
		if (Brackets::getMatchup($nrTeams, $nrRounds, 1, 1) != false)  { 
			// we know what to do
			// assuming that when the first matchup for the first round is defined, 
			// then the rest of the bracket is defined as well
			for($i=0; $i < count($round->Matches); $i++) { // go through all matches
				$matchup = Brackets::getMatchup($nrTeams, $nrRounds, $curRoundNr, $i+1);
				
				if (!is_null($matchup['home'])) {
					$curRound->Matches[$i]->link('HomeTeam', array($standings[$matchup['home']-1]['team_id']));
				}
				if (!is_null($matchup['away'])) {
					$curRound->Matches[$i]->link('AwayTeam', array($standings[$matchup['away']-1]['team_id']));
				}

				$curRound->Matches[$i]->save();
				
				// fill in random scores for testing	
//				if (!is_null($matchup['home']) && !is_null($matchup['away'])) {			
//					$curRound->Matches[$i]->homeScore = rand(0,15);
//					$curRound->Matches[$i]->awayScore = rand(0,15);
//					$curRound->Matches[$i]->scoreSubmitTime = time();
//				}							
			}
		} else { // we don't know what to do
			die('no bracket structure defined yet');
		}
		
		$curRound->save();		
		
		FB::log("number of matches: ".count($curRound->Matches));
		
		// increase current round
//		$this->calculateNumberOfRounds(count($pool->PoolTeams));
//		$pool->currentRound = ($curRoundNr + 1);
//		$pool->save();
		
	}
	public function createSMS($pool,$roundId) {
		// generates SMS for round with id $roundId		
		$round=Round::getRoundById($roundId);
		FB::log('creating SMS for roundId '.$roundId.' and rank '.$round->rank.' round->id '.$round->id);
				
		if ($round->rank > 1) {
			$previousRound=Round::getRoundByRank($round->pool_id, $round->rank-1);
			$standings=$this->standingsAfterRound($pool, $round->rank-1);
		} else {
			foreach($pool->SourceMoves as $move) {
				FB::table('move',$move);
			}
			exit;
			$previousRound=$pool->SourcePool->Rounds[count($pool->SourcePool->Rounds)];
			$standings=false;
		}
		
		// go through all matches of $round
		foreach($round->Matches as $match) {
			$this->createSMSForTeam($previousRound, $round, $standings, $match->HomeTeam, $match->AwayTeam, $match);
			$this->createSMSForTeam($previousRound, $round, $standings, $match->AwayTeam, $match->HomeTeam, $match);			
		}
		
	}
	
	private function createSMSForTeam($previousRound,$round,$standings,$team,$opponent_team,$match) {
		// After a 15-2 loss in round 1, you are now ranked 12th. In round 2,
        // you'll play "Ultimate Kaese" (ranked 13th) on Field 1 at 12:30.

		// check if the next game is "tomorrow"
		$previousGameTime=$this->getPlayingTimeInRound($round, $team->id);
		$previousGameTimeComponents = date_parse(date("Y-m-d H:i", $previousGameTime));
		$thisGameTimeComponents = date_parse(date("Y-m-d H:i", $match->scheduledTime));
		if ($previousGameTimeComponents['day'] != $thisGameTimeComponents['day']) {
			$tomorrow = true;
		} else {
			$tomorrow = false;
		}
		
		if ($round->rank > 1) {
			$text = "After a ";
			$text .= $this->getResultInRound($previousRound,$team->id);
			$text .= ' in round '.$previousRound->rank.', you are now ranked ';
			$text .= SMS::addOrdinalNumberSuffix($this->getRankInStanding($standings,$team->id)).".";
		} else {
			$text = "Welcome to Windmill Windup 2011!";
		}
		$text .= 'In round '.$round->rank;
		if ($opponent_team->byeStatus == 1) {
			// TODO: fill in the actual forfeit score from the pool
			$text .=  ",you can take a break due to the odd number of teams.You'll score a 15-12 win";
		} else {
			$text .= ",you'll play ";
			$text .= $opponent_team->name;
			if ($round->rank>1) {
				$text .= "(ranked ";
				$text .= SMS::addOrdinalNumberSuffix($this->getRankInStanding($standings,$opponent_team->id)).")";
			}
			$text .= " on Field ".$match->field_id;
			if ($tomorrow) {
				$text .= 'tomorrow ';
			}
			$text .= 'at '.$match->scheduledTime;
		}
		if ($tomorrow) {
			$text .= ".Please hand in today's spirit scores!";
		}			
		

		FB::group('sms for team '.$team->name.':');
		FB::log($text);
		$sms = New SMS();
		$sms->message = $text;
		$sms->createTime=time();
		$sms->link('Team', array($team->id));
		$sms->link('Round',array($round->id));	
		$sms->save();
			
		FB::groupEnd();
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