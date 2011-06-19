<?php 


class SC9_Strategy_FlexPool implements SC9_Strategy_Interface {
	
	private $numberOfRounds;
	
	public function __construct() {
		$this->numberOfRounds = 0;
	}
	
	public function getName() {
		return "FlexPool";
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
		usort($standings, create_function('$a,$b','return $a[\'rank\']==$b[\'rank\']?0:($a[\'rank\']<$b[\'rank\']?-1:1);'));
		return $standings;
	}
	
	public function createSMS($pool,$roundId) {
		// generates SMS for round with id $roundId		
		$round=Round::getRoundById($roundId);
		
		FB::log('SMS in FlexPool for roundId '.$roundId.' and rank '.$round->rank);
		
//		if ($round->rank > 1) {
//			$previousRound=Round::getRoundByRank($round->pool_id, $round->rank-1);
//		} else {
//			$previousRound=false;
//			$standings=false;
//		}
		
		// go through all matches of $round
		foreach($round->Matches as $match) {
			if ($match->home_team_id !== null) {
				$this->createSMSForTeam($round, $match->HomeTeam, $match->AwayTeam, $match);
			}
			if ($match->away_team_id !== null) {
				$this->createSMSForTeam($round, $match->AwayTeam, $match->HomeTeam, $match);
			}			
		}
		
	}
	
	private function createSMSForTeam($round,$team,$opponent_team,$match) {
		// After a 15-2 loss in the previous round,
        // you'll play "Ultimate Kaese" on Field 1 at 12:30.

		$previousMatch=$match->getPreviousMatch($team);
		
		if ($previousMatch !== false) {
			// retrieve previous match of $team
			
			// check if the next game is "tomorrow"
			$previousGameTimeComponents = date_parse(date("Y-m-d H:i", $previousMatch->scheduledTime));
			$thisGameTimeComponents = date_parse(date("Y-m-d H:i", $match->scheduledTime));
			$tomorrow = ($previousGameTimeComponents['day'] != $thisGameTimeComponents['day']);
			
			$text = "After a ";
			$text .= $previousMatch->resultString($team->id);
			$text .= ' in the previous round, ';
		} else {
			$text = "Welcome to Windmill Windup 2011!";
			$tomorrow=false;
		}
		if (is_null($opponent_team->id)) {
			$text .=  "due to the odd number of teams,you can take a break ";
			if ($tomorrow) {
				$text .= ' tomorrow ';
			}
			$text .= ' at '.$match->timeOnly();
		} else {
			$text .= "you'll play ";
			$text .= $opponent_team->shortName;
			$text .= " on Field ".$match->field_id;
			if ($tomorrow) {
				$text .= ' tomorrow ';
			}
			$text .= ' at '.$match->timeOnly();
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
		$sms->link('Tournament',array($round->Pool->Stage->Division->tournament_id));
		$sms->save();
			
		FB::groupEnd();
	}
		
}