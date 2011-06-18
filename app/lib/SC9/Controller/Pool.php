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
			$standingsRound = $pool->currentRound;
		}		
		
		$standings = $pool->getStrategy()->standingsAfterRound($pool,$standingsRound); 
		
		$template = null;
		switch($pool->getStrategy()->getName()) {
			case "Bracket_IGNORE":
				$template = $this->output->loadTemplate("pool/bracket_detail.html");
				break;
			case "FlexPool":
				$template = $this->output->loadTemplate("pool/flex_detail.html");
				break;
			case "Default":
				$template = $this->output->loadTemplate("pool/manual_detail.html");
				break;
			default:
				$template = $this->output->loadTemplate('pool/detail.html');
		}

		
		//echo count($pool->PoolTeams);
		//exit;
		
		$template->display(array("pool" => $pool, "standings" => $standings, "standingsRound" => $standingsRound,"currentRound" => $pool->currentRound));
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
		
		$poolRulesets = PoolRuleset::getList();
		$template = $this->output->loadTemplate('pool/edit.html');
		$template->display(array("stage" => $pool->Stage, "pool" => $pool,"poolRulesets" => $poolRulesets));
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
		if ($this->post("poolUpdate") != "") {
			$pool->title = $this->post("poolTitle");
			if ($pool->spots != $this->post("poolSpots")) {
				echo "changing of number of spots not supported yet.";
				FB::error('changing of number of spots not supported yet.');
				die;
			}
			if ($pool->PoolRuleset->id != $this->post("poolRulesetId")) {
				echo "changing of ruleset not supported yet.";
				FB::error('changing of ruleset not supported yet.');
				die;
			}
			$pool->currentRound = $this->post("poolCurrentRound");
			$pool->save();
			
			$this->relocate("/stage/detail/".$this->post("stageId"));						
		} elseif ($this->post("poolSubmit") != "") {
			$pool->title = $this->post("poolTitle");
			$pool->spots = $this->post("poolSpots");
			$pool->link('Stage', array($this->post("stageId")));
			$pool->link('PoolRuleset', array($this->post("poolRulesetId")));
			$pool->save();
			$pool->rank = $pool->Stage->getNextRank();
			$pool->save();
			
			if ($pool->PoolRuleset->title=="Swissdraw" && $this->post("poolSpots")%2==1) {
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
	
	public function movedownAction() {				
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$pool->swapPoolRankWith(($pool->rank)+1);
		$stageId = $pool->Stage->id;
		
		$this->relocate("/stage/detail/".$stageId.
			"&tournamentId=".$pool->Stage->Division->tournament_id.
			"&divisionId=".$pool->Stage->division_id );
	}
	
	public function moveupAction() {				
		$pool = Doctrine_Core::getTable("Pool")->find($this->poolId);
		$pool->swapPoolRankWith(($pool->rank)-1);
		$stageId = $pool->Stage->id;
		
		$this->relocate("/stage/detail/".$stageId.
			"&tournamentId=".$pool->Stage->Division->tournament_id.
			"&divisionId=".$pool->Stage->division_id );
		
	}
	
	
	public function rankteamsAction() {
		$poolId = $this->request("poolId");
		$ranksRaw = $this->request("ranks");
		$ranks = explode(",", $ranksRaw);
		for($i = 0; $i < count($ranks); $i++) {
			PoolTeam::setTeamRank($poolId, $ranks[$i], $i+1);
		}
		
		if($this->isAjax()) {
			$o = new stdClass();
			$this->ajaxResponse($o);
		}else{
			$this->relocate("/pool/detail/".$poolId);
			
		}
		
	}
	
	
}