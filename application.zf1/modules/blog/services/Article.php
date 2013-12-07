<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog article service
 * 
 * Handles the blog article service
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Service_Article
{
    /**
     * Singleton instance for service objects
     *
     * @var Blog_Service_Article
     */
    protected static $_instance = null;
    
    /**
     * Get singleton instance of Blog_Service_Article
     *
     * @return Blog_Service_Article
     */
    public static function getInstance()
    {
        // check for current object for requested class object
        if (!isset(self::$_instance) || null === self::$_instance)
        {
            // set singleton instance
            self::$_instance = new Blog_Service_Article;
        }
        
        // return service instance
        return self::$_instance;
    }
    
    /**
     * Protected instance of mappers
     * 
     * @var Blog_Model_Mappers_Article
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
    protected $_items = 3;
    
    /**
     * Get article mapper
     * 
     * @return Blog_Model_Mappers_Article
     */
    public function getArticleMapper()
    {
        if (is_null($this->_mapper)) {
            $this->_mapper = new Blog_Model_Mappers_Article();
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
                    $class = 'Blog_Form_ArticleCreate';
                    break;
                case 'update':
                    $class = 'Blog_Form_ArticleUpdate';
                    break;
                case 'delete':
                    $class = 'Blog_Form_ArticleDelete';
                    break;
                default:
                    throw new Company_Exception('unknown form');
            }
            
            $this->_forms[$type] = new $class();
            
            if ($this->_forms[$type]->getElement('article_category'))
            {
                $this->_forms[$type]->getElement('article_category')->setMultiOptions(Blog_Service_Category::getInstance()->fetchOptions());
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
     * Fetch single article by id
     * 
     * @param interger $id article id
     * @return Blog_Model_Article
     */
    public function fetchSingleById($id)
    {
        return $this->getArticleMapper()->fetchSingle($id);
    }
    
    /**
     * Fetch single article by url
     * 
     * @param interger $url article url
     * @return Blog_Model_Article
     */
    public function fetchSingleByUrl($url)
    {
        $article = $this->getArticleMapper()->fetchSingleByUrl($url);
        
        return $article;
    }
    
    /**
     * Fetch articles by category
     * 
     * @param integer $category category id
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function fetchListByCategory($category, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByCategory($category);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($articleList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling by category
     * 
     * @param integer $category category id
     * @param integer $page current page 
     * @return array list of Blog_Model_Article
     */
    public function pageListByCategory($category, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByCategory($category);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($articleList), 'current' => $page, 'step' => $this->_items);
    }
    
    /**
     * Fetch articles by user
     * 
     * @param integer $user user id
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function fetchListByUser($user, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByUser($user);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($articleList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling by user
     * 
     * @param integer $user user id
     * @param integer $page current page 
     * @return array list of Blog_Model_Article
     */
    public function pageListByUser($user, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByUser($user);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($articleList), 'current' => $page, 'step' => $this->_items);
    }
    
    /**
     * Fetch articles by status
     * 
     * @param integer $status status id
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function fetchListByStatus($status, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByStatus($status);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($articleList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling by status
     * 
     * @param integer $status status id
     * @param integer $page current page 
     * @return array list of Blog_Model_Article
     */
    public function pageListByStatus($status, $page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchListByStatus($status);
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($articleList), 'current' => $page, 'step' => $this->_items);
    }
    
    /**
     * Fetch all articles
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function fetchListAll($page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchList();
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($articleList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling all articles
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function pageListAll($page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchList();
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($articleList), 'current' => $page, 'step' => $items);
    }
    
    /**
     * Fetch approved articles
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function fetchListApproved($page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchList('approved');
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($articleList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling approved articles
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of Blog_Model_Article
     */
    public function pageListApproved($page = 1, $items = null)
    {
        $articleList = $this->getArticleMapper()->fetchList('approved');
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($articleList), 'current' => $page, 'step' => $items);
    }
    
    /**
     * Create an article
     *
     * @param array $data input data
     * @return integer
     */
    public function create(array $data)
    {
        // check for no data
        if (empty($data) || is_null($data['submit_article_create'])) {
            return false;
        }
    
        // check for valid data
        if (!$this->getForm('create')->isValid($data)) {
            $this->addMessage('message_default_check_input');
            
            return false;
        }
    
        // get data and add user
        $cleanData = $this->getForm('create')->getValues();
//        $cleanData['article_user'] = Zend_Auth::getInstance()->getIdentity()->getId();
        $cleanData['article_user'] = 1;

    
        // try to create dataset
        try {
            $id = $this->getArticleMapper()->create($cleanData);
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_article_notsaved');
            
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_article_created');
    
        return $id;
    }
    
    /**
     * Update a article
     *
     * @param integer $id article id
     * @param array $data input data
     * @return boolean
     */
    public function update($id, array $data)
    {
        // fetch old data by article id
        $oldData = $this->fetchSingleById($id);
    
        // check unknown article
        if ($oldData->getId() == null) {
            $this->addMessage('message_blog_article_unknown');
    
            return false;
        }
    
        // check for no data
        if (empty($data) || is_null($data['submit_article_update'])) {
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
            $this->getArticleMapper()->update($id, $this->getForm('update')->getValues());
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_article_notsaved');
    
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_article_updated');
    
        return true;
    }
    
    /**
     * Delete a article
     *
     * @param integer $id article id
     * @param array $data input data
     * @return boolean
     */
    public function delete($id, array $data)
    {
        // fetch old data by article id
        $oldData = $this->fetchSingleById($id);
    
        // check unknown article
        if ($oldData->getId() == null) {
            $this->addMessage('message_blog_article_unknown');
    
            return false;
        }
    
        // check for no data
        if (empty($data) || is_null($data['submit_article_delete'])) {
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
            $this->getArticleMapper()->delete($id);
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_blog_article_notdeleted');
    
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_blog_article_deleted');
    
        return true;
    }
    
    
}
