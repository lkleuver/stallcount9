<?php

/**
 * BaseSMS
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $team_id
 * @property integer $round_id
 * @property integer $tournament_id
 * @property string $message
 * @property integer $status
 * @property integer $createTime
 * @property integer $submitTime
 * @property integer $sentTime
 * @property integer $receivedTime
 * @property Tournament $Tournament
 * @property Team $Team
 * @property Round $Round
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSMS extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('s_m_s');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('team_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('round_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('tournament_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('message', 'string', 500, array(
             'type' => 'string',
             'length' => '500',
             ));
        $this->hasColumn('status', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('createTime', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));
        $this->hasColumn('submitTime', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));
        $this->hasColumn('sentTime', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));
        $this->hasColumn('receivedTime', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));

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

        $this->hasOne('Team', array(
             'local' => 'team_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Round', array(
             'local' => 'round_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}