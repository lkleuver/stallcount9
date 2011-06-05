<?php

/**
 * Stage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Stage extends BaseStage{

	public function getNextRank() {
		$rank = 1;
		foreach($this->Pools as $pool) {
			if($pool->rank >= $rank) {
				$rank = $pool->rank + 1;
			}
		}
		return $rank;
	}
	
	
	public function schedule() {
		FB::group("::::: STAGE ".$this->title." :::::::");
		foreach($this->Pools as $pool) {
			$pool->schedule();
		}		
		FB::groupEnd();
	}
	
	/**
	 * 
	 * executes moves
	 */
	public function performMoves() {
		foreach($this->Pools as $pool) {
			$pool->performMoves();
		}
	}
	
	/**
	 * 
	 * Number of teams in this Stage
	 * @return int
	 */
	public function getTeamCount() {
		$result = 0;
		foreach($this->Pools as $pool) {
			$result += $pool->getTeamCount();
		}
		return $result;
	}
	
	/**
	 * 
	 * number of teams that will qualify for the next round
	 * @return int
	 */
	public function getQualifiedTeamCount() {
		$result = 0;
		foreach($this->Pools as $pool) {
			$result += $pool->getQualifiedTeamCount();
		}
		return $result;
	}
	
	/**
	 * 
	 * check if all matches in this stage are played
	 * @return Boolean
	 */
	public function isFinished() {
		foreach($this->Pools as $pool) {
			if(!$pool->isFinished()) {
				return false;
			}
		}
		return true;
	}

	public function getParentStage() {
		$result = null;
		for($i = 0; $i < count($this->Division->Stages); $i++) {
			if($this->Division->Stages[$i]->id == $this->id) {
				if($i > 0) {
					$result = $this->Division->Stages[$i - 1]; 
				}
				break;
			}
		}
		
		return $result;
	}
	
	public function getQualifiedTeams() {
		$result = array();
		foreach($this->Pools as $pool) {
			$qualifiedPoolTeams = $pool->getQualifiedTeams();
			foreach($qualifiedPoolTeams as $team) $result[] = $team;
		}
		return $result;
	}
	
	public function seedWithTeams($seedTeams) {
		echo "Seeding:<br />";
		foreach($seedTeams as $team) {
			echo $team->id."<br />";
		}
		exit;
	}
	
	
	public function getActiveRound() {
		$result = 0;
		foreach($this->Pools as $pool) {
			if($result == 0 || $pool->currentRound < $result) {
				$result = $pool->currentRound;
			}
		}
		return $result;
	}
	

	
	public static function getById($id) {
		$q = Doctrine_Query::create()
			    ->from('Stage s')
			    ->leftJoin('s.Division d')
			    ->leftJoin('s.Pools p')
			    ->where('s.id = ?', $id)
			    ->orderBy('s.rank ASC, p.rank ASC');
		$stage = $q->fetchOne();
		return $stage;
	}
	
}