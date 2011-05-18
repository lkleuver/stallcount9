<?php

//house keeping
ini_set('magic_quotes_gpc', "1");
error_reporting(E_ALL);
ini_set('display_errors', "1");



include 'config.local.php';
include "app/Stallcount9.php";

$sc9 = new Stallcount9($config);
$sc9->handleRequests();
