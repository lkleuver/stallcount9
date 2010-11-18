<?php
include "app/Stallcount9.php";

$_s = array();
$_s["database"] = array();
$_s["database"]["type"]		= Stallcount9::DB_MYSQL;
$_s["database"]["user"] 	= "les";
$_s["database"]["password"]	= "bla";
$_s["database"]["host"]		= "127.0.0.1";
$_s["database"]["name"]		= "stallcount9";



$sc9 = new Stallcount9($_s);
