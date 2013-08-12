<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User Index Controller
 * 
 * Handles the main pages in the User module
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_IndexController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return User_Service_User::getInstance();
    }
    
    /**
     * User overview
     */
    public function indexAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // redirect if user is not logged on
        if ($userService->isLoggedOn()) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'profile')));
        }
        
        // pass user list to view
        $this->view->user = $userService->getCurrentUser();
    }
    
    /**
     * User profile
     */
    public function profileAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // redirect if user is not logged on
        if (!$userService->isLoggedOn()) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'index')));
        }
        
        // pass user list to view
        $this->view->user = $userService->getCurrentUser();
    }
    
    /**
     * Login user
     */
    public function loginAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // redirect if user is already logged on
        if ($userService->isLoggedOn()) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'logout')));
        }
        
        // try to login 
        $userService->login($this->getRequest()->getPost());
        
        // redirect
        return $this->_redirect($this->getHelper('url')->url(array('action' => 'profile')));
    }
    
    /**
     * Logout user
     */
    public function logoutAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // redirect if user is not logged on
        if (!$userService->isLoggedOn()) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'index')));
        }
        
        // redirect if user logout was successfully
        if ($userService->logout()) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'index')));
        }
    }
    
    /**
     * Create user
     */
    public function createAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // redirect if user registration was successfully
        if ($userService->create($this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'index')));
        }
        
        // get create form
        $createForm = $userService->getForm('create');
        
        // change action
        $createForm->setAction($this->getHelper('url')->url(array('action' => 'create')));
        
        // pass create form to view
        $this->view->createForm = $createForm;
    }
    
    /**
     * Update user
     */
    public function updateAction()
    {
        // get user service
        $userService = $this->_serviceObject;
        
        // get user model
        $user = $userService->getCurrentUser();
        
        // redirect if user update was successfully
        if ($userService->update($user->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('action' => 'update')));
        }
        
        // get update form
        $updateForm = $userService->getForm('update');
        
        // change action
        $updateForm->setAction($this->getHelper('url')->url(array('action' => 'update')));
        
        // pass update form to view
        $this->view->updateForm = $updateForm;
    }
    
    /**
     * Forbidden
     */
    public function forbiddenAction()
    {
    }
}

