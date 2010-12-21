<?php


class SC9_Controller_Contact extends SC9_Controller_Core {
	
	public function __construct($output) {
		parent::__construct($output);
	}
	
	
	public function nfbAction($req) {
		$template = $this->output->loadTemplate('contact/nfb.html');
		$template->display(array("test" => "bla"));
	}
}