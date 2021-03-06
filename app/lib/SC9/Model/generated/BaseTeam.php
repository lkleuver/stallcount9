<?php

/**
 * BaseTeam
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $shortName
 * @property string $email1
 * @property string $email2
 * @property string $contactName
 * @property string $city
 * @property string $country
 * @property string $mobile1
 * @property string $mobile2
 * @property string $mobile3
 * @property string $mobile4
 * @property string $mobile5
 * @property string $comment
 * @property integer $tournament_id
 * @property integer $division_id
 * @property integer $byeStatus
 * @property Tournament $Tournament
 * @property Division $Division
 * @property Doctrine_Collection $PoolTeams
 * @property Doctrine_Collection $HomeMatches
 * @property Doctrine_Collection $AwayMatches
 * @property Doctrine_Collection $SMSs
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTeam extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('team');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('shortName', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email1', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email2', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('contactName', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('city', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('country', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('mobile1', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('mobile2', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('mobile3', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('mobile4', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('mobile5', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('comment', 'string', 1000, array(
             'type' => 'string',
             'length' => '1000',
             ));
        $this->hasColumn('tournament_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('division_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('byeStatus', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));


        $this->setAttribute(Doctrine_Core::ATTR_EXPORT, Doctrine_Core::EXPORT_ALL);
        $this->setAttribute(Doctrine_Core::ATTR_VALIDATE, true);

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Tournament', array(
             'local' => 'tournament_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Division', array(
             'local' => 'division_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('PoolTeam as PoolTeams', array(
             'local' => 'id',
             'foreign' => 'team_id'));

        $this->hasMany('RoundMatch as HomeMatches', array(
             'local' => 'id',
             'foreign' => 'home_team_id'));

        $this->hasMany('RoundMatch as AwayMatches', array(
             'local' => 'id',
             'foreign' => 'away_team_id'));

        $this->hasMany('SMS as SMSs', array(
             'local' => 'id',
             'foreign' => 'team_id'));
    }
}