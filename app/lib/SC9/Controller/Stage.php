<?php



class SC9_Controller_Stage extends SC9_Controller_Core {
	
	public $stageId;
	
	
	public function __construct($output, $params) {
		parent::__construct($output, $params);
		$this->stageId = count($params) > 0 ? $params[0] : "";
	}
	
	public function detailAction() {
		$stage = Stage::getById($this->stageId);
		
		$template = $this->output->loadTemplate('stage/detail.html');
		$template->display(array("stage" => $stage));
	}
	
	public function matchupsAction() {
		$stage = Stage::getById($this->stageId);
		
		$this -> relocate("/stage/detail/".$this->stageId);
	}
	
	public function performmovesAction() {
		$stage = Stage::getById($this->stageId);
		
		// check that previous stage is completed
		
		// check that all moves are present
		try {
			$stage->performMoves();
		} catch (Exception $e) {
			echo $e;
			exit;
		}
		$this -> relocate("/stage/detail/".$this->stageId);
	}

	public function movesAction() {
		$stage = Stage::getById($this->stageId);
		$seedStage = $stage->getParentStage();
		
		$seedStage->Pools; //the call from Twig doesn't fetch the pools; this forces Doctrine to.
		
		$template = $this->output->loadTemplate('stage/moves.html');
		$template->display(array("stage" => $stage, "seedStage" => $seedStage));
	}
	
	
	
	public function setmoveAction() {
		$sourcePoolId = $this->request("sourcePoolId");
		$sourceSpot = $this->request("sourceSpot");
		$destinationPoolId = $this->request("destinationPoolId");
		$destinationSpot = $this->request("destinationSpot");
		
		//avoid conflicts: first delete possible move for associated source and destination spots
		Pool::deleteDestinationMovesForSpot($destinationPoolId, $destinationSpot);
		Pool::deleteSourceMovesForSpot($sourcePoolId, $sourceSpot);
		
				
		$move = new PoolMove();
		$move->pool_id = $destinationPoolId;
		$move->source_pool_id = $sourcePoolId;
		$move->sourceSpot = $sourceSpot;
		$move->destinationSpot = $destinationSpot;
		$move->save();

		if($this->isAjax()) {
			$o = new stdClass();
			$this->ajaxResponse($o);
		}else{
			$this->relocate("/stage/moves/".$this->stageId);
		}
		
	}


	public function createAction() {
		$division = Division::getById($this->request("divisionId"));
		$stage = new Stage(); 
		
		if($this->post("stageSubmit") != "") {
			$stage->title = $this->post("stageTitle");
			$stage->link('Division', array($division->id));
			$stage->rank = $division->getNextRank();			
			$stage->save();
			
			$this->relocate("/division/detail/".$division->id);
		}
		
		$template = $this->output->loadTemplate('stage/create.html');
		$template->display(array("division" => $division, "stage" => $stage));
	}
	
	
	public function removeAction() {
		$stage = Doctrine_Core::getTable("Stage")->find($this->stageId);
		$divisionId = $stage->Division->id; //needed? to lazy to check if delete also empties the object
		foreach($stage->Pools as $pool) {
			$pool->delete();
		}
		$stage->delete();
		$this->relocate("/division/detail/".$divisionId);
	}
	
	
}