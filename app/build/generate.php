<?php
require_once('bootstrap.php');


$options = array(

);

//deleting old models first (dangerous!)
exec('rm '.$modelsPath."/generated/*");


Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml('schema/base.yml', $modelsPath, $options);
Doctrine_Core::createTablesFromModels($modelsPath);