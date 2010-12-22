<?php



class SC9_Controller_Stage extends SC9_Controller_Core {
	
	public $stageId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->stageId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$template = $this->output->loadTemplate('stage/detail.html');
		$template->display(array());
	}
	


	public function createAction() {
		$divisionId = $this->get("divisionId");
		
		$template = $this->output->loadTemplate('stage/create.html');
		$template->display(array());
	}
	
	
}