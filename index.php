<?php

include 'config.local.php';
include "app/Stallcount9.php";

$sc9 = new Stallcount9($config);
$sc9->handleRequests();
