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
	
	public function nameMatches($pool) {
		// assumes that $nrOfRounds is computed
		if ($this->numberOfRounds == 0) { 
			die('number of rounds in swissdraw pool should never be set to 0'); 
		}
		
		$nrTeams=$pool->spots;			
		if ($nrTeams%2==1) {
			FB::error('Swissdraw naming / scheduling','number of spots in a Swissdraw pool should always be even!');
		}
		
		$teamcount=0;
		// first round Swissdraw is different
		for ($j=0 ; $j < $nrTeams/2 ; $j++) {
			$pool->Rounds[0]->Matches[$j]->homeName = "Seed ".++$teamcount;
			$pool->Rounds[0]->Matches[$j]->awayName = "Seed ".($teamcount+($nrTeams/2));
			$pool->Rounds[0]->Matches[$j]->matchName = "Match rank ".($j+1);
		}
		
		// BYE business:
		if ($pool->byeRank()>0) {
			// the last game is the BYE game
			$j=$nrTeams/2 -1;
			$pool->Rounds[0]->Matches[$j]->awayName = "BYE";
			$pool->Rounds[0]->Matches[$j]->matchName = "BYE Match Round 1";
		}
				
		// second and following rounds are the same
		for ($i=1 ; $i<$this->numberOfRounds ; $i++) {
			// read off pairings of this round
			$teamcount=0;
			for ($j=0 ; $j < $nrTeams/2 ; $j++) {
				$pool->Rounds[$i]->Matches[$j]->homeName = "Round ".$i." aprx rank ".++$teamcount;
				$pool->Rounds[$i]->Matches[$j]->awayName = "Round ".$i." aprx rank ".++$teamcount;
				$pool->Rounds[$i]->Matches[$j]->matchName = "Match rank ".($j+1);
			}

			// BYE business:
			if ($pool->byeRank()>0) {
				// let's say that the last game is the BYE game
				$j=$nrTeams/2 -1;				
				$pool->Rounds[$i]->Matches[$j]->homeName = "Round ".$i." team";
				$pool->Rounds[$i]->Matches[$j]->awayName = "BYE";
				$pool->Rounds[$i]->Matches[$j]->matchName = "BYE Match Round ".$i;
			}
			
		}

		$pool->save();
					
	}
	
	/**
	 * gives back a multi-dimensional array $standings
	 * containing the $standings after round $roundnr
	 * 
	 * $roundnr=0 is allowed
	 * 
	 * @author Chris
	 *
	 */	
	public function standingsAfterRound($pool, $roundnr) {
		
		FB::group('compute Swissdraw standings of pool '.$pool->id.' after round '.$roundnr);
		if (count($pool->PoolTeams) == 0) {
			echo "no teams in Pool yet. Perform move first!";
			FB::error('no teams in Pool yet. Perform move first!');
			FB::groupEnd();
			return null;
		}
		// initialize standings arrays
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'byeStatus' => $poolteam->Team->byeStatus, 'name' => $poolteam->Team->name, 'games' => 0, 'vp' => 0, 'opp_vp' => 0, 'margin' => 0, 'scored' => 0, 'spirit' => 0, 'rank' => $poolteam->rank, 'seed' => $poolteam->seed);
		}
		
		if ($roundnr == -1) {
			FB::groupEnd();
			return null;
		} elseif ($roundnr == 0) {
			// note that sorting destroys the link with the $team_id keys, so the counting code in the "else" part does not work
			// if we sort beforehand!
			
			// sort according to seed 
			usort($standings, create_function('$a,$b','return $a[\'seed\']==$b[\'seed\']?0:($a[\'seed\']<$b[\'seed\']?-1:1);'));			
		} else {
			
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
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
			}
			
			// compute sum of opponent's victory points
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
					if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
						// update home team stats
						$standings[$match->home_team_id]['opp_vp'] += $standings[$match->away_team_id]['vp'];					
						// update away team stats
						$standings[$match->away_team_id]['opp_vp'] += $standings[$match->home_team_id]['vp'];
					}
				}
			}
			
			// sort standings according to #games, vp, opp_vp, margin, scored, spirit
			usort($standings, array($this,'CompareTeamsSwissdraw'));
						
		}

		
		// fill in ranks, also in PoolTeam
		$rank=1;
		$standings[0]['rank']=1;  // assuming that it was sorted before, so the list starts with 0					
		$poolteam = PoolTeam::getBySeed($pool->id, $standings[0]['seed']);
		$poolteam['rank']=1;
		$poolteam->save();		
		for ($i=1; $i<count($standings) ; $i++) {
			if ($this->CompareTeamsSwissdraw($standings[$i-1],$standings[$i])!=0) {
				$rank=$i+1;
			}
			$standings[$i]['rank']=$rank;
			
			$poolteam = PoolTeam::getBySeed($pool->id, $standings[$i]['seed']);
			$poolteam['rank']=$rank;
			$poolteam->save();		
		}
		FB::table('standings after round '.$roundnr,$standings);
		
		FB::groupEnd();
		return $standings;
	}
	
	
	public function createMatchups($pool) {
		$curRoundNr = $pool->currentRound;
		$curRound = $pool->Rounds[$curRoundNr-1];
		$nrTeams = count($pool->PoolTeams);
		
		FB::log('creating matchups for pool with id '.$pool->id.' round '.$curRoundNr);
		if ($nrTeams %2 == 1) {
			FB::log('$nrTeams '.$nrTeams);
			FB::error('number of teams in Swissdraw pool has to be even');
		}
		
		// delete matchups and results of current round and all following rounds of the pool
		foreach($pool->Rounds as $round) {
			if ($round->rank >= $curRoundNr) {
				for ($i=0; $i < count($round->Matches); $i++) {					
					$round->Matches[$i]->home_team_id =  null; // TODO: or do we want to use unlink here???
					$round->Matches[$i]->away_team_id =  null;	
					$round->Matches[$i]->homeScore = null;
					$round->Matches[$i]->awayScore = null;					
					$round->save();
				}		
			}
		};
		
		
		// get standings up to currentRound
		$standings = $this->StandingsAfterRound($pool, $curRoundNr-1);
		FB::table('initial standings after round '.$curRoundNr-1,$standings);
		
		// first Swissdraw round has different pairings, 
		// namely, for 2n teams, 1 plays n+1, 2 plays n+2 etc.
		if($curRoundNr==1) {
			$teamcounter=0;
			for ($i=0; $i < count($curRound->Matches); $i++) {
				$curRound->Matches[$i]->link('HomeTeam', array($standings[$teamcounter++]['team_id']));
				$curRound->Matches[$i]->link('AwayTeam', array($standings[($teamcounter+($nrTeams/2))-1]['team_id']));
				$curRound->Matches[$i]->save();
				
				if ($curRound->Matches[$i]->HomeTeam->byeStatus == 1) {
					FB::log('filling automatic scores for home BYE team');
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeAgainst;					
				}elseif ($curRound->Matches[$i]->AwayTeam->byeStatus == 1) {
					FB::log('filling automatic scores for away BYE team');
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeAgainst;
				} else {				
					// fill in random scores for testing
//					$curRound->Matches[$i]->homeScore = rand(0,15);
//					$curRound->Matches[$i]->awayScore = rand(0,15);
				}
				
			}	
			$curRound->save();									
		} else {			
			// the goal is to swap around teams in $standings until we arrive at new standings where
			// 1-2, 3-4, 5-6 etc. are valid matchups (i.e. they have not played each other before) 
			FB::group('trying to find a valid arrangement');
			$forward=true;
			$roundcounter=0;			
			$foundValidArrangement=$this->AdjustForDuplicateGames($standings,$pool,$forward);
							
			while(!$foundValidArrangement && $roundcounter <= count($standings)*2){
				$forward=!$forward;
				FB::group("round ".$roundcounter.", going ".($forward ? "forward" : "backward"));
				
				$foundValidArrangement = $this->AdjustForDuplicateGames($standings,$pool, $forward);
				$roundcounter++;
				FB::groupEnd();
			}
			FB::groupEnd();
			if (!$foundValidArrangement) { // TODO: find something better than this skipping shit
				FB::group("could not find a valid arrangment of teams with the standard procedure, trying skipping tricks");
				$roundcounter=0;
				$skip=rand(1,2);  // counter that is decreased with every skip action
				while(!$foundValidArrangement && $roundcounter <= count($standings)*10){
					$forward=!$forward;
					FB::group("round ".$roundcounter.", going ".($forward ? "forward" : "backward"));
					
					$foundValidArrangement = $this->AdjustForDuplicateGames($standings,$pool, $forward, $skip);
					FB::groupEnd();
					$roundcounter++;
					if ($roundcounter %count($standings)==0) {
						$skip=rand(1,4);						
						FB::log('reinitializing skip to '.$skip);
					}					
				}
				FB::groupEnd();
				
				if (!$foundValidArrangement) {
					die ('one try of skipping did not help: could still not find a valid arrangment of teams ');
				}
			}		
			
			// fill in matchups
			// ERROR: this procedure goes wrong when the BYE match is already the last match. Then it is not found previously.			 			
//			$teamcounter=0;
//			$byeHomeRank=0;
//			$byeAwayRank=0;
//			for ($i=0; $i < count($curRound->Matches); $i++) {
//				
//				FB::log('teamcounter '.$teamcounter.'  vs total nb in standings '.count($standings),' i is '.$i);
//				
//				if ($i == count($curRound->Matches)-1 && $byeHomeRank > 0) {
//					// if last round and previously found a matchup with BYE
//					// then fill it in here 
//					assert($byeAwayRank>0);
//					$curRound->Matches[$i]->link('HomeTeam', array($standings[$byeHomeRank]['team_id']));
//					$curRound->Matches[$i]->link('AwayTeam', array($standings[$byeAwayRank]['team_id']));
//					$curRound->Matches[$i]->save();
//
//					if ($curRound->Matches[$i]->HomeTeam->byeStatus == 1) {
//						FB::log('filling automatic scores for home BYE team');
//						$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeScore;
//						$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeAgainst;					
//					}elseif ($curRound->Matches[$i]->AwayTeam->byeStatus == 1) {
//						FB::log('filling automatic scores for away BYE team');
//						$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeScore;
//						$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeAgainst;
//					}
//				} else {
//					if ($standings[$teamcounter]['byeStatus'] == 1 || $standings[$teamcounter+1]['byeStatus'] == 1) {
//						$byeHomeRank=$teamcounter++;
//						$byeAwayRank=$teamcounter++;
//					}
//					
//					// otherwise, just fill in the matchup normally
//					$curRound->Matches[$i]->link('HomeTeam', array($standings[$teamcounter++]['team_id']));
//					$curRound->Matches[$i]->link('AwayTeam', array($standings[$teamcounter++]['team_id']));
//					$curRound->Matches[$i]->save();
//				}
//				$curRound->save();		
//			}

			// let's do it better! It should work for both the cases with and without BYE match
			// go through available matches, we know that BYE match is at the end, if there is one
			$teamcounter=0;
			$byeHomeRank=0;
			$byeAwayRank=0;
			for ($i=0; $i < count($curRound->Matches); $i++) {
				
				FB::log('teamcounter '.$teamcounter.'  vs total nb in standings '.count($standings),' i is '.$i);

				if ($byeHomeRank ==0 && ($standings[$teamcounter]['byeStatus'] == 1 || $standings[$teamcounter+1]['byeStatus'] == 1)) {
					$byeHomeRank=$teamcounter++;
					$byeAwayRank=$teamcounter++;
					// skipping these guys
				}
				
				if ($teamcounter < count($standings)-1) {
					$curRound->Matches[$i]->link('HomeTeam', array($standings[$teamcounter++]['team_id']));
					$curRound->Matches[$i]->link('AwayTeam', array($standings[$teamcounter++]['team_id']));
					$curRound->Matches[$i]->save();
				}
				
			}
			
			if ($byeAwayRank > 0) {  // we previously founda BYE matchup
				assert($byeHomeRank>0);
				$lastMatch=$curRound->Matches[count($curRound->Matches)-1];
				assert($lastMatch->home_team_id === null); // we should have skipped that match above
				assert($lastMatch->away_team_id === null); // we should have skipped that match above
				
				FB::log('filling in matchups for BYE match');
				$lastMatch->link('HomeTeam', array($standings[$byeHomeRank]['team_id']));
				$lastMatch->link('AwayTeam', array($standings[$byeAwayRank]['team_id']));
				$lastMatch->save();

				if ($lastMatch->HomeTeam->byeStatus == 1) {
					FB::log('filling automatic scores for home BYE team');
					$lastMatch->homeScore = $pool->PoolRuleset->byeScore;
					$lastMatch->awayScore = $pool->PoolRuleset->byeAgainst;					
				}elseif ($lastMatch->AwayTeam->byeStatus == 1) {
					FB::log('filling automatic scores for away BYE team');
					$lastMatch->awayScore = $pool->PoolRuleset->byeScore;
					$lastMatch->homeScore = $pool->PoolRuleset->byeAgainst;
				}
				$lastMatch->save();				
			}
			
			
		}
		
		// increase current round
//		$pool->currentRound = ($curRoundNr + 1);
//		$pool->save();
	}
	
	public function createSMS($pool,$roundId) {
		// generates SMS for round with id $roundId		
		$round=Round::getRoundById($roundId);
		$text='';
		
		FB::log('roundId '.$roundId.' and rank '.$round->rank.' round->id '.$round->id);
		
		if ($round->rank > 1) {
			$previousRound=Round::getRoundByRank($round->pool_id, $round->rank-1);
			$standings=$this->standingsAfterRound($pool, $round->rank-1);
		} else {
			$previousRound=false;
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
		$previousGameTime=Round::getPlayingTimeInRound($round, $team->id);
		$previousGameTimeComponents = date_parse(date("Y-m-d H:i", $previousGameTime));
		$thisGameTimeComponents = date_parse(date("Y-m-d H:i", $match->scheduledTime));
		if ($previousGameTimeComponents['day'] != $thisGameTimeComponents['day']) {
			$tomorrow = true;
		} else {
			$tomorrow = false;
		}
		
		if ($round->rank > 1) {
			$text = "After a ";
			$text .= Round::getResultInRound($previousRound,$team->id);
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
			$text .= $opponent_team->shortName;
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
	
	private function getRankInStanding($standing,$team_id) {
		// returns rank of team with id $team_id in $standing
		// returns false if $team_id is not found
		foreach($standing as $team) {
			if ($team['team_id']==$team_id) {
				return $team['rank'];
			}
		}
		return false;
	}

	
//      
//    'compare the dates of the current and next round
//    tomorrow = (roundSheet.Range("NextRound").Resize(1, 1).Offset(-2, -3) < roundSheet.Range("NextRound").Resize(1, 1).Offset(-2, 1))
//    
//    'create string with "at " + the next playing time
//    'prepend "tomorrow, " if necessary
//    If tomorrow Then
//        nextTime = "tomorrow, at "
//    Else
//        nextTime = "at "
//    End If
//    nextTime = nextTime + Format(roundSheet.Range("NextRound").Offset(-2, 2).Resize(1, 1).Value, "h:mm")
//    
//       
//    ' show what's going on
//    ActiveWorkbook.Worksheets("SmsDB").Activate
//    
//    'save counter
//    firstSMSCounter = Range("SMSCounter").Value + 1
//
//    
//    ' go through all the teams
//    For i = 1 To TeamPhones.Rows.count
//        TeamName = TeamPhones.Cells(i, 1)
//        
//        ' first figure out where the team is listed in the Range "RoundResults"
//        Set cell = roundSheet.Range("RoundResults").Find(TeamName)
//        If cell.Column = 1 Then   ' team is in first column
//            currOpponent = cell.Offset(0, 2).Value
//            currScore = cell.Offset(0, 1).Value
//            currOppScore = cell.Offset(0, 3).Value
//        ElseIf cell.Column = 3 Then ' team is listed in second column
//            currOpponent = cell.Offset(0, -2).Value
//            currScore = cell.Offset(0, 1).Value
//            currOppScore = cell.Offset(0, -1).Value
//        Else
//            Err.Raise vbObjectError + 666, , "Something's fishy in figuring out where the team is listed in Current Results"
//        End If
//        
//        newRank = GetRank(TeamName, roundSheet)
//               
//        ' first figure out where the team is listed in the Range "NextRound"
//        Set cell = roundSheet.Range("NextRound").Find(TeamName, , xlValues)
//        If cell.Column = 6 Then   ' team is in first column
//            nextOpponent = cell.Offset(0, 1).Value
//            nextField = cell.Offset(0, 3).Value
//        ElseIf cell.Column = 7 Then ' team is listed in second column
//            nextOpponent = cell.Offset(0, -1).Value
//            nextField = cell.Offset(0, 2).Value
//        Else
//            Err.Raise vbObjectError + 666, , "Something's fishy in figuring out where the team is listed in Next Round"
//        End If
//              
//        nextOppRank = GetRank(nextOpponent, roundSheet)
//        
//        
//        'create message
//        'After a 15-2 loss in round 1, you are now ranked 12th. In round 2,
//        'you'll play "Ultimate Kaese" (ranked 13th) on Field 1 at 12:30.
//               
//        mes = "After a " + CStr(currScore) + "-" + CStr(currOppScore)
//        If currScore > currOppScore Then
//            mes = mes + " win "
//        ElseIf currScore < currOppScore Then
//            mes = mes + " loss "
//        ElseIf currScore = currOppScore Then
//            mes = mes + " tie "
//        End If
//        mes = mes + "in Round " + CStr(curRound) + ", you are ranked " + Ordinal(newRank) + ".In round " + CStr(curRound + 1)
//        
//        If nextOpponent = "BYE" Then
//            mes = mes + ", you can take a break due to the odd number of teams. You'll score a 15-15 tie."
//        Else
//            mes = mes + ", you'll play " + GetShortTeamName(nextOpponent) + " ("
//            If newRank = nextOppRank Then
//                mes = mes + "also "
//            End If
//            mes = mes + "ranked " + Ordinal(nextOppRank) + ") on Field " + CStr(nextField) + " " + nextTime + "."
//        End If
//        
//        'if it's the end of the day, add reminder for handing in the spirit forms
//        If tomorrow Then
//            mes = mes + "Handin today's spirit!"
//        End If
//        
//        
//        For j = 1 To 2 ' loop over phone numbers
//          number = GetPhone(TeamName, j)
//          If number <> "" Then
//            ' create a new SMS
//            SMSCount = Range("SMSCounter").Value
//            SMSCount = SMSCount + 1
//            Range("SMSCounter").Value = SMSCount
//            
//            SMSDBStart.Offset(SMSCount, 0).Value = SMSCount
//            SMSDBStart.Offset(SMSCount, 2).Value = number
//            SMSDBStart.Offset(SMSCount, 8).Value = curRound
//            SMSDBStart.Offset(SMSCount, 9).Value = TeamName
//            SMSDBStart.Offset(SMSCount, 10).Value = currScore
//            SMSDBStart.Offset(SMSCount, 11).Value = currOpponent
//            SMSDBStart.Offset(SMSCount, 12).Value = currOppScore
//            SMSDBStart.Offset(SMSCount, 13).Value = newRank
//            SMSDBStart.Offset(SMSCount, 14).Value = nextOpponent
//            SMSDBStart.Offset(SMSCount, 15).Value = nextOppRank
//            SMSDBStart.Offset(SMSCount, 16).Value = nextField
//            
//            SMSDBStart.Offset(SMSCount, 3).Value = mes
//            SMSDBStart.Offset(SMSCount, 4).Value = Len(mes)
//          End If
//        Next j
//    Next i
//    
//    SMSSend firstSMSCounter, Range("SMSCounter").Value
	

	
	
	private function printStandings($standings){
		echo "<table border='1' width='600px'><tr>
		<th>Rank</th>
		<th>Team_Id</th>
		<th>Teamname</th>
		<th>Seed</th>";
		
		for($i=0;$i<count($standings);$i++) {
			$row = $standings[$i];
			echo "<tr>";
			echo "<td >".$row['rank']."</td>";
			echo "<td >".$row['team_id']."</td>";
			echo "<td >".$row['name']."</td>";
			echo "<td >".$row['seed']."</td>";
			echo "</tr>\n";
			}
		echo "</table>";

	}
	

	private function adjustForDuplicateGames(&$standings,$pool,$forward, &$skip=false) {
		// this function will change the variable $standings  and  $skip
		
		// if $skip > 0, we do not take the *first* unplayed team we find, but skip it try with the next until $skip == 0
		// that's to try to get out of infinite loops 
		
		If ($forward) {
			$sign = 1;
			$startPos = 0;
			$stopPos = count($standings);
		}else {
			$sign = -1;
			$startPos = count($standings)-1;
			$stopPos = -1;        
		}
	    
		FB::log("Loop from ".$startPos." until ".$stopPos." with steps ".($sign*2)." (skip is ".$skip.")");		
		for ($i=$startPos;$i!=$stopPos;$i=$i+$sign*2) {
			If ($this->TeamsHavePlayed($standings[$i]['team_id'],$standings[$i+$sign]['team_id'],$pool)) {
				// Find the first team in the rest of the list that hasn't played
				$j = $this->FindUnplayedTeam($standings[$i]['team_id'], $i + 2 * $sign, $standings, $pool, $forward, $skip);
				If ($j > 0) {
					// this means we've found one.
					$this->MoveTeamToNewPosition($j, $i + $sign, $standings);
				}else{
					// This is trouble.  There is no team further down that hasn't played
					// the current team.
					FB::log("unable to find an unplayed team in this direction: ".$forward);
					return(false);
				}
			}
		}
		
	    FB::log("It all worked out! :-)");
		return(true);
		
	}
	
	private function moveTeamToNewPosition($posFrom, $posTo, &$standings) {
	// This routine will move the team in posFrom to the posTo position, and shift
	// everyone in between by one to accomodate.
	
		FB::table('Standings before moving teams',$standings);
	    FB::log("Moving team in position ".$posFrom." to position ".$posTo);
		
		If ($posFrom > $posTo) {
			$sign = -1;
		}Else{
			$sign = 1;
		}
	
		$tempteam = $standings[$posFrom]; 
		
		for($i=$posFrom; $i!=$posTo; $i=$i+$sign) {
	//		print "in the loop<br>";
			$standings[$i]=$standings[$i+$sign];
		}
		$standings[$posTo]=$tempteam;
		
		FB::table('Standings after moving teams',$standings);
	}
	
	
	private function findUnplayedTeam($teamid, $startPos, $standings, $pool, $forward, &$skip=false) {
		// this function will change $skip counter
		
		// if $skip > 0, we are not returning the *first* unplayed team in this direction, but 
		// skip it and return the second (and decrease the $skip counter)
		
		If ($forward){
			$sign = 1;
			$stopPos = count($standings);
			if ($startPos>$stopPos) return(-1);
		}Else{
			$sign = -1;
			$stopPos = -1;
			if ($startPos<$stopPos) return(-1);
		}
		
		FB::log('trying to find unplayed team for team id '.$teamid.' searching from '.$startPos.' to '.$stopPos.' taking steps '.$sign);
		
		for($i=$startPos; $i != $stopPos; $i=$i+$sign) {
			If (!$this->TeamsHavePlayed($teamid, $standings[$i]['team_id'],$pool)){
				FB::log("Found an unplayed team for ".$teamid.", namely ".$standings[$i]['team_id']." on position ".$i);
				if ($skip>0) {
					$skip -= 1; // skip this one, decrease the counter and keep searching
				} else {
					return($i);
				}
			}	
		}
		return(-1);
	}
	
	
	private function teamsHavePlayed($teamid1,$teamid2,$pool) {
		FB::log("Checking if team_id ".$teamid1." has played team_id ".$teamid2." ... ");
		// check all rounds of the pool up to currentRound-1
		for($i=0 ; $i<($pool->currentRound)-1; $i++) {
			// check all games in round i
			foreach($pool->Rounds[$i]->Matches as $match) {
				if (($match->home_team_id == $teamid1 && $match->away_team_id == $teamid2) || ($match->home_team_id == $teamid2 && $match->away_team_id == $teamid1)){
					FB::log("yes!");
					return(true);					
				} 
			}
		}
		FB::log("no");
		return(false);
	}
	
	
	private function compareTeamsSwissdraw($a, $b)
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