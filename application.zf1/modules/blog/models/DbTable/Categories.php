<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog category database table
 * 
 * Handles the category database table
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{
    /**
     * Name of database table
     * 
     * @var string database table
     */
    protected $_name = 'blog_categories';
    
    /**
     * Name of primary key
     * 
     * @var integer primary key
     */
    protected $_primary = 'category_id';

    /**
     * Define dependentables
     *
     * @var array
     */
    protected $_dependentTables = array('Blog_Model_DbTable_Articles');
}

