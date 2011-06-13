<?php


class SC9_Controller_Field extends SC9_Controller_Core {
	
	public $fieldId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params, "field");
		$this->fieldId = count($params) > 0 ? $params[0] : "";
	}
	
	public function listAction() {
		$fields = Field::getList($this->get("tournamentId"));

		$template = $this->output->loadTemplate('field/list.html');
		$template->display(array("fields" => $fields, "tournamentId" => $this->get("tournamentId")));
	}
	
	public function detailsAction() {
		
		$field = Field::getById($this->fieldId);
		
		$template = $this->output->loadTemplate('field/detail.html');
		$template->display(array("field" => $field));
	}
	
	public function editAction() {
		$field = Field::getById($this->fieldId);
		
		if($this->handleFormSubmit($field)) {
			$this->relocate("/field/list/&tournamentId=".$field->tournament_id);
		}
		
		$template = $this->output->loadTemplate('field/edit.html');
		$template->display(array("field" => $field));
	}
	
	public function createAction() {
		$field = new Field();
		$field->tournament_id = $this->get("tournamentId");
		
		if($this->handleFormSubmit($field)) {
			$this->relocate("/field/list/&tournamentId=".$field->tournament_id);
		}
		
		
		$template = $this->output->loadTemplate('field/create.html');
		$template->display(array("field" => $field));
	}
	
	public function createrangeAction() {
		$rangeStart = (int) $this->request("rangeStart");
		$rangeEnd = (int) $this->request("rangeEnd");
		$prefix = $this->request("prefix");
		
		for($i = $rangeStart; $i <= $rangeEnd; $i++) {
			$field = new Field();
			$field->tournament_id = $this->get("tournamentId");
			$field->title = $prefix ." " . $i;
			$field->comments = "";
			$field->link('Tournament', array($this->post("tournamentId")));
			$field->rank = $i;
			$field->save();			
		}
		$this->relocate("/field/list/&tournamentId=".$this->request("tournamentId"));
	}
	
	private function handleFormSubmit($field) {
		if($this->post("fieldsubmit") != "") {
			$field->title 			= $this->post("fieldName");
			$field->comments		= $this->post("fieldComments");
			$field->link('Tournament', array($this->post("tournamentId")));
			$field->save();
			return true;
		}
		return false;
	}
	
	public function removeAction() {
		$tournament = Doctrine_Core::getTable("Tournament")->find($this->tournamentId);
		$tournament->delete();
		$this->relocate("/home/index");
	}
	
	
	
	public function scheduleAction() {
		$fields = Field::getList($this->get("tournamentId"));

		$template = $this->output->loadTemplate('field/schedule.html');
		$template->display(array("fields" => $fields, "tournamentId" => $this->get("tournamentId")));
	}
	
}