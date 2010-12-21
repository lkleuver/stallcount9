<?php
class SC9_Controller_Home extends SC9_Controller_Core {
	
	public function __contruct($output) {
		parent::__construct($output);
	}
	
	public function indexAction($req, $params = null) {
		$template = $this->output->loadTemplate('home.html');
		$template->display(array("test" => "bla"));
	}
}