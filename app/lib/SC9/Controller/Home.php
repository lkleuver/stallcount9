<?php
class SC9_Controller_Home extends SC9_Controller_Core {
	
	public function __contruct($output, $params) {
		parent::__construct($output, $params);
	}
	
	public function indexAction() {
		$template = $this->output->loadTemplate('home.html');
		$template->display(array("test" => "bla"));
	}
}