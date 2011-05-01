<?php

/**
 * VictoryPoints
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class VictoryPoints extends BaseVictoryPoints
{
	public static function getByMargin($margin) {
		$q = Doctrine_Query::create()
			    ->from('VictoryPoints vp')
			    ->where('vp.margin = ?', $margin);
		$vp = $q->fetchOne();
		return $vp->victorypoints;
	}
	
}