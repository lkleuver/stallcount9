<?php
class SC9_Controller_Home extends SC9_Controller_Core {
	
	
	public function indexAction($req) {
		$template = Stallcount9::$output->loadTemplate('home.html');
		$template->display(array("test" => "bla"));
	}
}