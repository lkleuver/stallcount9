<?php


class SC9_Controller_Tournament extends SC9_Controller_Core {
	
	public $tournamentId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params, 'tournament');
		$this->tournamentId = isset($_REQUEST["tournamentId"]) ? $_REQUEST["tournamentId"] : "";
	}
	
	
	public function detailAction() {
		$tournament = Tournament::getById($this->tournamentId);

		$template = $this->output->loadTemplate('tournament/detail.html');
		$template->display(array("tournament" => $tournament));
	}
	
	

	public function createAction() {
		$tournament = new Tournament();
		
		if($this->post("tournamentsubmit") != "") {
			$tournament->title 		= $this->post("tournamentName");
			$tournament->startDate 	= strtotime($this->post("startDate"));
			$tournament->endDate 	= strtotime($this->post("endDate"));
			$tournament->state 		= Tournament::STATE_OPEN;
			$tournament->save();
			
			
			$this->relocate("/tournament/detail/".$tournament->id);
		}
		
		
		$template = $this->output->loadTemplate('tournament/create.html');
		$template->display(array("tournament" => $tournament));
	}
	
	public function removeAction() {
		$tournament = Doctrine_Core::getTable("Tournament")->find($this->tournamentId);
		$tournament->delete();
		$this->relocate("/home/index");
	}
}