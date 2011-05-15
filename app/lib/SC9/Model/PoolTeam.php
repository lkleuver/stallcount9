<?php

/**
 * PoolTeam
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class PoolTeam extends BasePoolTeam
{
	public static function getSortedTeamsByPool($pool_id) {
		$q = Doctrine_Query::create()
			    ->from('PoolTeam pt')
			    ->leftJoin('pt.Team t')
			    ->where('pt.pool_id = ?', $pool_id)
			    ->orderBy('pt.rank ASC, pt.seed ASC');
		$poolteams = $q->execute();
		return $poolteams;
	}
	
	public static function getBySeed($pool_id,$seed) {
		if ($seed === null) {
			trigger_error('seed should not be null when retrieving PoolTeams');
		}
		$q = Doctrine_Query::create()
			    ->from('PoolTeam pt')
			    ->where('pt.pool_id = ?', $pool_id)
			    ->andWhere('pt.seed = ?', $seed);
		$poolteam = $q->fetchOne();
		
		if ($poolteam===false) {
			trigger_error('could not retrieve PoolTeam with pool_id '.$pool_id.' and seed '.$seed);
		}
		return $poolteam;		
	}
	
}