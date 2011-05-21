<?php

/**
 * Pool
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Pool extends BasePool {

	private $_strategy; //type: SC9_Strategy_Interface
	
	
	//TODO: currently assumes it's the only pool and consumes all teamspots
	public function schedule() {
		Round::deleteRounds($this->id);
		
		FB::group('Scheduling Pool '.$this->id);
		FB::log($this->getStrategy()->getName());
		
		$nrOfRounds = $this->getStrategy()->calculateNumberOfRounds($this->spots);
		FB::log("ROUNDS " .$nrOfRounds);
		
		$matchCountPerRound = ceil($this->spots / 2);
		FB::log("MATCHCOUNT: ".$matchCountPerRound);
		
		for($i = 0; $i < $nrOfRounds; $i++) {
			FB::group("ROUND ".($i + 1));
			$round = new Round();
			$round->rank = $i+1;
			$round->matchLength = $this->PoolRuleset->matchLength;
			$round->link('Pool', array($this->id));	
			$round->save();
			
			for($j = 0; $j < $matchCountPerRound; $j++) {
				FB::log("MATCH: ".($j + 1));
				$match = new RoundMatch();
				$match->link('Round', array($round->id));
				$match->rank = $j+1;
				$match->matchName = "match rank ".($j + 1);
				$match->homeName = "winner a";
				$match->awayName = "winner b";
				//link fields
				$match->save();
			}
			FB::groupEnd();
		}
		
		FB::groupEnd();
		
		$this->currentRound=0;
//		echo "<br /><br /> -- -- - -- - - -- <br /><br />";
		$this->getStrategy()->nameMatches($this);
	}	
	
	/**
	 * 
	 * executes moves
	 */
	public function performMoves() {
		FB::group('performing moves in pool '.$this->id);
		foreach($this->SourceMoves as $move) {
			$poolTeam = new PoolTeam();
			$poolTeam->pool_id = $this->id;
			$poolTeam->seed = $move->destinationSpot;
			$poolTeam->rank = $move->destinationSpot; // set rank=seed to begin with
			$poolTeam->team_id = $move->SourcePool->getTeamIdByRank($move->sourceSpot);
			if ($poolTeam->team_id === null) {
				throw new Exception('missing team_id, the move probably did not exist');
			}
			$poolTeam->save();
			
		}
		$this->currentRound = 1;
		$this->save();
		FB::groupEnd();
	}
	
	public function createMatchups() {
		FB::log('Model/Pool.php: creating matchups');
		$this->getStrategy()->createMatchups($this);
		return null;
	}
	
	public function getTeamIdByRank($rank) {
		$rankedteam=$this->getTeamByRank($rank);
		if ($rankedteam === false ){
			return(false);
		} else {
			return($rankedteam['team_id']);
		}
	}
	
	
	public function getTeamNameByRank($rank) {
		$rankedteam=$this->getTeamByRank($rank);
		if ($rankedteam === false ){
			return(false);
		} else {
			return($rankedteam['teamname']);
		}
	}
	
	public function getTeamByRank($rank) {
		// the rank-property of PoolTeams can be ambiguous, 
		// because several teams can have the same rank
		// in this case, we use the seed as tie-breaker
		FB::log('getting team with rank '.$rank); 

		// if there is a BYE team in the pool, skip it when getting this TeamName
		// i.e. we have to adjust the $rank we are looking for
		$byeRank=$this->byeRank();
		if ($byeRank>0) {
			FB::log('bye Rank: '.$byeRank);
			if ($byeRank <= $rank) {
				$rank++;
				FB::log('rank we are looking for adjusted to '.$rank);
			}
		}		
		
		// first try to retrieve the team with $rank directly
		$q = Doctrine_Query::create()
			->select('pt.*, t.name as teamname')
		    ->from('PoolTeam pt')
			->leftJoin('pt.Team t')
		    ->where('pt.pool_id = ?',$this->id)
		    ->andWhere('pt.rank = ?', $rank);
		
		$poolteams = $q->fetchOne();
		
		if ($poolteams != false) {
			assert($poolteams['teamname'] != 'BYE Team');
			return $poolteams;
		} else {
			// the concrete rank could not been retrieved
			// so retrieve all teams instead and take it from there
			
			$q = Doctrine_Query::create()
				->select('pt.*, t.name as teamname')
			    ->from('PoolTeam pt')
				->leftJoin('pt.Team t')
			    ->where('pt.pool_id = ?',$this->id)
			    ->orderBy('pt.rank ASC, pt.seed ASC');
			    
			$poolteams = $q->fetchArray();
			
			if (count($poolteams) < $rank || $poolteams[$rank-1]['rank'] > $rank) { 
				return false;
			} else {								
				assert($poolteams[$rank-1]['teamname'] != 'BYE Team');
				return($poolteams[$rank-1]);
			}
		}		
	}

	public function getTeamNameBySeed($seed) {
		$q = Doctrine_Query::create()
			->select('pt.*, t.name as teamname')
		    ->from('PoolTeam pt')
			->leftJoin('pt.Team t')
		    ->where('pt.pool_id = ?',$this->id)
		    ->andWhere('pt.seed = ?',$seed);
		    
//		echo "<pre>".$q->getSqlQuery()."</pre>";
		$poolteam = $q->fetchOne();
		
 
		if ($poolteam === false) {
			$firephp = FirePHP::getInstance(true);
			$firephp->warn('WARNING: requested seed '.$seed.' does not exist in pool with id '.$this->id);
			return(false);
		}
		
		return($poolteam['teamname']);
		
	}
	
	
	
	public function getTeamCount() {
		return count($this->PoolTeams);
	}
	
	/**
	 * 
	 * returns the number of teams that will qualify
	 */
	public function getQualifiedTeamCount() {
		//return $this->getStrategy()->
	}
	
	public function getStrategy(){
		if($this->_strategy === null) {
			$this->_strategy = SC9_Factory_Strategy::createStrategy($this->PoolRuleset);
		}
		return $this->_strategy;
	}
	
	public function byeRank() {
		// returns the rank of the BYE team
		// or false if there is not BYE team in this pool
		$q = Doctrine_Query::create()
			    ->from('PoolTeam pt')
			    ->leftJoin('pt.Team t')
			    ->where('t.byeStatus = 1')
			    ->andWhere('pt.pool_id = ?',$this->id);
		$byeTeam = $q->fetchOne();
		
		if ($byeTeam === false) {
			return (false);
		} else {
			assert($this->PoolRuleset->title == 'Swissdraw'); // make sure this is a Swissdraw pool
			return ($byeTeam['rank']);
		}				
	}
		
	public function getSpots($seed=false) {
		// returns an array of PoolSpots
		// if $seed is true, the spots are sorted according to the seeding
		// if $seed is false, the sports are sorted according to rank
		// if $seed is false, 
		FB::group('getSpots business of pool '.$this->id);
		
		$result = array();
		
		if ($this->spots == 0) {
			$this->spots = count($this->PoolTeams);
	 		// adjust the number of spots, if there is a BYE team in the pool and $seed=false 			
	 		if ($this->byeRank() > 0 && !$seed) { 
	 			$this->spots--; 
	 		 	FB::log('adjusted number of spots to '.$this->spots);
	 		} 				
	 		$this->save(); // saving number of spots
		}
 		FB::log('number of spots '.$this->spots);
 		
		for($i = 0; $i < $this->spots; $i++) {
			$spot = new PoolSpot();
			$spot->rank = $i + 1;
			$spot->title = ($seed ? $this->getTeamNameBySeed($i+1) : $this->getTeamNameByRank($i+1)); 
			if ($spot->title === false) {
				$spot->title = "empty";
				if ($seed) {
					// check if there is a danger of occuring a BYE in this spot
					$spot->byeCount = (Brackets::possibleBYE($this->spots, $this->getNumberOfRounds(), $i+1) ? 1 : 0);
				}
			} elseif (!$seed) {
				$poolteamByRank = $this->getTeamByRank($i+1);
				// count how many BYEs $poolteam had in this pool
				$spot->byeCount = $poolteamByRank->countBYEs();				
			} 			

			$spot->sourceMove = $this->getSourceMoveForSpot($spot->rank);
			$spot->destinationMove = $this->getDestinationMoveForSpot($spot->rank);
			
			$result[] = $spot;
		}
		
		FB::groupEnd();
		return $result;
	}
	
	public function getSourceMoveForSpot($rank) {
		for($i = 0; $i < count($this->SourceMoves); $i++) {
			if($this->SourceMoves[$i]->destinationSpot == $rank) {
				return $this->SourceMoves[$i];
			}
		}
		return null;
	}
	
	public function getDestinationMoveForSpot($rank) {
		for($i = 0; $i < count($this->DestinationMoves); $i++) {
			if($this->DestinationMoves[$i]->sourceSpot == $rank) {
				return $this->DestinationMoves[$i];
			}
		}
		return null;
	}
	
	public function isFinished() {
		return $this->currentRound >= $this->getNumberOfRounds();
	}
	
	public function getNumberOfRounds() {
		return $this->getStrategy()->calculateNumberOfRounds($this->spots);
	}
	
	public function getQualifiedTeams() {
		$result = array();
		$this->sortTeamsByRank();
		for($i = 0; $i < $this->PoolRuleset->qualificationCutoff; $i++) {
			$result[] = $this->PoolTeams[$i]->Team;
		}
		
		return $result;
	}

	public function standingsAfterRound($roundNr) {
		return $this->getStrategy()->standingsAfterRound($this, $roundNr);
	}
	
//private helper functions
	//TODO: only works php 5.3+ (anonymous function)
	private function sortTeamsByRank() {
		usort($this->PoolTeams, function($a, $b) {
			if($a->rank == $b->rank) {
				return 0;
			}
			return $a->rank < $b->rank ? -1 : 1;
		});
	}
	
//DATABASE FUNCTIONS
	
	public static function getById($id) {
		$q = Doctrine_Query::create()
			    ->from('Pool p')
			    ->leftJoin('p.Stage s')
			    ->leftJoin('p.PoolRuleset rs')
			    ->leftJoin('rs.PoolStrategy ps')
			    ->leftJoin('p.PoolTeams pt')
			    ->leftJoin('pt.Team t')
			    ->leftJoin('p.Rounds r')
			    ->leftJoin('r.Matches rm')
			    ->leftJoin('rm.HomeTeam ht')
			    ->leftJoin('rm.AwayTeam at')
			    ->where('p.id = ?', $id)
			    ->orderBy('pt.rank ASC, r.rank ASC, rm.rank ASC');
		$pool = $q->fetchOne();
		return $pool;
	}
	
	public static function getByIdLight($id) {
		$q = Doctrine_Query::create()
			    ->from('Pool p')
			    ->where('p.id = ?', $id);
		$pool = $q->fetchOne();
		return $pool;
	}
	
	public static function deleteDestinationMovesForSpot($id, $spot) {
		$q = Doctrine_Query::create()
				->delete("PoolMove pm")
				->where('pool_id = "'.$id.'" AND destinationSpot = "'.$spot.'"');
		$q->execute();
	}
	
	public static function deleteSourceMovesForSpot($id, $spot) {
		$q = Doctrine_Query::create()
				->delete("PoolMove pm")
				->where('source_pool_id = "'.$id.'" AND sourceSpot = "'.$spot.'"');
		$q->execute();
	}
	
}