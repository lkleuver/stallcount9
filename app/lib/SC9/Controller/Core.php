<?php
class SC9_Controller_Core {
	
	public $output;
	public $params;
	
	public function __construct($output, $params = null, $section = 'tournament') {
		$this->output = $output;
		$this->params = $params;
		
		$this->output->addGlobal("section", $section);

		//TODO: this is horribly insufficient and needs serious refactoring (needs central Model object for object recycling)
		
		$output->addGlobal('tournamentOptions', Tournament::getList());
		
		if(isset($_REQUEST["tournamentId"])) {
			$tournament = Tournament::getById($_REQUEST["tournamentId"]);
			
			$output->addGlobal("tournamentId", $_REQUEST["tournamentId"]);
			$output->addGlobal('activeTournament', $tournament);
			$output->addGlobal('divisionOptions', $tournament->Divisions);
		}
		
		
		if(isset($_REQUEST["divisionId"])) {
			$division = Division::getByIdLight($_REQUEST["divisionId"]);
			$output->addGlobal("divisionId", $division->id);
			$output->addGlobal("activeDivision", $division);
			$output->addGlobal("stageOptions", $division->Stages);
		}
		
		if(isset($_REQUEST["stageId"])) {
			$stage = Stage::getById($_REQUEST["stageId"]);
			$output->addGlobal("stageId", $stage->id);
			$output->addGlobal("activeStage", $stage);
			$output->addGlobal("poolOptions", $stage->Pools);
		}
		
		if(isset($_REQUEST["poolId"])) {
			$pool = Pool::getByIdLight($_REQUEST["poolId"]);
			$output->addGlobal("poolId", $pool->id);
			$output->addGlobal("activePool", $pool);
		}
		
	}
	
	public function indexAction() {
		
	}

	
	public function relocate($path) {
		header("location: index.php?n=".$path);
		exit;
	}
	
	public function ajaxResponse($o, $error = false, $message = "") {
		$o->error = $error ? 1 : 0;
		$o->message = $message;
		header("content-type: application/json");
		echo json_encode($o);
		exit;
	}
	
	public function isAjax() {
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  			return true;
		}
		return false;
	}
	
	public function get($key, $default = "") {
		return isset($_GET[$key]) ? $_GET[$key] : $default;
	}

	public function post($key, $default = "") {
		return isset($_POST[$key]) ? $_POST[$key] : $default;
	}
	
	public function request($key, $default = "") {
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
	}
	
}