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
				$match->save();
			}
			FB::groupEnd();
		}
		
		FB::groupEnd();
		
		$this->currentRound=0;
//		echo "<br /><br /> -- -- - -- - - -- <br /><br />";
		$this->getStrategy()->nameMatches($this);

		// assign fields		
		FB::group('assigning fields');
		$fields = Field::getList($this->Stage->Division->tournament_id);
		$fieldsAvailable = count($fields) > 0;
		$fieldIndex = 0;
				
		foreach($this->Rounds as $round) {
			foreach($round->Matches as $match) {
				FB::log('match name '.$match->matchName.' pos '.strpos($match->matchName,"BYE Match"));
				if (strpos($match->matchName,"BYE Match") !== false) {
					FB::log('unlinking field of match '.$match->matchName);
					$match->field_id = null;
					$match->save();					
				} else {
					//link fields
					if($fieldsAvailable) {
						FB::log('assigning Field with id'.$fields[$fieldIndex]->id.' to match id '.$match->id);
						$match->link('Field', array($fields[$fieldIndex]->id));
						$match->save();
					}				
					$fieldIndex = $fieldIndex < count($fields) - 1 ? $fieldIndex + 1 : 0;
				}
			}
		}
		FB::groupEnd();
		
		$this->save();
		// WINDMILL only: insert playing times
		Windmill::insertMatchTimes($this);
	}	
	
	/**
	 * 
	 * executes moves
	 */
	public function performMoves() {
		FB::group('performing moves in pool '.$this->id);
		FB::log('first delete all teams in this pool');
		$this->PoolTeams->delete();
//		foreach($this->PoolTeams as $poolTeam) {
//			// delete all but the BYE team
//			if ($poolTeam->Team->byeStatus == 0) {
//				$poolTeam->delete();
//			}
//		}
		
		foreach($this->SourceMoves as $move) {
			$poolTeam = new PoolTeam();
			$poolTeam->link('Pool', array($this->id));
			$poolTeam->seed = $move->destinationSpot;
			$poolTeam->rank = $move->destinationSpot; // set rank=seed to begin with
			$poolTeam->team_id = $move->SourcePool->getTeamIdByRank($move->sourceSpot);
			FB::log('retrieved team ranked '.$move->sourceSpot.', got team_id '.$poolTeam->team_id);
			if ($poolTeam->team_id === null) {
				throw new Exception('missing team_id, the move probably did not exist');
			}
			$poolTeam->save();
			$this->PoolTeams->add($poolTeam);
		}
		
		
		FB::log('number of PoolTeams: '.count($this->PoolTeams));
		$this->currentRound = 1;
		$this->save();
		FB::groupEnd();
		
		FB::log('computing matchups of first round of pool '.$this->id);
		$this->getStrategy()->createMatchups($this);
	}
		
	public function getTeamIdByRank($rank) {
		$rankedteam=$this->getTeamByRank($rank);
		if ($rankedteam === false ){
			return(false);
		} else {
			return($rankedteam->team_id);
		}
	}
	
	
	public function getTeamNameByRank($rank) {
		$rankedteam=$this->getTeamByRank($rank);
		if ($rankedteam === false ){
			return(false);
		} else {
			return($rankedteam->Team->name);
		}
	}
	
	public function getTeamByRankOLD($rank) {
		// the rank-property of PoolTeams can be ambiguous, 
		// because several teams can have the same rank
		// in this case, we use the seed as tie-breaker
		FB::log('getting team with rank '.$rank.' in pool '.$this->title.' of division '.$this->Stage->Division->title); 
		
		// first try to retrieve the team with $rank directly
		$q = Doctrine_Query::create()
			->select('pt.*, t.name as teamname, t.byeStatus as byeStatus')
		    ->from('PoolTeam pt')
			->leftJoin('pt.Team t')
		    ->where('pt.pool_id = ?',$this->id)
		    ->andWhere('pt.rank = ?', $rank);
		
		$targetTeam = $q->fetchOne();
		
		if ($targetTeam == false) {
			// the concrete rank could not been retrieved
			// so retrieve all teams instead and take it from there
			FB::log('the concrete rank '.$rank.' could not been retrieved, getting all teams instead');
			$q = Doctrine_Query::create()
				->select('pt.*, t.name as teamname, t.byeStatus as byeStatus')
			    ->from('PoolTeam pt')
				->leftJoin('pt.Team t')
			    ->where('pt.pool_id = ?',$this->id)
			    ->orderBy('pt.rank ASC, pt.seed ASC');
			    
			$poolteams = $q->fetchArray();
			
			if (count($poolteams) < $rank || $poolteams[$rank-1]['rank'] > $rank) { 
				$targetTeam=false;
			} else {				
				$targetTeam=$poolteams[$rank-1];
			}
		}		

//		$targetTeamSeed=$targetTeam['seed'];
		// make sure we are never returning the BYE team
		if ($targetTeam['byeStatus']==1) {
			FB::log('we retrieved the BYE team on rank '.$rank.' retrieving '.($rank+1).'instead.');
			return $this->getTeamByRank($rank+1);		
//			$targetTeamSeed=$targetTeam->seed;	// TODO: ugly hack such that the recursion works
			// this was necessary, because the actual procedure return a PoolTeam Object, 
			// whereas we only need the 'seed' property of $targetTeam to continue
		}
		
		FB::log('targetTeam id'.$targetTeam['teamname'].' seed '.$targetTeam['seed'].' rank '.$targetTeam['rank']);

		// this does not work, probably because it did not retrieve the whole PoolTeam object... ???
		// TODO: this does work, but is much slower		
		$teamByRank = PoolTeam::getBySeed($this->id, $targetTeam['seed']);
		
		assert($teamByRank->Team->name != 'BYE Team');
		return $teamByRank;				
		
	}

	public function getTeamByRank($rank) {
		// the rank-property of PoolTeams can be ambiguous, 
		// because several teams can have the same rank
		// in this case, we use the seed as tie-breaker
		FB::log('getting team with rank '.$rank.' in pool '.$this->title.' of division '.$this->Stage->Division->title); 
		
			// the concrete rank could not been retrieved
			// so retrieve all teams instead and take it from there
		$q = Doctrine_Query::create()
		    ->from('PoolTeam pt')
		    ->leftJoin('pt.Team')
		    ->where('pt.pool_id = ?',$this->id)
		    ->orderBy('pt.rank ASC, pt.seed ASC');
		$poolTeams = $q->execute();
		
		FB::log('poolTeams: count '.count($poolTeams));

		if (count($poolTeams) < $rank || $poolTeams[$rank-1]->rank > $rank) { 
			return false;
		} 
		
		$rankCount=0;
		foreach($poolTeams as $poolTeam) {
			if ($poolTeam->Team->byeStatus != 1) {
				$rankCount++;
				if ($rankCount == $rank) {
					return $poolTeam;
				}	
			}
		}
			
		return false;			
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
	 		$this->save(); // saving number of spots
		}
		
		
		
 		FB::log('number of spots in pool '.$this->spots);

 		$nrSpots=$this->spots;
		if ($this->byeRank() > 0 && !$seed) { 
	 		$nrSpots--; 
	 	 	FB::log('adjusted number of spots to be displayed to '.$nrSpots);
	 	} 						
 		
		for($i = 0; $i < $nrSpots; $i++) {
			$spot = new PoolSpot();
			$spot->rank = $i + 1;
			$spot->title = ($seed ? $this->getTeamNameBySeed($i+1) : $this->getTeamNameByRank($i+1)); 
			
			if ($spot->title === false) {
				$spot->title = "empty";
				if ($seed && $this->PoolRuleset->title == 'Bracket') {
					// check if there is a danger of occuring a BYE in this spot
					$spot->byeCount = (Brackets::possibleBYE($this->spots, $this->getNumberOfRounds(), $i+1) ? 1 : 0);
				}
			} elseif (!$seed) {
				$poolteamByRank = $this->getTeamByRank($i+1);
				// count how many BYEs $poolteam had in this pool
				FB::log('poolteamByRank '.$poolteamByRank->Team->name);
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
		return $this->currentRound > $this->getNumberOfRounds();
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
	
	public function swapPoolRankWith($swapRank) {
		// swaps the rank of $this pool with the one with $rank		
		assert($this->rank != $swapRank);
		
		FB::log('this rank '.$this->rank.' swapRank '.$swapRank);
		$swapPool = $this->Stage->Pools[$swapRank-1];  
		FB::group('pool with ranks'.$this->rank.' and '.$swapPool->rank.' switch ranks.');
		
		// swap ranks
		$tempRank=$this->rank;
		$this->rank=$swapPool->rank;
		$swapPool->rank=$tempRank;
		
		$this->save();
		$swapPool->save();
		
		// rename the games in this pool, because the poolOffsets might have changed
		FB::log('renaming games in both pools');
		$this->getStrategy()->nameMatches($this);
		$swapPool->getStrategy()->nameMatches($swapPool);		
		
		FB::groupEnd();		
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
	
	public function offsetRank() {		
		// compute the sum of the number of teams in the pools in the same stage as this pool
		FB::group('computing rank offset of pool '.$this->id);
		
		$offset = 0;
		foreach($this->Stage->Pools as $pool) {
			if ($pool->rank < $this->rank) {
				$offset += $pool->spots;
				FB::log('checking pool '.$pool->id.'. It has '.$pool->spots.' spots');
				if ($pool->byeRank()>0) {
					FB::log('correcting offset by one for BYE team in pool '.$pool->id);
					$offset -= 1;
				}
			}
		}
		
		FB::log('offset is '.$offset);
		FB::groupEnd();
		return $offset;
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
			    //->leftJoin('p.Rounds r')
			    //->leftJoin('r.Matches rm')
			    //->leftJoin('rm.HomeTeam ht')
			    //->leftJoin('rm.AwayTeam at')
			    //->leftJoin('rm.Field f')
			    ->where('p.id = ?', $id)
			    ->orderBy('pt.rank ASC');
		$pool = $q->fetchOne();
		
		$pool->Rounds = Round::getRounds($pool->id);
		
		
		$end = getmicrotime();
		
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