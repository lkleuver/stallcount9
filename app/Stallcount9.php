<?php

require_once(dirname(__FILE__) . '/lib/SC9/Doctrine.php');

class Stallcount9 {
	
	
	
	public function Stallcount9($settings) {
		$this->registerAutoloader();
	}
	
	
	
	/** 
	 * Register the autoloader, default using the Doctrine autoload function
	 */
	public function registerAutoloader() {
		spl_autoload_register(array('Doctrine', 'autoload'));
	}
	
	
}