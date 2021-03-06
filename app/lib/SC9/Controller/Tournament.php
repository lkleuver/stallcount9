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
	
	public function saveAction() {
		$modelsPath = dirname(__FILE__).'/../Model';
		$s = time() . "";
		$filename='app/build/fixtures/SaveFromSite'.$s.'.yml';
		
		echo "saving all tournament data to ".$filename;
		FB::log("saving all tournament data to ".$filename);
		
		Doctrine_Core::debug(true);
		Doctrine_Core::loadModels($modelsPath);
		Doctrine_Core::dumpData($filename);
		
		echo "<br><br>done!";
		FB::log('done!');
		
	}
	
	public function windmill2011CheckAction() {
		echo "Do you really want to delete all data and reset the initial configuration of Windmill 2011?<br><br>";
		echo '<a href="?n=/tournament/windmill2011">DO IT!</a>';		
	}
	
	public function windmill2011Action() {
		Doctrine_Core::debug(true);		
		$modelsPath = dirname(__FILE__).'/../Model';
		$options = array();
		
//		echo "deleting all data and initializing with Windmill 2011 data";
//		FB::log("deleting all data");
		//deleting old models first (dangerous!)
		
		FB::group('re-initialize Windmill 2011 data');
		FB::log('dropping Databases');
		Doctrine_Core::dropDatabases();
		Doctrine_Core::createDatabases();
//		Doctrine_Core::generateModelsFromYaml(dirname(__FILE__).'/../../../build/schema/base.yml', $modelsPath, $options);
		Doctrine_Core::createTablesFromModels($modelsPath);
		
	
		
		FB::log('loading Windmill 2011 fixtures');
//		Doctrine_Core::loadData("app/build/fixtures/core.yml");
		Doctrine_Core::loadData("app/build/fixtures/Windmill2011.yml");
		
		FB::groupEnd();
		$this->relocate("/tournament/detail/1");
		
	}
}