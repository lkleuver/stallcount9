<?php


class SC9_Controller_Match extends SC9_Controller_Core {
	
	public $poolId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->matchId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$match = RoundMatch::getById($this->matchId);
		
		$template = $this->output->loadTemplate('match/detail.html');		
		$template->display(array("match" => $match));
	}
	
	
	public function editAction() {
		$match = RoundMatch::getById($this->matchId);
		
		if($this->handleFormSubmit($match)) {
			$this->relocate("/pool/detail/".$match->Round->pool_id."&tournamentId=".$this->request("tournamentId")."&divisionId=".$this->request("divisionId")."&stageId=".$this->request("stageId"));	
		}
		
		$template = $this->output->loadTemplate('match/edit.html');		
		$template->display(array("match" => $match, "fields" => Field::getList($this->request("tournamentId"))));
	}
	
	
	
	private function handleFormSubmit($match) {
		if($this->post("matchSubmit") != "") {
			$match->homeScore = $this->post("homeScore");
			$match->awayScore = $this->post("awayScore");
			$match->homeSpirit = $this->post('homeSpirit');
			$match->awaySpirit = $this->post('awaySpirit');
			$match->field_id = $this->post("fieldId");
			$match->save();
			return true;
		}
		return false;
	}
	
}