<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User user service
 * 
 * Handles the user user service
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Service_User
{
    /**
     * Singleton instance for service objects
     *
     * @var User_Service_User
     */
    protected static $_instance = null;
    
    /**
     * Get singleton instance of User_Service_User
     *
     * @return User_Service_User
     */
    public static function getInstance()
    {
        // check for current object for requested class object
        if (!isset(self::$_instance) || null === self::$_instance)
        {
            // set singleton instance
            self::$_instance = new User_Service_User;
        }
    
        // return service instance
        return self::$_instance;
    }
    
    /**
     * Protected list of mappers
     */
    protected $_mapper = array();
    
    /**
     * Protected list of forms
     */
    protected $_forms   = array();
    
    /**
     * Protected message
     */
    protected $_messages = array();
    
    /**
     * Items per page
     * 
     * @var integer
     */
    protected $_items = 10;
    
    /**
     * Get user mapper
     * 
     * @param string $type
     * @return User_Model_Mappers_User
     */
    public function getUserMapper()
    {
        $class = 'User_Model_Mappers_User';
        
        if (!isset($this->_mappers[$class])) {
            $this->_mappers['user'] = new $class();
        }
        
        return $this->_mappers['user'];
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
                    $class = 'User_Form_UserCreate';
                    break;
                case 'update':
                    $class = 'User_Form_UserUpdate';
                    break;
                case 'delete':
                    $class = 'User_Form_UserDelete';
                    break;
                case 'login':
                    $class = 'User_Form_UserLogin';
                    break;
                default:
                    throw new Company_Exception('unknown form');
            }
            
            $this->_forms[$type] = new $class();
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
     * Fetch single user by id
     * 
     * @param integer $id user id
     * @return User_Model_User
     */
    public function fetchSingleById($id)
    {
        return $this->getUserMapper()->fetchSingle($id);
    }
    
    /**
     * Fetch single user by url
     * 
     * @param integer $url user url
     * @return User_Model_User
     */
    public function fetchSingleByUrl($url)
    {
        return $this->getUserMapper()->fetchSingleByUrl($url);
    }
    
    /**
     * Fetch users by group
     * 
     * @param integer $group group id
     * @return array list of User_Model_User
     */
    public function fetchListByGroup($group)
    {
        return $this->getUserMapper()->fetchListByGroup($group);
    }
    
    /**
     * Fetch all users
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of User_Model_User
     */
    public function fetchListAll($page = 1, $items = null)
    {
        $userList = $this->getUserMapper()->fetchList();
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array_slice($userList, ($page - 1) * $items, $items);
    }
    
    /**
     * Page handling all users
     * 
     * @param integer $page current page 
     * @param integer $items item number 
     * @return array list of User_Model_User
     */
    public function pageListAll($page = 1, $items = null)
    {
        $userList = $this->getUserMapper()->fetchList();
        
        if (is_null($page))
        {
            $page = 1;
        }
        
        if (is_null($items))
        {
            $items = $this->_items;
        }
        
        return array('max' => count($userList), 'current' => $page, 'step' => $this->_items);
    }
    
    /**
     * Fetch author options
     * 
     * @return array option list 
     */
    public function fetchAuthorOptions()
    {
        $options = array();
        
        foreach ($this->getUserMapper()->fetchListByGroup('admin') as $user)
        {
            $options[$user->getId()] = $user->getName() . ' <' . $user->getEmail() . '>';
        }
        
        foreach ($this->getUserMapper()->fetchListByGroup('editor') as $user)
        {
            $options[$user->getId()] = $user->getName() . ' <' . $user->getEmail() . '>';
        }
        
        return $options;
    }
    
    /**
     * Check for logged on user
     * 
     * @return boolean
     */
    public function isLoggedOn()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }
    
    /**
     * Get current user
     * 
     * @return User_Model_User
     */
    public function getCurrentUser()
    {
        if (Zend_Auth::getInstance()->getIdentity())
        {
            return Zend_Auth::getInstance()->getIdentity();
        }
        
        $model = new User_Model_User();
        $model->setGroup('guest');
        
        return $model;
    }
    
    /**
     * Login a user
     * 
     * @return boolean
     */
    public function login(array $data)
    {
        // check for no data
        if (empty($data) || is_null($data['submit_user_login'])) {
            return false;
        }
        
        // check for valid data
        if (!$this->getForm('login')->isValid($data)) {
            $this->addMessage('message_default_check_input');
            
            return false;
        }
        
        // get clean data from form
        $cleanData = $this->getForm('login')->getValues();
    
        // prepare authentication
        $authAdapter = new Zend_Auth_Adapter_DbTable(
            $this->getUserMapper()->getTable()->getAdapter(), 'user_registrations', 'user_name', 'user_password', 'MD5(?)'
        );
        $authAdapter->setIdentity($cleanData['user_name']);
        $authAdapter->setCredential($cleanData['user_password']);
        
        // authenticate
        $result = Zend_Auth::getInstance()->authenticate($authAdapter);
        
        // check failed authentication
        if (!$result->isValid()) {
            // check code
            switch ($result->getCode())
            {
                case -1:
                    $description = 'message_user_authentication_notfound';
                    break;
            
                case -2:
                    $description = 'message_user_authentication_nodata';
                    break;
            
                case -3:
                    $description = 'message_user_authentication_wrongpassword';
                    break;
            
                default:
                    $description = 'message_user_authentication_unknown';
                    break;
            }
            
            // set message
            $this->addMessage($description);
            
            return false;
        }
        
        // get object
        $userRow = $authAdapter->getResultRowObject();
        
        // check for status
        if ($userRow->user_status == 'blocked')
        {
            // set message
            $this->addMessage('message_user_authentication_blocked');
            
            // clear identity
            Zend_Auth::getInstance()->clearIdentity();
            
            return false;
        }
        
        // load user
        $user = $this->getUserMapper()->getModel($userRow);
        
        // pass user model to identity
        Zend_Auth::getInstance()->getStorage()->write($user);
        
        return true;
    }
    
    /**
     * Logout a user
     * 
     * @return boolean
     */
    public function logout()
    {
        // clear identity
        Zend_Auth::getInstance()->clearIdentity();
        
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_user_user_logout');
        
        return true;
    }
    
    /**
     * Register a user
     * 
     * @param array $data input data
     * @return integer
     */
    public function create(array $data)
    {
        // clear fields
        if ($this->getCurrentUser()->getGroup() == 'admin')
        {
            $this->getForm('create')->removeElement('user_captcha');
            $this->getForm('create')->setAction('/user/admin/create');
        }
        
        // check for no data
        if (empty($data) || is_null($data['submit_user_create'])) {
            return false;
        }
        
        // check for valid data
        if (!$this->getForm('create')->isValid($data)) {
            $this->addMessage('message_default_check_input');
    
            return false;
        }
    
        // try to create dataset
        try {
            $id = $this->getUserMapper()->create($this->getForm('create')->getValues());
        } catch (Zend_Db_Exception $e) {
            if ($e->getCode() == 23000) {
                $this->addMessage('message_user_user_exists');
            } else {
                $this->addMessage('message_user_user_notsaved');
            }
            
            return false;
        }
        
        // add message
        if ($this->getCurrentUser()->getGroup() == 'admin')
        {
            Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_user_user_created');
        }
        else
        {
            Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_user_user_registered');
        }
        
        return $id;
    }
    
    /**
     * Update a user
     *
     * @param integer $id user id
     * @param array $data input data
     * @return boolean
     */
    public function update($id, array $data)
    {
        // fetch old data by user id
        $oldData = $this->fetchSingleById($id);
        
        // clear fields
        if ($this->getCurrentUser()->getGroup() != 'admin')
        {
            $this->getForm('update')->removeElement('user_status');
            $this->getForm('update')->removeElement('user_group');
        }
        else
        {
            $this->getForm('update')->setAction('/user/admin/update/id/' . $id);
            
        }
        
        // check unknown user
        if ($oldData->getId() == null) {
            $this->addMessage('message_user_user_unknown');
    
            return false;
        }
        
        // check for no data
        if (empty($data) || is_null($data['submit_user_update'])) {
            $this->getForm('update')->setDefaults($oldData->toArray());
            $this->getForm('update')->getElement('user_password')->setValue('');
            
            return false;
        }
        
        // check for valid data
        if (!$this->getForm('update')->isValid($data)) {
            $this->addMessage('message_default_check_input');
    
            return false;
        }
    
        // try to update dataset
        try {
            $this->getUserMapper()->update($id, $this->getForm('update')->getValues());
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_user_user_notsaved');
    
            return false;
        }
        
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_user_user_updated');
        
        // refresh user
        $user = $this->getUserMapper()->fetchSingle($id);
        
        // refresh user if the same
        if ($id == $this->getCurrentUser()->getId())
        {
            Zend_Auth::getInstance()->getStorage()->write($user);
        }
        
        return true;
    }
    
    /**
     * Delete a user
     *
     * @param integer $id user id
     * @param array $data input data
     * @return boolean
     */
    public function delete($id, array $data)
    {
        // fetch old data by user id
        $oldData = $this->fetchSingleById($id);
    
        // clear fields
        if ($this->getCurrentUser()->getGroup() == 'admin')
        {
            $this->getForm('delete')->setAction('/user/admin/delete/id/' . $id);
        }
    
        // check unknown user
        if ($oldData->getId() == null) {
            $this->addMessage('message_user_user_unknown');
    
            return false;
        }
    
        // check for no data
        if (empty($data) || is_null($data['submit_user_delete'])) {
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
            $this->getUserMapper()->delete($id);
        } catch (Zend_Db_Exception $e) {
            $this->addMessage('message_user_user_notdeleted');
    
            return false;
        }
    
        // add message
        Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger')->addMessage('message_user_user_deleted');
        
        return true;
    }
}
