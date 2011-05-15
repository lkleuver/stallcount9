<?php

require_once('app/lib/FirePHPCore/FirePHP.class.php');
require_once('app/lib/FirePHPCore/fb.php');

ob_start();

		$firephp = FirePHP::getInstance(true);
		$var = array('i'=>10, 'j'=>20);
		$firephp->log($var, 'Iterators');
		
		print_r($var);
		echo "<br>";
?>
this is a test
