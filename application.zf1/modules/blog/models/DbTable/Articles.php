<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog article database table
 * 
 * Handles the blog article database table
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Model_DbTable_Articles extends Zend_Db_Table_Abstract
{
    /**
     * Name of database table
     * 
     * @var string database table
     */
    protected $_name = 'blog_articles';
    
    /**
     * Name of primary key
     * 
     * @var integer primary key
     */
    protected $_primary = 'article_id';
    
    /**
     * Reference map
     *
     * @var array
     */
    protected $_referenceMap = array(
        'Blog_Model_DbTable_Categories' => array(
            'columns'       => array('article_category'),
            'refTableClass' => 'Blog_Model_DbTable_Categories',
            'refColumns'    => array('category_id')
        ),
        'User_Model_DbTable_Users' => array(
            'columns'       => array('article_user'),
            'refTableClass' => 'User_Model_DbTable_Users',
            'refColumns'    => array('user_id')
        ),
    );
}

