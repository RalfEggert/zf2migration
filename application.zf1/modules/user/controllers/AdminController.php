<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User Admin Controller
 * 
 * Handles the admin pages in the User module
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_AdminController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return User_Service_User::getInstance();
    }
    
    /**
     * Manage users
     */
    public function indexAction()
    {
        // get page number
        $page = $this->getRequest()->getParam('page');
        
        // get user service
        $userService  = $this->_serviceObject;
        $userList     = $userService->fetchListAll($page);
        $pageHandling = $userService->pageListAll($page);
        
        if (empty($userList) && $page > 0)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
        
        // pass user list and page handling to view
        $this->view->userList     = $userList;
        $this->view->pageHandling = $pageHandling;
    }

    public function createAction()
    {
        // create user
        $id = $this->_serviceObject->create($this->getRequest()->getPost());
    
        // check user creation
        if ($id) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'update', 'id' => $id), 'default', true));
        }
        
        // get create form and set action
        $createForm = $this->_serviceObject->getForm('create');
        $createForm->setAction($this->getHelper('url')->url());
        
        // pass create form to view
        $this->view->createForm = $createForm;
    }

    public function updateAction()
    {
        // get id
        $id = $this->getRequest()->getParam('id');
    
        // get user model
        $user = $this->_serviceObject->fetchSingleById($id);
        
        // check for user
        if (!$user)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
    
        // redirect if user update was successfully
        if ($this->_serviceObject->update($user->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'update', 'id' => $id), 'default', true));
        }
    
        // get update form and set action
        $updateForm = $this->_serviceObject->getForm('update');
        $updateForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass update form to view
        $this->view->updateForm = $updateForm;
        $this->view->user    = $user;
    }

    public function deleteAction()
    {
        // get id
        $id = $this->getRequest()->getParam('id');
    
        // get user model
        $user = $this->_serviceObject->fetchSingleById($id);
        
        // check for user
        if (!$user)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
    
        // redirect if user delete was successfully
        if ($this->_serviceObject->delete($user->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'user', 'controller' => 'admin', 'action' => 'delete', 'id' => $id), 'default', true));
        }
    
        // get delete form and set action
        $deleteForm = $this->_serviceObject->getForm('delete');
        $deleteForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass delete form to view
        $this->view->deleteForm = $deleteForm;
        $this->view->user    = $user;
    }
}

