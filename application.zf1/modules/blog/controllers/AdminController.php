<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Admin Controller for Blog module
 *
 * Handles the admin pages in the blog module
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_AdminController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return Blog_Service_Article::getInstance();
    }
    
    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page');
        
        $articleService = $this->_serviceObject;
        $articleList    = $articleService->fetchListAll($page);
        $pageHandling   = $articleService->pageListAll($page);
        
        if (empty($articleList) && $page > 0)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
        
        $this->view->articleList   = $articleList;
        $this->view->pageHandling  = $pageHandling;
    }

    public function createAction()
    {
        // create article
        $id = $this->_serviceObject->create($this->getRequest()->getPost());
    
        // check article creation
        if ($id) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'update', 'id' => $id), 'default', true));
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
    
        // get article model
        $article = $this->_serviceObject->fetchSingleById($id);
        
        // check for article
        if (!$article)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
    
        // redirect if article update was successfully
        if ($this->_serviceObject->update($article->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'update', 'id' => $id), 'default', true));
        }
    
        // get update form and set action
        $updateForm = $this->_serviceObject->getForm('update');
        $updateForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass update form to view
        $this->view->updateForm = $updateForm;
        $this->view->article    = $article;
    }

    public function deleteAction()
    {
        // get id
        $id = $this->getRequest()->getParam('id');
    
        // get article model
        $article = $this->_serviceObject->fetchSingleById($id);
        
        // check for article
        if (!$article)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'index'), 'default', true));
        }
    
        // redirect if article delete was successfully
        if ($this->_serviceObject->delete($article->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'admin', 'action' => 'delete', 'id' => $id), 'default', true));
        }
    
        // get delete form and set action
        $deleteForm = $this->_serviceObject->getForm('delete');
        $deleteForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass delete form to view
        $this->view->deleteForm = $deleteForm;
        $this->view->article    = $article;
    }
}
