<?php

interface SC9_Strategy_Interface {
	
	
	public function getName();
	public function calculateNumberOfRounds($teamCount);
	public function createMatchups($pool);
	public function standingsAfterRound($pool,$roundNr);
	public function nameMatches($pool);
	public function createSMS($pool,$roundId);
	
}