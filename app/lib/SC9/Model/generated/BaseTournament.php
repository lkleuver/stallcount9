<?php

/**
 * BaseTournament
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property integer $state
 * @property integer $startDate
 * @property integer $endDate
 * @property Doctrine_Collection $Divisions
 * @property Doctrine_Collection $Teams
 * @property Doctrine_Collection $Fields
 * @property Doctrine_Collection $SMSs
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTournament extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('tournament');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('state', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('startDate', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));
        $this->hasColumn('endDate', 'integer', 10, array(
             'type' => 'integer',
             'length' => '10',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Division as Divisions', array(
             'local' => 'id',
             'foreign' => 'tournament_id'));

        $this->hasMany('Team as Teams', array(
             'local' => 'id',
             'foreign' => 'tournament_id'));

        $this->hasMany('Field as Fields', array(
             'local' => 'id',
             'foreign' => 'tournament_id'));

        $this->hasMany('SMS as SMSs', array(
             'local' => 'id',
             'foreign' => 'tournament_id'));
    }
}