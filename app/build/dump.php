<?php
require_once('bootstrap.php');


echo "Dumping data...\n";


Doctrine_Core::debug(true);
Doctrine_Core::loadModels($modelsPath);
Doctrine_Core::dumpData('fixtures/backup.yml');