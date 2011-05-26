<?php


class SC9_Controller_Division extends SC9_Controller_Core {
	public $divisionId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->divisionId = isset($_REQUEST["divisionId"]) ? $_REQUEST["divisionId"] : "";
	}
	

	public function scheduleAction() {
		$division = Division::getById($this->divisionId);
		$division->schedule();
		
		echo 'if no error is displayed, games have been successfully scheduled (see FireBug for debug info)<br>';
		exit;
		$this->relocate("/division/detail/".$this->divisionId);
	}
	
	
	
	public function detailAction() {
		$division = Division::getById($this->divisionId);
		
		$template = $this->output->loadTemplate('division/detail.html');
		$template->display(array("division" => $division ));
	}
	

	//TODO: find out how to prelink the Tournament object to division so you only have to assign the division object (needed for edit functionality later)
	public function createAction() {
		$tournament = Tournament::getById($this->request("tournamentId"));
		$division = new Division(); 
		
		
		if($this->post("divisionSubmit") != "") {
			$division->title = $this->post("divisionTitle");
			$division->link('Tournament', array($tournament->id));
			$division->save();
			
			$division->initializeDivision();
			
			$this->relocate("/tournament/detail/".$tournament->id);
		}
		
		$template = $this->output->loadTemplate('division/create.html');
		$template->display(array("tournament" => $tournament, "division" => $division));
	}

	
	public function nextstageAction() {
		$division = Division::getById($this->divisionId);
		$seedingStageId = $this->get("seedingStageId");
		$division->seedNextStage();
		
	}
	
	public function removeAction() {
		$division = Doctrine_Core::getTable("Division")->find($this->divisionId);
		$tournamentId = $division->Tournament->id; //needed? to lazy to check if delete also empties the object
		$division->delete();
		$this->relocate("/tournament/detail/".$tournamentId);
	}
	
}