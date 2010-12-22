<?php


class SC9_Controller_Division extends SC9_Controller_Core {
	public $divisionId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->divisionId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$template = $this->output->loadTemplate('division/detail.html');
		$template->display(array());
	}
	

	public function stageAction() {
		$template = $this->output->loadTemplate('division/detail.html');
		$template->display(array());
	}
	
}