<?php
require_once('bootstrap.php');


echo "Loading data...\n";


Doctrine_Core::debug(true);
Doctrine_Core::loadModels($modelsPath);
Doctrine_Core::loadData('fixtures/backup.yml');