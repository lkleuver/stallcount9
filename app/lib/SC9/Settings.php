<?php
/**
 * Temporary Settings solution
 * 
 * @package     SC9
 * @author      Les Kleuver
 * @version     1
 */
class SC9_Settings {
	
	public $skin = "default";
		
	public $database = array(
		'type' => 'mysql', 
		'user' => 'root', 
		'password' => '', 
		'name' => 'stallcount9', 
		'host' => '127.0.0.1'
	);
	
	
	public function __construct($config = null) {
		if($config != null) {
			foreach($config as $k => $v) {
				if(!is_array($v)) {
					$this->{$k} = $v;
				}else{
					foreach($v as $k2 => $v2) {
						$this->{$k}[$k2] = $v2;
					}
				}
			}
		}
	}

}