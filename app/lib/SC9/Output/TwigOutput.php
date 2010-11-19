<?php


class SC9_Output_TwigOutput { //implements SC9_Output_iOutput {
	
	public $templatePath;
	public $cachePath;
	
	private $twig;
	
	public function __construct($tPath, $cPath) {
		$this->templatePath = $tPath;
		$this->cachePath = $cPath;
		
		$loader = new Twig_Loader_Filesystem($this->templatePath);
		$this->twig = new Twig_Environment($loader, array(
		  'cache' => $this->cachePath,
		  'auto_reload' => true
		));
	}
	
	
	public function loadTemplate($src) {
		return $this->twig->loadTemplate($src);		
	}
}