<?php


class SC9_Controller_Team extends SC9_Controller_Core {
	
	public $teamId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->teamId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$team = Doctrine_Core::getTable("Team")->find($this->teamId);
		
		$template = $this->output->loadTemplate('team/detail.html');
		$template->display(array("team" => $team));
	}
	
	public function createAction() {
		$division = Division::getById($this->request("divisionId"));
		$team = new Team();
		if($this->handleFormSubmit($team)) {
			
			//now add this team to the registration seeding pool
			$poolTeam = new PoolTeam();
			$poolTeam->team_id = $team->id;
			$poolTeam->pool_id = $division->getSeedPoolId();
			$poolTeam->rank = count($division->Teams) + 1;
			$poolTeam->save();
			
			$this->relocate("/division/detail/".$this->post("divisionId"));
		}
		
		
		$template = $this->output->loadTemplate('team/create.html');
		$template->display(array("division" => $division, "team" => $team));
	}
	
	public function create25Action() {
		$division = Division::getById($this->request("divisionId"));
		$teamnames=array("Jeremy Codhand", "GronicalDizzines", "Tallinn Frisbee", "Russo Turisto", "OUF", "Hungary Coed Tea", "Frizzly Bears", "Ah Ouh PUC", "France coed", "Wunderteam", "Principality of Sealand", "Sugar-Mix", "Team 2600", "DiscComfort", "Half Men Half", "Rusty Bikes", "Ultimate de Lux", "Los Quijotes", "Frankdam-Amsterfurt Connection", " Jabba the Huck", "Free Hucks", "XLR8RS", "WAF", "Cranberry Snack", "Random Fling");		
		
		for ($i=0 ; $i <25; $i++) {
			$team = new Team();
			$team->name=$teamnames[$i];
			$team->link('Division', array($this->request("divisionId")));
			$team->save();
						
			//now add this team to the registration seeding pool
			$poolTeam = new PoolTeam();
			$poolTeam->team_id = $team->id;
			$poolTeam->pool_id = $division->getSeedPoolId();
			$poolTeam->seed = count($division->Teams) + $i + 1;			
			$poolTeam->rank = count($division->Teams) + $i + 1;
			$poolTeam->save();
		}
			
		$this->relocate("/division/detail/".$this->request("divisionId"));
	}
	
	
	
	
	public function editAction() {
		$team = Doctrine_Core::getTable("Team")->find($this->teamId);
		
		if($this->handleFormSubmit($team)) {
			$this->relocate("/division/detail/".$this->post("divisionId"));
		}

		
		$template = $this->output->loadTemplate('team/edit.html');
		$template->display(array("division" => $team->Division, "team" => $team));
	}
	
	
	private function handleFormSubmit($team) {
		if($this->post("teamSubmit") != "") {
			$team->name = $this->post("teamName");
			$team->link('Division', array($this->post("divisionId")));
			$team->save();
			return true;
		}
		return false;
	}
	
	
	//TODO: doesn't work because of FOREIGN_KEY constraints with POOL_TEAM	
	public function removeAction() {
 		$team = Doctrine_Core::getTable("Team")->find($this->teamId);
		$divisionId = $team->Division->id; //needed? to lazy to check if delete also empties the object
		$team->delete();
		$this->relocate("/division/detail/".$divisionId);
	}
	
}