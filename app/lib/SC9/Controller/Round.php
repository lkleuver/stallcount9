<?php


class SC9_Controller_Round extends SC9_Controller_Core {
	
	public $roundId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->roundId = count($params) > 0 ? $params[0] : "";
	}
	
	public function randomScoreAction() {				
//		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$roundId=$this->request('roundId');		
		$round=Round::getRoundById($roundId);
		
		$round->randomScoreFill();			
		$this->relocate("/pool/detail/".$round->Pool->id."&tournamentId=".$round->Pool->Stage->Division->Tournament->id."&divisionId=".$round->Pool->Stage->Division->id."&stageId=".$round->Pool->Stage->id);
	}
		
}