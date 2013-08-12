<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog category service
 * 
 * Handles the blog category service
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Service_Category
{
    /**
     * Singleton instance for service objects
     *
     * @var Blog_Service_Category
     */
    protected static $_instance = null;
    
    /**
     * Get singleton instance of Blog_Service_Category
     *
     * @return Blog_Service_Category
     */
    public static function getInstance()
    {
        // check for current object for requested class object
        if (!isset(self::$_instance) || null === self::$_instance)
        {
            // set singleton instance
            self::$_instance = new Blog_Service_Category;
        }
    
        // return service instance
        return self::$_instance;
    }
    
    /**
     * Protected list of mappers
     * 
     * @var Blog_Model_Mappers_Category
     */
    protected $_mapper = null;
    
    /**
     * Protected list of forms
     */
    protected $_forms   = array();
    
    /**
     * Protected message
     */
    protected $_messages = null;
    
    /**
     * Items per page
     * 
     * @var integer
     */
    protected $_items = 10;
    
    /**
     * Get category mapper
     * 
     * @return Blog_Model_Mappers_Category
     */
    public function getCategoryMapper()
    {
        if (is_null($this->_mapper)) {
            $this->_mapper = new Blog_Model_Mappers_Category();
        }
        
        return $this->_mapper;
    }
        
    /**
     * Get form
     * 
     * @param string $name form name
     * @return Company_Form
     */
    public function getForm($type)
    {
        if (!isset($this->_forms[$type])) {
            switch ($type) {
                case 'create':
                    $class = 'Blog_Form_CategoryCreate';
                    break;
                case 'update':
                    $class = 'Blog_Form_CategoryUpdate';
                    break;
                case 'delete':
                    $class = 'Blog_Form_CategoryDelete';
                    break;
                default:
                    throw new Company_Exception('unknown form');
            }
            
            $this->_forms[$type] = new $class();
            
            if ($this->_forms[$type]->getElement('category_category'))
            {
                $this->_forms[$type]->getElement('category_category')->setMultiOptions(Blog_Service_Category::getInstance()->fetchOptions());
            }
        }
        
        return $this->_forms[$type];
    }
    
    /**
     * Get message
     * 
     * @return string
     */
    public function getMessages()
    {
        return $this->_messages;
    }
    
    /**
     * set message
     * 
     * @param string $message message to be set
     * @return string
     */
    public function addMessage($message)
    {
        $this->_messages[] = $message;
    }
    
    /**
     * Fetch single category by id
     * 
     * @param interger $id category id
     * @return Blog_Model_Category
     */
    public function fetchSingleById($id)
    {
        return $this->getCategoryMapper()->fetchSingle($id);
    }
    
    /**
     * Fetch single category by url
     * 
     * @param interger $url category url
     * @return Blog_Model_Category
     */
    public function fetchSingleByUrl($url)
    {
        return $this->getCategoryMapper()->fetchSingleByUrl($url);
    }
    
    /**
     * Fetch categorys
     * 
     * @return array list of Blog_Model_Category
     */
    public function fetchListAll()
    {
        return $this->getCategoryMapper()->fetchList();
    }
    
    /**
     * Fetch options
     * 
     * @return array option list 
     */
    public function fetchOptions()
    {
        $options = array();
        
        foreach ($this->getCategoryMapper()->fetchList() as $category)
        {
            $options[$category->getId()] = $category->getName();
        }
        
        return $options;
    }
    
    /**
     * Create an category
     *
     * @param array $data input data
     * @return integer
     */
    public function create(array $data)
    {
        // check for no data
        if (empty($data) || is_null($data['submit_category_create'])) {
            return false;
        }
    
        // check for valid data
        if (!$this->getForm('create')->isValid($data)) {
            $this->addMessage('message_default_check_input');
            
            return false;
        }
    
        // get data and add user
        $cleanData = $this->getForm('create')->getValues();
    
        // try to create dataset
        try {
            $id = $this->getCategoryMapper()->create($cleanData);
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_category_notsaved');
            
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_category_created');
    
        return $id;
    }
    
    /**
     * Update a category
     *
     * @param integer $id category id
     * @param array $data input data
     * @return boolean
     */
    public function update($id, array $data)
    {
        // fetch old data by category id
        $oldData = $this->fetchSingleById($id);
    
        // check unknown category
        if ($oldData->getId() == null) {
            $this->addMessage('message_blog_category_unknown');
    
            return false;
        }
    
        // check for no data
        if (empty($data) || is_null($data['submit_category_update'])) {
            $this->getForm('update')->setDefaults($oldData->toArray());
    
            return false;
        }
    
        // check for valid data
        if (!$this->getForm('update')->isValid($data)) {
            $this->addMessage('message_default_check_input');
    
            return false;
        }
    
        // try to update dataset
        try {
            $this->getCategoryMapper()->update($id, $this->getForm('update')->getValues());
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_category_notsaved');
    
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_category_updated');
    
        return true;
    }
    
    /**
     * Delete a category
     *
     * @param integer $id category id
     * @param array $data input data
     * @return boolean
     */
    public function delete($id, array $data)
    {
        // fetch old data by category id
        $oldData = $this->fetchSingleById($id);
    
        // check unknown category
        if ($oldData->getId() == null) {
            $this->addMessage('message_blog_category_unknown');
    
            return false;
        }
    
        // check for no data
        if (empty($data) || is_null($data['submit_category_delete'])) {
            $this->getForm('delete')->setDefaults($oldData->toArray());
    
            return false;
        }
    
        // check for valid data
        if (!$this->getForm('delete')->isValid($data)) {
            $this->addMessage('message_default_check_input');
    
            return false;
        }
    
        // try to delete dataset
        try {
            $this->getCategoryMapper()->delete($id);
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_category_notdeleted');
    
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_category_deleted');
    
        return true;
    }
}
