<?php


class SC9_Controller_Contact extends SC9_Controller_Core {
	
	public function __construct() {
		parent::__construct();
	}
	
	
	public function nfbAction($req) {
		$template = $this->output->loadTemplate('contact/nfb.html');
		$template->display(array("test" => "bla"));
	}
}