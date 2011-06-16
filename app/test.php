<?php
 $sql = "INSERT INTO score_2011 SET round = '1', division = 'mixed', team_home = 'Frizzly Bears', team_away = 'Moscow Chapiteau', field = '1';";
 $secret = "bananana";

 $request = "http://www.windmillwindup.com/2011/proxy.php?s=".urlencode($sql)."&sr=".md5($sql.$secret);
 echo $request."\n";
 
 $result = file_get_contents($request);
 
 header("content-type: text/plain");
 echo $result;