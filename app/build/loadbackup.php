<?php
require_once('bootstrap.php');


echo "Loading data...\n";

$file = count($argv) > 0 ? $argv[0] : "fixtures/backup.yml";

Doctrine_Core::debug(true);
Doctrine_Core::loadModels($modelsPath);
Doctrine_Core::loadData('fixtures/'.$file);