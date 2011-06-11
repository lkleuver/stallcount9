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
		$scored=0;
		$received=0;
		$matchfound=false;
		$bye = false;
		foreach($round->Matches as $match) {
			if ($match->home_team_id == $team_id && !is_null($match->away_team_id)) {
				$scored=$match->homeScore;
				$received=$match->awayScore;
				$matchfound=true;	
				break;			
			} elseif ($match->away_team_id == $team_id && !is_null($match->home_team_id)) {
				$scored=$match->awayScore;
				$received=$match->homeScore;
				$matchfound=true;
				break;								
			} elseif ($match->home_team_id == $team_id || $match->away_team_id == $team_id ) {
				$bye=true;
				break;
			}
		}
		if ($scored > $received) {
			return $scored.'-'.$received.' win';
		} elseif ($scored < $received) {
			return $scored.'-'.$received.' loss';
		} elseif ($scored == $received && $matchfound == true) {
			return $scored.'-'.$received.' tie';
		} elseif ($bye === true) { // team had a BYE  (" a break ")
			return 'break';
		} elseif ($matchfound === false) { // assumes
			FB::error('no match found in round with id '.$round->id.' where team with id '.$team_id.' played!');
		} else {
			die('hae?');
		}
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