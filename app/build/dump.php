<?php
require_once('bootstrap.php');


echo "Dumping data...\n";

$s = time() . "";


Doctrine_Core::debug(true);
Doctrine_Core::loadModels($modelsPath);
Doctrine_Core::dumpData('fixtures/backup'.$s.'.yml');