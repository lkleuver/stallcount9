<?php


class SC9_Controller_Pool extends SC9_Controller_Core {
	
	public $poolId;
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		
		$this->poolId = count($params) > 0 ? $params[0] : "";
	}
	
	
	public function detailAction() {
		$pool = Pool::getById($this->poolId);
		
		if ($this->request("standingsRound") != "" ) {
			$standingsRound = $this->request("standingsRound");
		} else {
			$standingsRound = $pool->currentRound-1;
		}		
		
		$standings = $pool->standingsAfterRound($standingsRound); 		
		$template = $this->output->loadTemplate('pool/detail.html');		
		$template->display(array("pool" => $pool, "standings" => $standings, "standingsRound" => $standingsRound));
	}
	
	public function matchupsAction() {
		$pool = Pool::getById($this->poolId);
		$pool->createMatchups();
		
		//$this->relocate("/pool/detail/".$this->poolId);
		
	}
	
	public function createAction() {
		$stage = Stage::getById($this->request("stageId"));
		$pool = new Pool();
		
		$this->handleFormSubmit($pool);		

		$poolRulesets = PoolRuleset::getList();
		$template = $this->output->loadTemplate('pool/create.html');
		$template->display(array("stage" => $stage, "pool" => $pool, "poolRulesets" => $poolRulesets));
	}
	
	
	public function editAction() {
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		
		$this->handleFormSubmit($pool);		

		
		$template = $this->output->loadTemplate('pool/edit.html');
		$template->display(array("stage" => $pool->Stage, "pool" => $pool));
	}
	
	
	public function addteamAction() {
		$teamId = $this->request("teamId");
		$poolTeam = new PoolTeam();
		$poolTeam->team_id = $teamId;
		$poolTeam->pool_id = $this->poolId;
		$poolTeam->save();
		
		$this->relocate("/pool/detail/".$this->poolId);
	}
	
	public function removeteamAction() {
		$teamId = $this->request("teamId");
		$pool = Doctrine_Core::getTable('Pool')->find($this->poolId);
		$pool->unlink('Teams', array($teamId));
		$pool->save();
		$this->relocate("/pool/detail/".$this->poolId);
	}
	
	
	private function handleFormSubmit($pool) {
		if($this->post("poolSubmit") != "") {
			$pool->title = $this->post("poolTitle");
			$pool->spots = $this->post("poolSpots");
			$pool->link('Stage', array($this->post("stageId")));
			$pool->link('PoolRuleset', array($this->post("poolRulesetId")));
			$pool->save();
						
			if ($this->post("poolRulesetId")==2 && $this->post("poolSpots")%2==1) {
				// Swissdraw and odd number of spots
				
				// increase number of spots by 1
				$pool->spots++;
				$pool->save();
				
				// create a BYE team
				$BYEteam = new Team();
				$BYEteam->byeStatus=1; 
				$BYEteam->name = "BYE Team";				
				$BYEteam->link('Division', array($pool->Stage->division_id));
				$BYEteam->save();
				
//				echo "pool_id: ".$pool->id."<br>";
//				echo "BYEteam_id ".$BYEteam->id."<br>";
				
				//now add this team to the Swissdraw pool
				$poolTeam = new PoolTeam();
				$poolTeam->team_id = $BYEteam->id;
				$poolTeam->pool_id = $pool->id;
				$poolTeam->rank = $pool->spots;
				$poolTeam->seed = $pool->spots;
				$poolTeam->save();
				
				// TODO: Display a message that the BYE team has been automatically generated
				
			}

			$this->relocate("/stage/detail/".$this->post("stageId"));
		}
	}
	
	
	
	public function removeAction() {
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$stageId = $pool->Stage->id; //needed? to lazy to check if delete also empties the object
		$pool->delete();
		$this->relocate("/stage/detail/".$stageId);
	}
	
}