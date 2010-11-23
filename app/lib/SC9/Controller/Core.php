<?php
class SC9_Controller_Core {
	
	public $output;
	
	public function __construct() {
		$this->output = Stallcount9::$output;
	}
	
	public function indexAction($req) {
		
	}
	
}