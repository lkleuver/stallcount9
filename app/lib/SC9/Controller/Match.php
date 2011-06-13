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
			$this->relocate("/pool/detail/".$match->Round->pool_id.
				"&tournamentId=".$this->request("tournamentId").
				"&divisionId=".$this->request("divisionId").
				"&stageId=".$this->request("stageId"));	
		}
		
		$template = $this->output->loadTemplate('match/edit.html');		
		$template->display(array("match" => $match, "fields" => Field::getList($this->request("tournamentId"))));
	}
	
	public function switchfieldsAction() {
		$match1 = RoundMatch::getById($this->request("id1"));
		$match2 = RoundMatch::getById($this->request("id2"));
		
		$fieldId = $match1->field_id;
		$match1->field_id = $match2->field_id;
		$match2->field_id = $fieldId;
		
		$match1->save();
		$match2->save();
		
		if($this->isAjax()) {
			$o = new stdClass();
			$this->ajaxResponse($o);
		}else{
			$this->relocate("/pool/detail/".$match1->Round->pool_id.
				"&tournamentId=".$this->request("tournamentId").
				"&divisionId=".$this->request("divisionId").
				"&stageId=".$this->request("stageId"));	
		}
	}
	
	public function settimeAction() {
		$match = RoundMatch::getById($this->request("matchId"));
		$match->scheduledTime = $this->request("scheduledTime");
		$match->save();
		
		if($this->isAjax()) {
			$o = new stdClass();
			$o->matchId = $match->id;
			$this->ajaxResponse($o);
		}else{
			$this->relocate("/pool/detail/".$match->Round->pool_id.
				"&tournamentId=".$this->request("tournamentId").
				"&divisionId=".$this->request("divisionId").
				"&stageId=".$this->request("stageId"));	
		}
	}
	
	public function setscoreAction() {
		$match = RoundMatch::getById($this->request("matchId"));
		if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {		
			$match->homeScore = $this->request("homeScore");
			$match->awayScore = $this->request("awayScore");
			$match->save();
		} else {
			FB::error('either home or away team of this match is not set, it should not be edited');
			die('either home or away team of this match is not set, it should not be edited');			
		}
		
		if($this->isAjax()) {
			$o = new stdClass();
			$o->matchId = $match->id;
			$this->ajaxResponse($o);
		}else{
			$this->relocate("/pool/detail/".$match->Round->pool_id.
				"&tournamentId=".$this->request("tournamentId").
				"&divisionId=".$this->request("divisionId").
				"&stageId=".$this->request("stageId"));			}
	}
	
	private function handleFormSubmit($match) {
		if($this->post("matchSubmit") != "") {
			if (!is_null($match->home_team_id) && !is_null($match->away_team_id)) {
				$match->homeScore = $this->post("homeScore") != "" ? $this->post("homeScore") : null;
				$match->awayScore = $this->post("awayScore") != "" ? $this->post("awayScore") : null;
				$match->homeSpirit = $this->post('homeSpirit');
				$match->awaySpirit = $this->post('awaySpirit');
				$match->field_id = $this->post("fieldId") != "0" ? $this->post("fieldId") : null;
				$match->setScheduledTimeByFormat($this->post("scheduledTimeHour"));
				
				$match->save();
			} else {
				FB::error('either home or away team of this match is not set, it should not be edited');
				die('either home or away team of this match is not set, it should not be edited');
			}
			return true;
		}
		return false;
	}
	
}