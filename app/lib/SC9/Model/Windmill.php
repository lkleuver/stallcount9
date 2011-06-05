<?php 

class Windmill {
	// Windmill Windup 2011 fixtures
	
	public static function insertMatchTimes($pool) {
		// insert playing times of Windmill 2011 schedule
		// depending on the division name: open, women, mixed
		
		FB::group('inserting Windmill Windup 2011 playing times');
		
//  open division:
//		Swiss 1: 	17.06.2010	11:15 (game length: 75min)
//		Swiss 2: 	17.06.2010	14:00 (game length: 90min)
//		Swiss 3: 	17.06.2010	17:00
//		Swiss 4: 	18.06.2010	09:00
//		Swiss 5: 	18.06.2010	12:00
//		QF: 		18.06.2010	15:00
//		Semis: 		18.06.2010	18:00
//		Finals: 	19.06.2010	10:30
//		BigFinal: 	19.06.2010	15:00
		
		$openSwiss=array( mktime(11, 15, 0, 6, 17, 2011), mktime(14, 00, 0, 6, 17, 2011),  
			mktime(17, 00, 0, 6, 17, 2011), mktime(9, 00, 0, 6, 18, 2011), mktime(12, 00, 0, 6, 18, 2011));
		$openPlayoff=array( mktime(15, 00, 0, 6, 18, 2011), mktime(18, 00, 0, 6, 18, 2011),  
			mktime(10, 30, 0, 6, 19, 2011), mktime(15, 00, 0, 6, 19, 2011));

//  women/mixed division:
//		Swiss 1: 	17.06.2010	10:00 (game length: 75min)
//		Swiss 2: 	17.06.2010	12:30 (game length: 90min)
//		Swiss 3: 	17.06.2010	15:30
//		Swiss 4: 	18.06.2010	10:30
//		Swiss 5: 	18.06.2010	13:30
//		QF: 		18.06.2010	16:30
//		Semis: 		19.06.2010	09:00
//		Finals: 	19.06.2010	12:00

//		mixed Fin: 	19.06.2010	14:00
//		women Fin: 	19.06.2010	13:00

		$mixedSwiss=array( mktime(10, 00, 0, 6, 17, 2011), mktime(12, 30, 0, 6, 17, 2011),  
			mktime(15, 30, 0, 6, 17, 2011), mktime(10, 30, 0, 6, 18, 2011), mktime(13, 30, 0, 6, 18, 2011));
	    $womenSwiss=$mixedSwiss;
		$mixedPlayoff=array( mktime(16, 30, 0, 6, 18, 2011), mktime(9, 00, 0, 6, 19, 2011),  
			mktime(12, 00, 0, 6, 19, 2011), mktime(14, 00, 0, 6, 19, 2011));
		$womenPlayoff=array( mktime(16, 30, 0, 6, 18, 2011), mktime(9, 00, 0, 6, 19, 2011),  
			mktime(12, 00, 0, 6, 19, 2011), mktime(13, 00, 0, 6, 19, 2011));						

        if ($pool->PoolRuleset->title == "Swissdraw") {
        	$roundNr=0;        	
        	foreach($pool->Rounds as $round) {
        		FB::log('inserting playing times for matches in round '.$round->rank.' of pool '.$pool->title);
        		foreach($round->Matches as $match) {
        			$match->scheduledTime=($pool->Stage->Division->title == "open" ? $openSwiss[$roundNr] : $mixedSwiss[$roundNr]);    			
        		}
        		$round->save();
        		$roundNr++;    
        	}
        } elseif ($pool->PoolRuleset->title == "Bracket") {
        	$roundNr=0;
        	foreach($pool->Rounds as $round) {
        		FB::log('inserting playing times for matches in round '.$round->rank.' of pool '.$pool->title);
        		foreach($round->Matches as $match) {
        			$match->scheduledTime=($pool->Stage->Division->title == "open" ? $openPlayoff[$roundNr] : $mixedPlayoff[$roundNr]);
        		}
        		$round->save();
        		$roundNr++;        			        		
        	}
        	// big finals are special:
        	if ($pool->rank == 1) {
        		if ($pool->Stage->Division->title == "open") {
        			FB::log('name of big final '.$pool->Rounds[2]->Matches[0]->matchName);
        			$pool->Rounds[2]->Matches[0]->scheduledTime = $openPlayoff[3];
        			FB::log('now scheduled for '.date("d-m-y h:mm",$openPlayoff[3]));        			
        		} elseif ($pool->Stage->Division->title == "women") {
        			FB::log('name of big final '.$pool->Rounds[2]->Matches[0]->matchName);
        			$pool->Rounds[2]->Matches[0]->scheduledTime = $womenPlayoff[3];
        			FB::log('now scheduled for '.date("d-m-y h:mm",$womenPlayoff[3]));        			
        		} elseif ($pool->Stage->Division->title == "mixed") {
        			FB::log('name of big final '.$pool->Rounds[2]->Matches[0]->matchName);
        			$pool->Rounds[2]->Matches[0]->scheduledTime = $mixedPlayoff[3];
        			FB::log('now scheduled for '.date("d-m-y h:mm",$mixedPlayoff[3]));        			
        		} 
        		$pool->save();
        	}
        } else {
        	FB::error('pool with id '.$pool->id.' is probably round robin, do not know playing times...');
        }
        
        FB::groupEnd();
					
	}
	
}