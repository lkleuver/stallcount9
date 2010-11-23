<?php
class SC9_Controller_Home extends SC9_Controller_Core {
	
	public function __contruct() {
		parent::__construct();
	}
	
	public function indexAction($req) {
		$template = $this->output->loadTemplate('home.html');
		$template->display(array("test" => "bla"));
	}
}