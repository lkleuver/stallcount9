<?php


class SC9_Controller_SMS extends SC9_Controller_Core {
	
	public $smsId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params, "sms");
		$this->smsId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function listAction() {
		$SMSs = SMS::getList($this->get("tournamentId"));

		$template = $this->output->loadTemplate('sms/list.html');
		$template->display(array("SMSs" => $SMSs, "tournamentId" => $this->get("tournamentId")));
	}
	
	
//	public function editAction() {
//		$field = Field::getById($this->fieldId);
//		
//		if($this->handleFormSubmit($field)) {
//			$this->relocate("/field/list/&tournamentId=".$field->tournament_id);
//		}
//		
//		$template = $this->output->loadTemplate('field/edit.html');
//		$template->display(array("field" => $field));
//	}
	
	public function createAction() {
		$sms = new SMS();
		$sms->link('Tournament', array($this->request("tournamentId")));
		$tournament = Tournament::getById($this->request("tournamentId"));
				
		foreach($tournament->Divisions as $division) {
			foreach($division->Teams as $team) {
				$teams[]=$team;
			}
		}
		
		if($this->handleFormSubmit($sms,$teams)) {
			$this->relocate("/sms/list/&tournamentId=".$this->post("tournamentId"));
		}
		
		
		$template = $this->output->loadTemplate('sms/create.html');
		$template->display(array("sms" => $sms,"teams" => $teams));
	}
	
//	public function createrangeAction() {
//		$rangeStart = (int) $this->request("rangeStart");
//		$rangeEnd = (int) $this->request("rangeEnd");
//		$prefix = $this->request("prefix");
//		
//		for($i = $rangeStart; $i <= $rangeEnd; $i++) {
//			$field = new Field();
//			$field->tournament_id = $this->get("tournamentId");
//			$field->title = $prefix ." " . $i;
//			$field->comments = "";
//			$field->link('Tournament', array($this->post("tournamentId")));
//			$field->rank = $i;
//			$field->save();			
//		}
//		$this->relocate("/field/list/&tournamentId=".$this->request("tournamentId"));
//	}
	
	private function handleFormSubmit($sms,$teams) {
		if($this->post("smssubmit") != "") {
			if ($this->post("teamId") > 0) {
				$sms->link('Team', array($this->post("teamId")));
				$sms->message		= $this->post("smsMessage");
				$sms->link('Tournament', array($this->post("tournamentId")));
				$sms->createTime=time();
				$sms->save();
			} else {  // send SMS to all teams
				foreach($teams as $team) {
					FB::log('creating SMS for team '.$team->name);
					$sms = new SMS();
	 				$sms->link('Team', array($team->id));
					$sms->message		= $this->post("smsMessage");
					$sms->link('Tournament', array($this->post("tournamentId")));
					$sms->createTime=time();
					$sms->save();
				}				
			}
			return true;
		}
		return false;
	}
	
//	public function removeAction() {
//		$tournament = Doctrine_Core::getTable("Tournament")->find($this->tournamentId);
//		$tournament->delete();
//		$this->relocate("/home/index");
//	}
}