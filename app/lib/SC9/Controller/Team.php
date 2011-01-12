<?php


class SC9_Controller_Team extends SC9_Controller_Core {
	
	public $teamId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->teamId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		
		$template = $this->output->loadTemplate('team/detail.html');
		$template->display(array());
	}
	
	public function createAction() {
		$division = Doctrine_Core::getTable("Division")->find($this->request("divisionId"));
		$team = new Team();
		
		$this->handleFormSubmit($team);		

		
		$template = $this->output->loadTemplate('team/create.html');
		$template->display(array("division" => $division, "team" => $team));
	}
	
	
	public function editAction() {
		$team = Doctrine_Core::getTable("Team")->find($this->teamId);
		
		$this->handleFormSubmit($team);		

		
		$template = $this->output->loadTemplate('team/edit.html');
		$template->display(array("division" => $team->Division, "team" => $team));
	}
	
	
	private function handleFormSubmit($team) {
		if($this->post("teamSubmit") != "") {
			$team->name = $this->post("teamName");
			$team->link('Division', array($this->post("divisionId")));
			$team->save();

			$this->relocate("/division/detail/".$this->post("divisionId"));
		}
	}
	
	
	
	public function removeAction() {
		$team = Doctrine_Core::getTable("Team")->find($this->teamId);
		$divisionId = $team->Division->id; //needed? to lazy to check if delete also empties the object
		$team->delete();
		$this->relocate("/division/detail/".$divisionId);
	}
	
}