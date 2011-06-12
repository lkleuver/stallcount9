<?php

/**
 * SMS
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class SMS extends BaseSMS
{
	public static function getList($tournamentId) {
		$q = Doctrine_Query::create()
			    ->from('SMS s')
			    ->leftJoin('s.Team t')
			    ->where('s.tournament_id = ?', $tournamentId)
			    ->orderBy('s.createTime ASC');
	 	FB::log($q->getSqlQuery());
		return $q->execute();
	}
	
	public static function addOrdinalNumberSuffix($num) {
	    if (!in_array(($num % 100),array(11,12,13))){
	      switch ($num % 10) {
	        // Handle 1st, 2nd, 3rd
	        case 1:  return $num.'st';
	        case 2:  return $num.'nd';
	        case 3:  return $num.'rd';
	      }
	    }
	    return $num.'th';
	}
  
	public static function mysql_escape_mimic($inp) {
	    if(is_array($inp))
	        return array_map(__METHOD__, $inp);
	
	    if(!empty($inp) && is_string($inp)) {
	        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
	    }
	
	    return $inp;
	} 
	
}