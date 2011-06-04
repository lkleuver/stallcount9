<?php

/**
 * RoundMatch
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class RoundMatch extends BaseRoundMatch{
	
	public static function getById($id) {
		$q = Doctrine_Query::create()
			    ->from('RoundMatch m')
			    ->leftJoin('m.Round r')
			    ->leftJoin('r.Pool p')
			    ->leftJoin('m.HomeTeam ht')
			    ->leftJoin('m.AwayTeam at')
			    ->leftJoin('m.Field f')
			    ->where('m.id = ?', $id);
		$match = $q->fetchOne();
		return $match;
	}
		
	
	public function setScheduledTimeByFormat($s) {
		$pieces = explode(":", $s);
		if(count($pieces == 2)) {
			
			$hour = (int) $pieces[0];
			$minute = (int) $pieces[1];
			
			$this->scheduledTime = $hour * 60 + $minute;
		}
	}
	
	public function played() {
		return $this->homeScore != null;
	}
	
	public function homeWon() {
		if($this->homeScore != null && $this->awayScore != null) {
			return $this->homeScore >= $this->awayScore;
		}
		return false;
	}
	
	public function awayWon() {
		if($this->homeScore != null && $this->awayScore != null) {
			return $this->awayScore >= $this->homeScore;
		}
		return false;
	}
	
	public function getFieldName() {
		if($this->Field != null) {
			return $this->Field->title;
		}
		return "empty";
	}
	public function getHomeName() {
		if($this->HomeTeam != null) {
			return $this->HomeTeam->name;
		}
		return $this->homeName;
	}
	
	public function getAwayName() {
		if($this->AwayTeam != null) {
			return $this->AwayTeam->name;
		}
		return $this->awayName;
	}
	
	public function timeFormat() {
		$minutes = $this->scheduledTime;
		
		$hours = floor($minutes / 60);
		$minutes = $minutes - ($hours * 60);
		
		$hourString = $hours < 10 ? "0".$hours : $hours . "";
		$minuteString = $minutes < 10 ? "0".$minutes : $minutes . "";
		
		return $hourString .":".$minuteString;
	}
	
	
}