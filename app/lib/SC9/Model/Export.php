<?php 

class Export {
// collection of functions for exporting data to MySQL
	private function fileHandleFromRound($round,$task=false) {
		// returns write file handle to the file  stallcount9\app\export\$division\$poolname_$roundrank_$task.txt
		// if file exists, adjusts file handle
		// also makes sure division directory exists
		
		if ($task === false) {
			trigger_error('$task should be specified when exporting!');			
		}
		
		$directoryname=dirname(__FILE__) . '/../../../export/'.$round->Pool->Stage->Division->title;
		if (!file_exists($directoryname) ){
			mkdir($directoryname);
		}
		
		$filename = dirname(__FILE__) . '/../../../export/'.$round->Pool->Stage->Division->title.'/'.$round->Pool->title.'Round'.$round->rank.'_'.$task.'.txt';
		FB::log('creating file handle for task '.$task.' for round with id '.$round->id.' to '.$filename);
		
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
	
	public static function exportRoundResultsToMySQL($roundId) {
	//	sSQL = "UPDATE score SET score_home = " & .Offset(i - 1, 1) & ", score_away = " & .Offset(i - 1, 3)
	//	sSQL = sSQL & " WHERE team_home = '" & SQLString(.Offset(i - 1, 0)) & "' && team_away = '" & SQLString(.Offset(i - 1, 2)) & "'"
	//	sSQL = sSQL & " && division='" & Range("Division") & "' && round = " & curRound

		$round=Round::getRoundById($roundId);		
		FB::group('Export::exportRoundResultsToMySQL: export results of round '.$round->rank.' of pool with id '.$round->pool_id);
		
		$fh=Export::fileHandleFromRound($round,"Results");
		
		foreach($round->Matches as $match) {
			$sql = "REPLACE score_2011 SET score_home = '".$match->homeScore."', score_away = '".$match->awayScore."'";
			$sql .= " WHERE team_home = '".SMS::mysql_escape_mimic($match->HomeTeam->name)."' && team_away = '".SMS::mysql_escape_mimic($match->AwayTeam->name)."'";			
			$sql .= " && division = '".$round->Pool->Stage->Division->title."' && round = '".$round->rank."';\n";
			fwrite($fh,$sql);			
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
		
		$fh=Export::fileHandleFromRound($round,"Standings");
		$standings = $round->Pool->getStrategy()->standingsAfterRound($round->Pool, $round->rank); 
		
		if ($round->Pool->PoolRuleset->title == "Swissdraw") {
			foreach($standings as $team) {
				$sql = "REPLACE INTO standing_2011 SET round = '".$round->rank."', division = '".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."'";
				$sql .= ", team = '".SMS::mysql_escape_mimic($team['name'])."', VP = '".SMS::mysql_escape_mimic($team['vp'])."'";
				$sql .= ", opp_vp = '".SMS::mysql_escape_mimic($team['opp_vp'])."', margin = '".SMS::mysql_escape_mimic($team['margin'])."'";
				$sql .= ", scored = '".SMS::mysql_escape_mimic($team['scored'])."', rank = '".SMS::mysql_escape_mimic($team['rank'])."'\n";
				fwrite($fh,$sql);			
			}
		} elseif ($round->Pool->PoolRuleset->title == "RoundRobin") {
				$sql = "REPLACE INTO standing_2011 SET round = '".$round->rank."', division = '".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."'";
				$sql .= ", team = '".SMS::mysql_escape_mimic($team['name'])."', points = '".SMS::mysql_escape_mimic($team['points'])."'";
				$sql .= ", margin = '".SMS::mysql_escape_mimic($team['margin'])."'";
				$sql .= ", scored = '".SMS::mysql_escape_mimic($team['scored'])."', rank = '".SMS::mysql_escape_mimic($team['rank'])."'\n";
				fwrite($fh,$sql);						
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
				
		$fh=Export::fileHandleFromRound($round,"Matchups");
		
//		header("content-type: text/plain");
		
		foreach($round->Matches as $match) {
			$sql = "INSERT INTO score_2011 SET round = ".$round->rank.", division = '".$round->Pool->Stage->Division->title."'";
			$sql .= ", team_home = '".SMS::mysql_escape_mimic($match->HomeTeam->name)."', team_away = '".SMS::mysql_escape_mimic($match->AwayTeam->name)."'";
			if ($match->Field !== null) {
				$sql .= ", field = '".$match->Field->title."'";
			}
			$sql .= "\n";
			fwrite($fh,$sql);			
		}

		fclose($fh);
		FB::groupEnd();
		return null;
	}
	
	public static function exportSMSToMySQL($roundId) {
		
		FB::group('Export::exportSMSToMySQL: export SMS for round with id '.$roundId);
		$round=Round::getRoundById($roundId);
		
		
//		header("content-type: text/plain");

		$fh=Export::fileHandleFromRound($round,"SMS");		
		
		fwrite($fh,"INSERT INTO `sms_2011` ( `id` , `team_id` , `division` , `round_name` , `message` , `length` ,`number1` , `number2` , `number3` , `number4` , `number5` , `createtime` , `submittime` , `delivertime` , `status` )\n");
		fwrite($fh,"VALUES ");
		
		$values=array();
		foreach($round->SMSs as $sms) {
			FB::log('checking if $sms->Team->mobile1 is empty '.$sms->Team->mobile1.' result: '.($sms->Team->mobile1 != ""));
			if ($sms->Team->mobile1 != "") {
				$value = "(\n   NULL , ";
				$value .= "'".SMS::mysql_escape_mimic($sms->Team->id)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($round->Pool->Stage->Division->title)."' , ";
				$value .= "'".SMS::mysql_escape_mimic($round->Pool->title.' Round '.$round->rank)."' , ";
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
		
		fwrite($fh, implode(", ",$values).";\n\n" );
		
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