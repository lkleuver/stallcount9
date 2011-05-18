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
			die('number of spots in a Swissdraw pool should always be even!');
		}
		
		$teamcount=0;
		// first round Swissdraw is different
		for ($j=0 ; $j < $nrTeams/2 ; $j++) {
			$pool->Rounds[0]->Matches[$j]->homeName = "Seed ".++$teamcount;
			$pool->Rounds[0]->Matches[$j]->awayName = "Seed ".($teamcount+($nrTeams/2));
			$pool->Rounds[0]->Matches[$j]->matchName = "Match rank ".($j+1);
		}
				
		// second and following rounds are the same
		for ($i=1 ; $i<$this->numberOfRounds ; $i++) {
			// read off pairings of this round
			$teamcount=0;
			for ($j=0 ; $j < ceil($nrTeams/2) ; $j++) {
				$pool->Rounds[$i]->Matches[$j]->homeName = "Round ".$i." aprx rank ".++$teamcount;
				$pool->Rounds[$i]->Matches[$j]->awayName = "Round ".$i." aprx rank ".++$teamcount;
				$pool->Rounds[$i]->Matches[$j]->matchName = "Match rank ".($j+1);
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
		
		// initialize standings arrays
		foreach($pool->PoolTeams as $poolteam) {
			$standings[$poolteam->team_id] = array('team_id' => $poolteam->team_id, 'name' => $poolteam->Team->name, 'games' => 0, 'vp' => 0, 'opp_vp' => 0, 'margin' => 0, 'scored' => 0, 'spirit' => 0, 'rank' => $poolteam->rank, 'seed' => $poolteam->seed);
		}
		
		if ($roundnr == 0) {
			// note that sorting destroys the link with the $team_id keys, so the counting code in the "else" part does not work
			// if we sort beforehand!
			
			// sort according to seed 
			usort($standings, create_function('$a,$b','return $a[\'seed\']==$b[\'seed\']?0:($a[\'seed\']<$b[\'seed\']?-1:1);'));			
		} else {
			
			for ($i=0; $i<$roundnr; $i++) { // go through all rounds up to $roundnr
				$curRound = $pool->Rounds[$i];
				foreach($curRound->Matches as $match) {
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
						
		}

		
		// fill in ranks, also in PoolTeam
		$rank=1;
		$standings[0]['rank']=1;  // assuming that it was sorted before, so the list starts with 0					
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
		
		return $standings;
	}
	
	
	public function createMatchups($pool) {
		$curRoundNr = $pool->currentRound;
		$curRound = $pool->Rounds[$curRoundNr-1];
		$nrTeams = count($pool->PoolTeams);
		
		FB::log('creating matchups for pool with id '.$pool->id.' round '.$curRoundNr);
		if ($nrTeams %2 ==1) {
			die('number of teams in Swissdraw pool has to be even');
		}
		
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
		
		
		// get standings up to currentRound
		$standings = $this->StandingsAfterRound($pool, $curRoundNr-1);
		FB::table('initial standings after round '.$curRoundNr-1,$standings);
		
		// first Swissdraw round has different pairings, 
		// namely, for 2n teams, 1 plays n+1, 2 plays n+2 etc.
		if($curRoundNr==1) {
			$teamcounter=0;
			for ($i=0; $i < count($curRound->Matches); $i++) {
				//$curRound->Matches[$i]->home_team_id = $standings[$teamcounter++]['team_id'];
				//$curRound->Matches[$i]->away_team_id = $standings[($teamcounter+($nrTeams/2))-1]['team_id'];
				
				$curRound->Matches[$i]->link('HomeTeam', array($standings[$teamcounter++]['team_id']));
				$curRound->Matches[$i]->link('AwayTeam', array($standings[($teamcounter+($nrTeams/2))-1]['team_id']));
				
				$curRound->Matches[$i]->save();
				
				FB::log('checking if we scheduled a match with the BYE team');
				$homeTeam=$curRound->Matches[$i]->HomeTeam; // make Doctrine load the stuff
				$awayTeam=$curRound->Matches[$i]->AwayTeam;
				if ($homeTeam->byeStatus == 1) {
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeAgainst;					
				}elseif ($awayTeam->byeStatus == 1) {
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeAgainst;
				} else {				
					// fill in random scores for testing
					$curRound->Matches[$i]->homeScore = rand(0,15);
					$curRound->Matches[$i]->awayScore = rand(0,15);
				}
				
			}	
			$curRound->save();									
		} else {			
			// the goal is to swap around teams in $standings until we arrive at new standings where
			// 1-2, 3-4, 5-6 etc. are valid matchups (i.e. they have not played each other before) 
			$forward=true;
			$roundcounter=0;
			$foundValidArrangement=$this->AdjustForDuplicateGames($standings,$pool,$forward);
				
			while(!$foundValidArrangement){
				$forward=!$forward;
				if ($forward) {
					FB::log("round ".$roundcounter.", going forward");
				} else {
					FB::log("round ".$roundcounter.", going backward");
				}
				$foundValidArrangement = $this->AdjustForDuplicateGames($standings,$pool, $forward);
				$roundcounter++;
				if ($roundcounter>count($standings)*2) Die("Could not find a valid arrangment of teams"); 
			}		
			
			// fill in matchups
			$teamcounter=0;
			for ($i=0; $i < count($curRound->Matches); $i++) {
				$curRound->Matches[$i]->home_team_id = $standings[$teamcounter++]['team_id'];
				$curRound->Matches[$i]->away_team_id = $standings[$teamcounter++]['team_id'];
				$curRound->save();	

				FB::log('checking if we scheduled a match with the BYE team');
				fb('match id '.$curRound->Matches[$i]->id);	

				$curRound = $pool->Rounds[$curRoundNr-1];				
				$homeTeam=$curRound->Matches[$i]->HomeTeam; // make Doctrine load the stuff
				fb('home team name '.$homeTeam->name);								
				$awayTeam=$curRound->Matches[$i]->AwayTeam;
				if ($homeTeam->byeStatus == 1) {
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeAgainst;					
				}elseif ($awayTeam->byeStatus == 1) {
					$curRound->Matches[$i]->awayScore = $pool->PoolRuleset->byeScore;
					$curRound->Matches[$i]->homeScore = $pool->PoolRuleset->byeAgainst;
				} else {				
					// fill in random scores for testing
					$curRound->Matches[$i]->homeScore = rand(0,15);
					$curRound->Matches[$i]->awayScore = rand(0,15);
				}
				
				$curRound->save();		
			}
		}
		
		// increase current round
//		if ($curRoundNr < $this->numberOfRounds) { 
			$pool->currentRound = ($curRoundNr + 1);
//		} else { // or set to -1 if total number of rounds is reached
//			$pool->currentRound = -1;
//		}
		$pool->save();
	}
	
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
	

	private function adjustForDuplicateGames(&$standings,$pool,$forward) {
		// this function will change the variable $standings
		
		If ($forward) {
			$sign = 1;
			$startPos = 0;
			$stopPos = count($standings);
		}else {
			$sign = -1;
			$startPos = count($standings)-1;
			$stopPos = -1;        
		}
	    
		FB::log("Loop from ".$startPos." until ".$stopPos." with steps ".($sign*2));		
		for ($i=$startPos;$i!=$stopPos;$i=$i+$sign*2) {
			If ($this->TeamsHavePlayed($standings[$i]['team_id'],$standings[$i+$sign]['team_id'],$pool)) {
				// Find the first team in the rest of the list that hasn't played
				$j = $this->FindUnplayedTeam($standings[$i]['team_id'], $i + 2 * $sign, $standings, $pool, $forward);
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
	
	
	private function findUnplayedTeam($teamid, $startPos, $standings, $pool, $forward) {
	
		If ($forward){
			$sign = 1;
			$stopPos = count($standings)-1;
			if ($startPos>$stopPos) return(-1);
		}Else{
			$sign = -1;
			$stopPos = 1;
			if ($startPos<$stopPos) return(-1);
		}
		
		for($i=$startPos; $i != $stopPos; $i=$i+$sign) {
			If (!$this->TeamsHavePlayed($teamid, $standings[$i]['team_id'],$pool)){
				FB::log("Found an unplayed team for ".$teamid.", namely ".$standings[$i]['team_id']." on position ".$i);
				return($i);
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