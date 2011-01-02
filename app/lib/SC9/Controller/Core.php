<?php
class SC9_Controller_Core {
	
	public $output;
	public $params;
	
	public function __construct($output, $params = null) {
		$this->output = $output;
		$this->params = $params;
	}
	
	public function indexAction() {
		
	}

	
	public function relocate($path) {
		header("location:/stallcount9/?n=".$path);  // FIXME Chris: I need to include some path here...
		exit;
	}
		
	public function get($key, $default = "") {
		return isset($_GET[$key]) ? $_GET[$key] : $default;
	}

	public function post($key, $default = "") {
		return isset($_POST[$key]) ? $_POST[$key] : $default;
	}
	
	public function request($key, $default = "") {
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
	}
	
}