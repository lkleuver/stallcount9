<?php

class SC9_Factory_Strategy {
	
	
	public static function createStrategy(PoolRuleset $ruleset) {
		$strategyId = $ruleset->PoolStrategy->id;
		switch($strategyId) {
			case 2:
				return new SC9_Strategy_SwissDraw($ruleset->numberOfRounds);
				break;
		}
		
		return null;
	}
}