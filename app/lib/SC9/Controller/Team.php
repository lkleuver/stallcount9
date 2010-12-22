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
	

	public function addToDivision() {
		$divisionId = $this->get("divisionId");
		
		$template = $this->output->loadTemplate('team/addToDivision.html');
		$template->display(array());
	}
	
}