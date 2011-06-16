<?php 

$name = date("Y-m-d-h:i", time());
system('mysqldump -u les -pbla stallcount9 >app/export/dump/'.$name.'.sql');