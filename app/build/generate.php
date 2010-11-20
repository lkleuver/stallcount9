<?php
require_once('bootstrap.php');

$modelsPath = '../lib/SC9/Model';

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml('schema/base.yml', $modelsPath);
Doctrine_Core::createTablesFromModels($modelsPath);