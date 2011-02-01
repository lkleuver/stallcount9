<?php


class SC9_Controller_Pool extends SC9_Controller_Core {
	
	public $poolId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->poolId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$q = Doctrine_Query::create()
			    ->from('Pool p')
			    ->leftJoin('p.Stage s')
			    ->leftJoin('p.Teams t')
			    ->where('p.id = ?', $this->poolId);
		$pool = $q->fetchOne();
		
		
		//(temporary) fetch teams which don't have a pool yet for this stage
		$q = Doctrine_Query::create()
				->from('Team t')
				->leftJoin("t.PoolTeam pt")
				->where('t.division_id = ? AND pt.pool_id is null', $pool->Stage->Division->id);
		$teams = $q->execute();
		
		
		$template = $this->output->loadTemplate('pool/detail.html');
		$template->display(array("pool" => $pool, "teams" => $teams));
	}
	
	public function createAction() {
		$stage = Doctrine_Core::getTable("Stage")->find($this->request("stageId"));
		$pool = new Pool();
		
		$this->handleFormSubmit($pool);		

		
		$template = $this->output->loadTemplate('pool/create.html');
		$template->display(array("stage" => $stage, "pool" => $pool));
	}
	
	
	public function editAction() {
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		
		$this->handleFormSubmit($pool);		

		
		$template = $this->output->loadTemplate('pool/edit.html');
		$template->display(array("stage" => $pool->Stage, "pool" => $pool));
	}
	
	
	public function addteamAction() {
		$teamId = $this->request("teamId");
		$poolTeam = new PoolTeam();
		$poolTeam->team_id = $teamId;
		$poolTeam->pool_id = $this->poolId;
		$poolTeam->save();
		
		$this->relocate("/pool/detail/".$this->poolId);
	}
	
	public function removeteamAction() {
		$teamId = $this->request("teamId");
		$pool = Doctrine_Core::getTable('Pool')->find($this->poolId);
		$pool->unlink('Teams', array($teamId));
		$pool->save();
		$this->relocate("/pool/detail/".$this->poolId);
	}
	
	
	private function handleFormSubmit($pool) {
		if($this->post("poolSubmit") != "") {
			$pool->title = $this->post("poolTitle");
			$pool->link('Stage', array($this->post("stageId")));
			$pool->save();

			$this->relocate("/stage/detail/".$this->post("stageId"));
		}
	}
	
	
	
	public function removeAction() {
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$stageId = $pool->Stage->id; //needed? to lazy to check if delete also empties the object
		$pool->delete();
		$this->relocate("/stage/detail/".$stageId);
	}
	
}