<?php


class SC9_Controller_Tournament extends SC9_Controller_Core {
	
	public $tournamentId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->tournamentId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$template = $this->output->loadTemplate('tournament/detail.html');
		$template->display(array());
	}
	
	public function createAction() {
		$template = $this->output->loadTemplate('tournament/create.html');
		$template->display(array());
	}
}