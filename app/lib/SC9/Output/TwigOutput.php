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
		
		
		$this->twig->addFilter('timeFormat', new Twig_Filter_Function('SC9_Output_TwigOutput::timeFormat'));
	}
	
	
	public function loadTemplate($src) {
		return $this->twig->loadTemplate($src);		
	}
	
	public function addGlobal($key, $value) {
		$this->twig->addglobal($key, $value);
	}
	
	public static function timeFormat($string) {
		$minutes = (int) $string;
		
		$hours = floor($minutes / 60);
		$minutes = $minutes - ($hours * 60);
		
		$hourString = $hours < 10 ? "0".$hours : $hours . "";
		$minuteString = $minutes < 10 ? "0".$minutes : $minutes . "";
		
		return $hourString .":".$minuteString;
	}
	

}