<?php 

class Export {
// collection of functions for exporting data to MySQL
	private function fileHandle($division,$task=false,$round='unknown') {
		// returns write file handle to the file  stallcount9\app\export\$division\$poolname_$roundrank_$task.txt
		// if file exists, adjusts file handle
		// also makes sure division directory exists
		
		if ($task === false) {
			trigger_error('$task should be specified when exporting!');			
		}
		
		$directoryname='app/export/'.$division->title;
		if (!file_exists($directoryname) ){
			mkdir($directoryname);
		}
		
		if ($round=='unknown') {
			$filename = 'app/export/'.$division->title.'/'.$task.'.txt';
		} else {
			$filename = 'app/export/'.$division->title.'/'.$round->Pool->title.'Round'.$round->rank.'_'.$task.'.txt';
		}
		
		FB::log('creating file handle for task '.$task.' to '.$filename);
		
		$t=1;
		$newfilename=$filename;
		while(file_exists($newfilename)) {
			FB::log('filename already exists, adjusting');
			$newfilename=substr($filename,0,strpos($filename,".txt"))."_$t".".txt";
			$t++;
		}
		FB::log('new filename: '.$newfilename);
		
		return fopen($newfilename,'w');
	}
	
	private static function executeSQL($sql) {
		$liveUpdates = false;
		
		if ($liveUpdates) {
			// executes the sql command on the live server
			$link = mysql_connect('crunchultimate.netfirmsmysql.com', 'sc9', 'sc94effer!');
			if (!$link) {
				die('connection to MySQL server failed');
			}
			if (!mysql_select_db(d60593311)) {
				die('database d60593311 could not been selected');
			}
			
			$result = mysql_query($sql);
			if (!$result) {
			    die('Invalid query: ' . mysql_error());
			}
		}
	}
	
	public static function exportRoundResultsToMySQL($roundId) {
	//	sSQL = "UPDATE score SET score_home = " & .Offset(i - 1, 1) & ", score_away = " & .Offset(i - 1, 3)
	//	sSQL = sSQL & " WHERE team_home = '" & SQLString(.Offset(i - 1, 0)) & "' && team_away = '" & SQLString(.Offset(i - 1, 2)) & "'"
	//	sSQL = sSQL & " && division='" & Range("Division") & "' && round = " & curRound

		$round=Round::getRoundById($roundId);		
		FB::group('Export::exportRoundResultsToMySQL: export results of round '.$round->rank.' of pool with id '.$round->pool_id);
		
		$fh=Export::fileHandle($round->Pool->Stage->Division,"Results",$round);
		
		foreach($round->Matches as $match) {
			$sql = "UPDATE score_2011 SET score_home = '".$match->homeScore."', score_away = '".$match->awayScore."'";
			$sql .= " WHERE team_home = '".SMS::mysql_escape_mimic($match->HomeTeam->name)."' && team_away = '".SMS::mysql_escape_mimic($match->AwayTeam->name)."'";			
			$sql .= " && division = '".$round->Pool->Stage->Division->title."' && round = '".Export::getAbbreviationForRound($round)."';\n";
			fwrite($fh,$sql);	
			Export::executeSQL($sql);		
		}
		
		fclose($fh);
		FB::groupEnd();
		return null;
	}
	
	
	public static function exportStandingsAfterRoundToMySQL($roundId) {
//		sSQL = "INSERT INTO standing SET round=" & curRound & ", division='" & Range("Division") & "', "
//		sSQL = sSQL & "team = '" & SQLString(.Offset(i - 1, 1).Value) & "', VP = " & SQLString(.Offset(i - 1, 2).Value) & ", "
//		If .Parent.Name = "QuarterFinals" Then 'after last round of Swiss draw
//			sSQL = sSQL & "avg_opp_VP = " & .Offset(i - 1, 3)
//			sSQL = sSQL & ", margin = " & .Offset(i - 1, 4) & " , total_score = " & .Offset(i - 1, 5) & " , rank = " & .Offset(i - 1, 0)
//			sSQL = sSQL & ", avg_score = " & .Offset(i - 1, 6).Value & " , bye = " & .Offset(i - 1, 7)
//		Else 'Swiss-Draw rounds
//			sSQL = sSQL & "margin = " & .Offset(i - 1, 3) & " , total_score = " & .Offset(i - 1, 4) & " , rank = " & .Offset(i - 1, 0)
		
		$round=Round::getRoundById($roundId);		
		FB::group('Export::exportStandingsAfterRoundToMySQL: export standings after round '.$round->rank.' of pool with id '.$round->pool_id);
		
		$fh=Export::fileHandle($round->Pool->Stage->Division,"Standings",$round);
		$standings = $round->Pool->getStrategy()->standingsAfterRound($round->Pool, $round->rank); 
		
		foreach($standings as $team) {
			if ($round->Pool->PoolRuleset->title == "Swissdraw") {
				
				$sql = "INSERT INTO standing_2011 SET round = '".Export::getAbbreviationForRound($round)."', division = '".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."'";
				$sql .= ", team = '".SMS::mysql_escape_mimic($team['name'])."', VP = '".SMS::mysql_escape_mimic($team['vp'])."'";
				$sql .= ", opp_vp = '".SMS::mysql_escape_mimic($team['opp_vp'])."', margin = '".SMS::mysql_escape_mimic($team['margin'])."'";
				$sql .= ", scored = '".SMS::mysql_escape_mimic($team['scored'])."', rank = '".SMS::mysql_escape_mimic($team['rank'])."';\n";
				fwrite($fh,$sql);
				Export::executeSQL($sql);			
			} elseif ($round->Pool->PoolRuleset->title == "RoundRobin") {
				$sql = "INSERT INTO standing_2011 SET round = '".Export::getAbbreviationForRound($round)."', division = '".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."'";
				$sql .= ", team = '".SMS::mysql_escape_mimic($team['name'])."', points = '".SMS::mysql_escape_mimic($team['points'])."'";
				$sql .= ", margin = '".SMS::mysql_escape_mimic($team['margin'])."'";
				$sql .= ", scored = '".SMS::mysql_escape_mimic($team['scored'])."', rank = '".SMS::mysql_escape_mimic($team['rank'])."';\n";
				fwrite($fh,$sql);						
				Export::executeSQL($sql);			
			} elseif ($round->Pool->PoolRuleset->title == "Bracket") {
				$sql = "INSERT INTO standing_2011 SET round = '".Export::getAbbreviationForRound($round)."', division = '".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."'";
				$sql .= ", team = '".SMS::mysql_escape_mimic($team['name'])."', rank = '".SMS::mysql_escape_mimic($team['rank'])."';\n";
				fwrite($fh,$sql);						
				Export::executeSQL($sql);			
			}
		}
		
		fclose($fh);
		FB::groupEnd();
		return null;		
	}
	

	public static function exportRoundMatchupsToMySQL($roundId) {
//		sSQL = "INSERT INTO score SET round=" & nextRoundNumber & ", division='" & Range("Division") & "', "
//		sSQL = sSQL & "team_home = '" & SQLString(.Offset(i - 1, 0).Value) & "', team_away = '" & SQLString(.Offset(i - 1, 1)) & "'"
//		If .Offset(i - 1, 3) > 0 Then
//			sSQL = sSQL & ", field = " & .Offset(i - 1, 3)
		$round=Round::getRoundById($roundId);		
		FB::group('Export::exportRoundMatchuptsToMySQL: export matchups of round '.$round->rank.' of pool with id '.$round->pool_id);
				
		$fh=Export::fileHandle($round->Pool->Stage->Division,"Matchups",$round);
		
//		header("content-type: text/plain");
		
		foreach($round->Matches as $match) {
			$sql = "INSERT INTO score_2011 SET round = '".Export::getAbbreviationForRound($round)."', division = '".$round->Pool->Stage->Division->title."'";
			$sql .= ", team_home = '".SMS::mysql_escape_mimic($match->HomeTeam->name)."', team_away = '".SMS::mysql_escape_mimic($match->AwayTeam->name)."'";
			if ($match->bestPossibleRank !== null) {
				$sql .= ", top_rank ='".$match->bestPossibleRank."', lowest_rank = '".$match->worstPossibleRank."'";
			}
			if ($match->Field !== null) {
				$sql .= ", field = '".Field::getFieldNrFromTitle($match->Field->title)."'";
			}
			$sql .= ";\n";
			fwrite($fh,$sql);			
			Export::executeSQL($sql);			
		}

		fclose($fh);
		FB::groupEnd();
		return null;
	}
	
	public static function getAbbreviationForRound($round) {
//		If roundNum <= lastRound Then ' Swiss-draw
//	        GetAbbreviationForRound = CStr(roundNum)
//	    ElseIf roundNum = lastRound + 1 Then
//	        GetAbbreviationForRound = "QF"
//	    ElseIf roundNum = lastRound + 2 Then
//	        GetAbbreviationForRound = "SF"
//	    ElseIf roundNum = lastRound + 3 Then
//	        GetAbbreviationForRound = "F"
//	    ElseIf roundNum = lastRound + 4 Then
//	        GetAbbreviationForRound = "BigF"
//	    End If
		if ($round->Pool->Stage->title == "Swissdraw") {
			return $round->rank;
		} elseif ($round->Pool->Stage->title == "Playoff") {
			$abbrv = ($round->rank==1 ? 'QF' : ($round->rank==2 ? 'SF' : ($round->rank==3 ? 'F' : 'P'.$round->rank) ) );
			return $abbrv; 
		} else {
			FB::error('unclear how to name RoundRobin rounds');
			return 'RR'.$round->rank;
		}
		
	}
	
	public static function exportSMSToMySQL($sms) {
		FB::group('Export::exportSMSToMySQL: export SMS with id '.$sms->id);
		
		FB::log('division name '.$sms->Team->name);
		$fh=Export::fileHandle($sms->Team->Division,"SMS");	
		$sql  = sprintf("INSERT INTO `sms_2011` ( `id` , `team_id` , `division` , `round_name` , `message` , `length` ,`number1` , `number2` , `number3` , `number4` , `number5` , `createtime` , `submittime` , `delivertime` , `status` )\n");
		$sql .= sprintf("VALUES ");
		
		FB::log('checking if $sms->Team->mobile1 is empty '.$sms->Team->mobile1.' result: '.($sms->Team->mobile1 != ""));
		if ($sms->Team->mobile1 != "") {
			$value = "(\n   NULL , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->id)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->Division->title)."' , ";
			$value .= "'unknown' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->message)."' , ";
			$value .= "'".SMS::mysql_escape_mimic(strlen($sms->message))."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile1)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile2)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile3)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile4)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile5)."' , ";
			$value .= "'".SMS::mysql_escape_mimic($sms->createTime)."' , '' , '' , ''\n";
			$value .= ")";
			$values[]=$value;
		}	
				
		$sql .= sprintf(implode(", ",$values).";\n\n");
		fwrite($fh, $sql);
		Export::executeSQL($sql);
		
		fclose($fh);
		FB::groupEnd();
		
		return null;
		
		
	}
	
	public static function exportSMSToMySQLByRound($roundId) {
		
		FB::group('Export::exportSMSToMySQL: export SMS for round with id '.$roundId);
		$round=Round::getRoundById($roundId);
			
//		header("content-type: text/plain");

		$fh=Export::fileHandle($round->Pool->Stage->Division,"SMS",$round);		
		
		$sql  = sprintf("INSERT INTO `sms_2011` ( `id` , `team_id` , `division` , `round_name` , `message` , `length` ,`number1` , `number2` , `number3` , `number4` , `number5` , `createtime` , `submittime` , `delivertime` , `status` )\n");
		$sql .= sprintf("VALUES ");
		
		$values=array();
		foreach($round->SMSs as $sms) {
			FB::log('checking if $sms->Team->mobile1 is empty '.$sms->Team->mobile1.' result: '.($sms->Team->mobile1 != ""));
			if ($sms->Team->mobile1 != "") {
				$value = "(\n   NULL , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->id)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($round->Pool->title.' Round '.Export::getAbbreviationForRound($round))."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->message)."' , ";
				$value .= "'".SMS::mysql_escape_mimic(strlen($sms->message))."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile1)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile2)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile3)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile4)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->mobile5)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->createTime)."' , '' , '' , ''\n";
				$value .= ")";
				$values[]=$value;
			}			
		}		
		
		$sql .= sprintf(implode(", ",$values).";\n\n");
		fwrite($fh, $sql);
		Export::executeSQL($sql);
		
		fclose($fh);
		FB::groupEnd();
		return null;
		
		
//		INSERT INTO `sms_2011` ( `id` , `team_id` , `division` , `message` , `number1` , `number2` , `number3` , `number4` , `number5` , `createtime` , `submittime` , `delivertime` , `status` )
//		VALUES (
// NULL , '4', 'mixed', 'another test', '010210201323asdfas', '', '', '', '', '', '', '', ''
// ), (
// NULL , '34', 'teas', 'adsfcxvzxcvxcvxc', '23sdfsadf', '', '', '', '', '', '', '', ''
// );
		
// 		INSERT INTO `sms_2011` ( `id` , `team_id` , `division` , `message` , `number1` , `number2` , `number3` , `number4` , `number5` , `createtime` , `submittime` , `delivertime` , `status` )
//VALUES (
//'1', '2', 'open', 'This is the first test message', '0031619091702', '', '', '', '', '', '', '', ''
//);
		
//		           sSQL = "INSERT INTO score SET round=" & nextRoundNumber & ", division='open', "
//            sSQL = sSQL & "team_home = '" & SQLString(.Offset(i - 1, 0).Value) & "', team_away = '" & SQLString(.Offset(i - 1, 1)) & "'"
//           If .Offset(i - 1, 3) > 0 Then
//                sSQL = sSQL & ", field = " & .Offset(i - 1, 3)
//            End If
  
	}
	
}