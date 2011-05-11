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

		echo $this->getStrategy()->getName() ."<br />";
		
		$nrOfRounds = $this->getStrategy()->calculateNumberOfRounds($this->spots);
		echo "ROUNDS " .$nrOfRounds."<br />";
		
		$matchCountPerRound = ceil($this->spots / 2);
		echo "MATCHCOUNT: ".$matchCountPerRound;
		
		for($i = 0; $i < $nrOfRounds; $i++) {
			echo "---<br />ROUND ".($i + 1)."<br />";
			$round = new Round();
			$round->rank = $i+1;
			$round->matchLength = $this->PoolRuleset->matchLength;
			$round->link('Pool', array($this->id));	
			$round->save();
			
			for($j = 0; $j < $matchCountPerRound; $j++) {
				echo "MATCH: ".($j + 1)."<br />";
				$match = new RoundMatch();
				$match->link('Round', array($round->id));
				$match->rank = $j+1;
				$match->matchName = "match rank ".($j + 1);
				$match->homeName = "winner a";
				$match->awayName = "winner b";
				//link fields
				$match->save();
			}
		}
		
		echo "<br /><br /> -- -- - -- - - -- <br /><br />";
	}	
	
	/**
	 * 
	 * executes moves
	 */
	public function performMoves() {
		foreach($this->SourceMoves as $move) {
			$poolTeam = new PoolTeam();
			$poolTeam->pool_id = $this->id;
			$poolTeam->seed = $move->destinationSpot;
			$poolTeam->rank = $move->destinationSpot; // set rank=seed to begin with
			$poolTeam->team_id = $move->SourcePool->getTeamIdForSpot($move->sourceSpot);
			if ($poolTeam->team_id == null) {
				throw new Exception('missing team_id, the move probably did not exist');
			}
			$poolTeam->save();
			
		}
		$this->currentRound = 1;
		$this->save();
	}
	
	public function createMatchups() {
		$this->getStrategy()->createMatchups($this);
		return null;
	}
	
	public function getTeamIdForSpot($rank) {
		foreach($this->PoolTeams as $poolteam) {
			if($poolteam->rank == $rank) {
				return $poolteam->team_id;
			}
		}
		return null;
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
		if($this->_strategy == null) {
			$this->_strategy = SC9_Factory_Strategy::createStrategy($this->PoolRuleset);
		}
		return $this->_strategy;
	}
	
	
	public function getSpots() {
		$result = array();
 		if($this->spots == 0) {
 			$this->spots = count($this->PoolTeams);
 		}
 		
		for($i = 0; $i < $this->spots; $i++) {
			$spot = new PoolSpot();
			$spot->rank = $i + 1;
			if($i < count($this->PoolTeams)) {
				$spot->title = $this->PoolTeams[$i]->Team->name;
			}else{
				$spot->title = "empty";
			}
			$spot->sourceMove = $this->getSourceMoveForSpot($spot->rank);
			$spot->destinationMove = $this->getDestinationMoveForSpot($spot->rank);
			
			$result[] = $spot;
		}
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