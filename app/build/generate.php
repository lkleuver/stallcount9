<?php
require_once('bootstrap.php');

$modelsPath = '../lib/SC9/Model';
$options = array(
  'generateBaseClasses'  =>  FALSE,
);

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml('schema/base.yml', $modelsPath, $options);
Doctrine_Core::createTablesFromModels($modelsPath);