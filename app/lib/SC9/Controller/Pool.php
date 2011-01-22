<?php


class SC9_Controller_Pool extends SC9_Controller_Core {
	
	public $poolId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->poolId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		
		$template = $this->output->loadTemplate('pool/detail.html');
		$template->display(array());
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