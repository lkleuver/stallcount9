<?php


class SC9_Controller_Field extends SC9_Controller_Core {
	
	public $fieldId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->fieldId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function listAction() {
		$fields = Field::getList($this->get("tournamentId"));

		$template = $this->output->loadTemplate('field/list.html');
		$template->display(array("fields" => $fields, "tournamentId" => $this->get("tournamentId")));
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
	
	private function handleFormSubmit($field) {
		if($this->post("fieldsubmit") != "") {
			$field->title 			= $this->post("fieldName");
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
}