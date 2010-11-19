<?php

require_once(dirname(__FILE__) . '/lib/SC9/Doctrine.php');

class Stallcount9 {
	
	/* static constants	 */
	const DB_MYSQL = "mysql";
	
	/* static variables */
	public static $path;
	public static $settings;
	public static $output;
	
	
	public function Stallcount9($config) {
		//path to root of stallcount9 app
		Stallcount9::$path = dirname(__FILE__)."/";
		
		//set class autoloader
		$this->registerAutoloader();
		
		//parse settings (Settings is temporary, should use Container -> dependency injection)
		Stallcount9::$settings = new SC9_Settings($config);
		
		//output controller
		Stallcount9::$output = new SC9_Output_TwigOutput(Stallcount9::$path.'../skin/'.Stallcount9::$settings->skin, Stallcount9::$path.'data/output/cache');
	}
	
	public function handleRequests($req) {
		$n = isset($req["n"]) ? $req["n"] : "";
		
		$controller = new SC9_Controller_Home();
		$controller->indexAction($req);
	}
	
	
	
	
	/** 
	 * Register the autoloader, default using the Doctrine autoload function
	 */
	public function registerAutoloader() {
		ini_set('unserialize_callback_func', 'spl_autoload_call');
		spl_autoload_register(array('Doctrine', 'autoload'));
		spl_autoload_register(array('Stallcount9', 'autoload'));
	}
	
    static public function autoload($class) {
		$file = Stallcount9::$path.'lib/'.str_replace('_', '/', $class).'.php';
        if (file_exists($file)) {
            require $file;
        }
    }
	
	
}