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
		header("location: index.php?n=".$path);
		exit;
	}
	
	public function ajaxResponse($o, $error = false, $message = "") {
		$o->error = $error ? 1 : 0;
		$o->message = $message;
		header("content-type: application/json");
		echo json_encode($o);
		exit;
	}
	
	public function isAjax() {
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  			return true;
		}
		return false;
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