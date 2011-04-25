<?php

/**
 * Division
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Division extends BaseDivision {
	
	
	public function initializeDivision() {
		//create registration stage and it's pool
		$stage = new Stage();
		$stage->title = "Registration stage";
		$stage->rank = 1;
		$stage->link('Division', array($this->id));
		$stage->save();
		
		
		$pool = new Pool();
		$pool->title = "Registration seeding";
		$pool->rank = 1;
		$pool->link('Stage', array($stage->id));
		$pool->pool_ruleset_id = PoolRuleset::MANUAL_ID;
		$pool->save();
	}
	
	public function getNextRank() {
		$rank = 1;
		foreach($this->Stages as $stage) {
			if($stage->rank >= $rank) {
				$rank = $stage->rank + 1;
			}
		}
		return $rank;
	}
	
	//TODO: build in a check that makes sure the stages ranks are ascending
	/*
	 * pre: Stages length is not 0
	 */
	public function schedule() {
		foreach($this->Stages as $stage) {
			if($stage->rank != 1) {
				$stage->schedule();
			}
		}
	}
	
	public function seedNextStage() {
		$lastFinishedStage = null;
		foreach($this->Stages as $stage) {
			if(!$stage->isFinished()) {
				if($lastFinishedStage != null) {
					$stage->seedWithTeams($lastFinishedStage->getQualifiedTeams());
					return;
				}
			}else{
				$lastFinishedStage = $stage;
			}
		}
	}
	
	public function getStageById($id) {
		foreach($this->Stages as $stage) {
			if($stage->id == $id) {
				return $stage;
			}
		}
		return null;
	}
	
	/**
	 * 
	 * Returns the ID of the first pool in the first stage (by rank)
	 */
	public function getSeedPoolId() {
		if(count($this->Stages) > 0) {
			if(count($this->Stages[0]->Pools) > 0) {
				return $this->Stages[0]->Pools[0]->id;
			}
		}
		return 1;
	}
	
	
	public static function getById($id) {
		$q = Doctrine_Query::create()
			    ->from('Division d')
			    ->leftJoin('d.Stages s')
			    ->leftJoin('d.Tournament t')
			    ->leftJoin('d.Teams tms')
			    ->leftJoin('s.Pools p')
			    ->where('d.id = ?', $id)
			    ->orderBy('s.rank ASC, p.rank ASC');
		$division = $q->fetchOne();
		return $division;
	}

}