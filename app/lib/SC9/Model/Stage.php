<?php

/**
 * Stage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Stage extends BaseStage{

	public static function getById($id) {
		return Doctrine_Core::getTable("Stage")->find($id);
	}
	
}