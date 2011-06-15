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
			case "FlexPool":
				return new SC9_Strategy_FlexPool();								
			default:
				return new SC9_Strategy_Default();
		}
		
		return null;
	}
}