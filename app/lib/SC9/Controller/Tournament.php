<?php


class SC9_Controller_Tournament extends SC9_Controller_Core {
	
	public function __construct($output) {
		parent::__construct($output);
	}
	
	
	public function detailAction($req, $params = null) {
		$tournamentId = count($params) > 0 ? $params[0] : "";
		
		$template = $this->output->loadTemplate('tournament/detail.html');
		$template->display(array());
	}
	
	public function createAction($req, $params = null) {
		$template = $this->output->loadTemplate('tournament/create.html');
		$template->display(array());
	}
}