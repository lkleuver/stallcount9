<?php

/**
 * BasePool
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property integer $pool_template_id
 * @property integer $stage_id
 * @property PoolTemplate $PoolTemplate
 * @property Stage $Stage
 * @property Doctrine_Collection $Teams
 * @property Doctrine_Collection $PoolTeams
 * @property Doctrine_Collection $Rounds
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePool extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('pool');
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
        $this->hasColumn('pool_template_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('stage_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PoolTemplate', array(
             'local' => 'pool_template_id',
             'foreign' => 'id'));

        $this->hasOne('Stage', array(
             'local' => 'stage_id',
             'foreign' => 'id'));

        $this->hasMany('Team as Teams', array(
             'refClass' => 'PoolTeam',
             'local' => 'pool_id',
             'foreign' => 'team_id'));

        $this->hasMany('PoolTeam as PoolTeams', array(
             'local' => 'id',
             'foreign' => 'pool_id'));

        $this->hasMany('Round as Rounds', array(
             'local' => 'id',
             'foreign' => 'pool_id'));
    }
}