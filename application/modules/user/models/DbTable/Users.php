<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User user database table
 * 
 * Handles the user user database table
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    /**
     * Name of database table
     * 
     * @var string database table
     */
    protected $_name = 'user_registrations';
    
    /**
     * Name of primary key
     * 
     * @var integer primary key
     */
    protected $_primary = 'user_id';

    /**
     * Define dependentables
     *
     * @var array
     */
    protected $_dependentTables = array('Blog_Model_DbTable_Articles');
}

