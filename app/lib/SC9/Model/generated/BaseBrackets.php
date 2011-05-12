<?php

/**
 * BaseBrackets
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $nrteams
 * @property integer $nrrounds
 * @property integer $round
 * @property integer $matchnr
 * @property integer $home
 * @property integer $away
 * @property integer $winplace
 * @property integer $loseplace
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBrackets extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('brackets');
        $this->hasColumn('nrteams', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('nrrounds', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('round', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('matchnr', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('home', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('away', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('winplace', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('loseplace', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}