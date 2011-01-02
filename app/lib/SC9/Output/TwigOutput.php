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
		
		
		//$this->twig->addFunction('path', new Twig_Function_Function('SC9_Output_TwigOutput::path'));
	}
	
	
	public function loadTemplate($src) {
		return $this->twig->loadTemplate($src);		
	}
	
	/**
	 * 
	 * Function used to create the paths for links in SC9.
	 * @param String $p
	 */
	public static function path($p) {
		return "/?n=".$p;
	}
}