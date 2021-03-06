<?php

/**
 * BasePool
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property integer $currentRound
 * @property integer $pool_ruleset_id
 * @property integer $stage_id
 * @property integer $spots
 * @property integer $rank
 * @property PoolRuleset $PoolRuleset
 * @property Stage $Stage
 * @property Doctrine_Collection $SourceMoves
 * @property Doctrine_Collection $DestinationMoves
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
        $this->hasColumn('currentRound', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('pool_ruleset_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('stage_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('spots', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PoolRuleset', array(
             'local' => 'pool_ruleset_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Stage', array(
             'local' => 'stage_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('PoolMove as SourceMoves', array(
             'local' => 'id',
             'foreign' => 'pool_id'));

        $this->hasMany('PoolMove as DestinationMoves', array(
             'local' => 'id',
             'foreign' => 'source_pool_id'));

        $this->hasMany('PoolTeam as PoolTeams', array(
             'local' => 'id',
             'foreign' => 'pool_id'));

        $this->hasMany('Round as Rounds', array(
             'local' => 'id',
             'foreign' => 'pool_id'));
    }
}