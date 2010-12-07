<?php
/**
 * Bootstrap file, for loading and using doctrine
 */

require_once(dirname(__FILE__) . '/../../config.local.php');
require_once(dirname(__FILE__) . '/../lib/Doctrine/core.php');

//autoloading
ini_set('unserialize_callback_func', 'spl_autoload_call');
spl_autoload_register(array('Doctrine_Core', 'autoload'));
spl_autoload_register('autoload');

$manager = Doctrine_Manager::getInstance();

$connStr = sprintf('%s://%s:%s@%s/%s', $config['database']['type'], $config['database']['user'], $config['database']['password'], $config['database']['host'], $config['database']['name']);
$conn = Doctrine_Manager::connection($connStr);



function autoload($class) {
	if(file_exists($file = '../lib/SC9/Model/generated/'.$class.'.php')) {
		require $file;
	}			
}