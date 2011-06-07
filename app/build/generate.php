<?php
error_reporting(E_ALL);
ini_set('display_errors', "1");

require_once('bootstrap.php');


$options = array(

);

//deleting old models first (dangerous!)
exec('rm '.$modelsPath."/generated/*");

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml('schema/base.yml', $modelsPath, $options);
Doctrine_Core::createTablesFromModels($modelsPath);
Doctrine_Core::loadData('fixtures/core.yml');