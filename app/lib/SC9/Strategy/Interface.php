<?php

interface SC9_Strategy_Interface {
	
	
	public function getName();
	public function calculateNumberOfRounds($teamCount);
	public function createMatchups($pool);
	public function standingsAfterRound($pool,$roundNr);
}