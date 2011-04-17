<?php

class SC9_Factory_Strategy {
	
	
	public static function createStrategy(PoolRuleset $ruleset) {
		$strategyTitle = $ruleset->PoolStrategy->title;

		switch($strategyTitle) {
			case "Swissdraw":
				return new SC9_Strategy_SwissDraw($ruleset->numberOfRounds);
			case "Bracket": 
				return new SC9_Strategy_Bracket();
			case "RoundRobin":
				return new SC9_Strategy_RoundRobin();				
			default:
				return new SC9_Strategy_Default();
		}
		
		return null;
	}
}