<?php

/**
 * Round
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Round extends BaseRound {

	public function finish() {
		// finishing a round means:
		// 0. checking if the filled in results make sense
		// 1. export round results to MySQL 
		// 2. print round results
		//   if not Bracket  or  last round of playoffs
		// 3. print standings after this round
		// 4. export standings to MysQL
		
		// always:
		// 5. increase current round
		// if there is a next round
		// 6. compute those matchups, return true
		// if there is no next round, return false
			
		
		$errorCode=$this->allResultsCorrect();
		FB::log('error code '.$errorCode);
		if ($errorCode < 0) {
			echo "In Round ".$this->id." , ".$this->Pool->title." Round ".$this->rank."<br>";
		}
		switch ($errorCode) {
			case 2:
				FB::warn('some score higher than 15');
				break;
		    case (-1):
		        FB::warn("not all teams filled in");
		        die('not all teams filled in');
		        break;
		    case (-2):
		        FB::warn("not all required results filled in");
		        die('not all required results filled in');
		        break;
		    case (-3):
		        FB::warn("some score out of range 0..30");
		        die('some score out of range 0..30');
		        break;
		    case (-4):
		        FB::warn("BYE team score not the default");
		        die('BYE team score not the default');
		        break;
		    case (-5):
		        FB::warn("score filled in where there should be no score due to a BYE");
		        die('score filled in where there should be no score due to a BYE');
		        break;
		}
		
		
		Export::exportRoundResultsToMySQL($this->id);
		FB::log("exported results of this round to SQL file");
		
		if ($this->Pool->PoolRuleset->title != "Bracket" || ($this->Pool->Stage->placement && count($this->Pool->Rounds)==$this->rank) ) { 
			// if it's either not a playoff round
			// or the last playoff round of a placement pool
			FB::log("exported standings of this round to SQL file");			
			Export::exportStandingsAfterRoundToMySQL($this->id);			
		}
		
		$this->Pool->currentRound++;
		$this->Pool->save();
		
		$nextRound = Round::getRoundByRank($this->pool_id, $this->Pool->currentRound);
		
		if ($nextRound !== false ) { // there is no next round
			// create matchups for next round
			$nextRound->createMatchups();
			return true;
		} else {
			return false;
		}		
	}
	
	public function announce() {
		// announcing a round means:
		// 1. create and send SMS to teams 
		// 2. export matchups to MySQL
		// 3. print schedule
		
		$this->createSMS();		
		Export::exportSMSToMySQLByRound($this->id);
		FB::log('exported SMS of this round to SQL file');    	
		
		Export::exportRoundMatchupsToMySQL($this->id);
		
		// TODO: printing goes here!
	}
	public function allTeamsFilledIn() {
		// returns true if all teams of all matches of this round are filled in
		// i.e. the matchups have been created
		FB::log('checking if round with id '.$this->id.' has all teams filled in');
		foreach($this->Matches as $match) {
			if (is_null($match->home_team_id) && is_null($match->away_team_id)) {
				// in brackets with odd number of teams, it is allowed that one of the two teams is not set
				FB::log('no'); 
				return false;
			}
		}		
		FB::log('yes');
		return true;		
	}
	
	public function allResultsCorrect() {
		// possible error codes returned:
		//  2 warning: some scores out of range 0..15
		//  1 all results correct
		// -1 not all teams filled in
		// -2 not all required results filled in
		// -3 some score out of range 0..30
		// -4 BYE team score not the default
		// -5 score filled in where there should be no score due to a BYE
		
		$errorCode=1;
		// first checks if all Teams of this round have been filled in
		if (!$this->allTeamsFilledIn()) {
			return -1;
		}
		// returns true if all results of all matches of this round are filled in
		foreach($this->Matches as $match) {
			// only check matches where both away and home teams are filled in
			if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
				if (is_null($match->homeScore) || is_null($match->awayScore) ) {
					return -2;
				} else {
					// scores should be between 0 and 30
					if ($match->homeScore < 0 || $match->homeScore > 30 || $match->awayScore < 0 || $match->awayScore > 30) {
						FB::warn('home or away score of match '.$match->HomeTeam->name.'-'.$match->AwayTeam->name.' is not between 0 and 30');
						return -3;
					}
					if ($match->homeScore > 15 || $match->awayScore > 15) {
						FB::warn('home or away score of match '.$match->HomeTeam->name.'-'.$match->AwayTeam->name.' higher than 15');
						$errorCode=2;
					}
					
					
					// if one of the teams is the BYE Team (from Swissdraw), the standard result has to be filled in
					if ($match->HomeTeam->byeStatus == 1) {
						// TODO: fill in the actual forfeit score from the pool
						if ($match->homeScore != 12 || $match->awayScore != 15) { 
							FB::warn('BYE team score incorrect');
							return -4; 
						}
					}elseif ($match->AwayTeam->byeStatus == 1) {
						if ($match->awayScore != 12 || $match->homeScore != 15) { 
							FB::warn('BYE team score incorrect');
							return -4; 
						}
					}
				}
				
			} elseif (is_null($match->home_team_id) || is_null($match->away_team_id) ) {
				// that's a BYE team in the playoffs or Round Robin
				// hence, no score should be entered\
				if (!is_null($match->homeScore) || !is_null($match->awayScore) ) {
					return -5;
				}
			} else {
				FB::error('this case should have been cought by $this->allTeamsFilledIn()');
				die ('this case should have been cought by $this->allTeamsFilledIn()');
			}
		}		
		return $errorCode;
	}
	
	
	public function allResultsFilledIn() {
		// first checks if all Teams of this round have been filled in
		if (!$this->allTeamsFilledIn()) {
			return false;
		}
		// returns true if all results of all matches of this round are filled in
		foreach($this->Matches as $match) {
			// only check matches where both away and home teams are filled in
			if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
				if (is_null($match->homeScore) || is_null($match->awayScore) ) {
					return false;
				}
			}
		}		
		return true;
	}
	
	
	public function randomScoreFill() {
		foreach($this->Matches as $match) {
			if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
				if (is_null($match->homeScore)) {
					$match->homeScore=rand(0,15);
					$match->save();				
				}
				if (is_null($match->awayScore)) {
					$match->awayScore=rand(0,15);
					$match->save();
				}
			}
		}
	}

	public function createMatchups() {
		FB::log('Model/Round.php: creating matchups');
		$this->Pool->getStrategy()->createMatchups($this->Pool);
		return null;
	}

	public function createSMS() {
		FB::group('Model/Round.php: deleting SMS for round with id '.$this->id);
		foreach($this->SMSs as $sms) {
			FB::log('deleting SMS with id '.$sms->id);
			$sms->delete();
		}
		FB::groupEnd();
		
		FB::group('Model/Round.php: creating SMS for round with id '.$this->id);
		$this->Pool->getStrategy()->createSMS($this->Pool,$this->id);
		FB::groupEnd();
		return null;
	}
	
	public static function getPlayingTimeInRound($round,$team_id) {
		// returns time when $team_id played in $round
		// false if $team_id is not found in $round
		FB::log('looking for playing time of team with id '.$team_id.' in round with id '.$round->id);
		$time=0;
		$matchfound=false;
		foreach($round->Matches as $match) {
			if ($match->HomeTeam->id == $team_id) {
				return $match->scheduledTime;	
			} elseif ($match->AwayTeam->id == $team_id) {
				return $match->scheduledTime;	
			}						
		}
		return false;
	}
			
	
	
	public static function getResultInRound($round,$team_id) {
		// goes through matches in $round and checks for the match that $team_id played
		// it returns  e.g. "8-15 loss"  or "12-9 win"  or  "5-5 tie"
		FB::log('looking for team with id '.$team_id.' in round with id '.$round->id);

		foreach($round->Matches as $match) {
			if ($match->home_team_id == $team_id || $match->away_team_id == $team_id) {
				return $match->resultString($team_id);
			}
		}
		return false;
	}
	
	
	public static function deleteRounds($poolId) {
		$rounds = Round::getRounds($poolId);
		foreach($rounds as $round) {
			foreach($round->Matches as $match) {
				$match->delete();
			}
			$round->delete();
		}
	}
		
	public static function getRounds($poolId) {
		FB::error('maybe this does not work, we should fetchOne instead of execute');
		$q = Doctrine_Query::create()
			    ->from('Round r')
			    ->leftJoin('r.Matches m')
			    ->leftJoin('m.HomeTeam ht')
			    ->leftJoin('m.AwayTeam at')
			    ->leftJoin('m.Field f')
			    ->where('r.pool_id = ?', $poolId)
			    ->orderBy('r.rank ASC, m.rank ASC');
		return $q->execute();
	}

	public static function getRoundByRank($poolId, $roundRank, $orderByField = false) {
		$q = Doctrine_Query::create()
			    ->from('Round r')
			    ->leftJoin('r.Pool p')
			    ->leftJoin('p.PoolRuleset pr')
			    ->leftJoin('r.Matches m')
			    ->leftJoin('m.Field f')
			    ->leftJoin('m.HomeTeam ht')
			    ->leftJoin('m.AwayTeam at')
			    ->where('r.pool_id = "'.$poolId.'" AND r.rank = "'.$roundRank.'"');
	    if($orderByField) {
	    	$q->orderBy('f.rank ASC');
	    }else{
		    $q->orderBy('m.rank ASC');
	    }
//	    echo "<br> SQL:" . $roundRank . " <br> ". $q->getSqlQuery() ."</br>";
		return $q->fetchOne();
	}

	public static function getRoundById($roundId) {
		$q = Doctrine_Query::create()
			    ->from('Round r')
			    ->leftJoin('r.Matches m')
			    ->leftJoin('r.SMSs s')
			    ->where('r.id = "'.$roundId.'"')
			    ->orderBy('m.rank ASC');
		return $q->fetchOne();
	}
	
}