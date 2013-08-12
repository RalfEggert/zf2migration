<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Category Controller for Blog module
 *
 * Handles the category pages in the blog module
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_CategoryController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return Blog_Service_Category::getInstance();
    }
    
    public function indexAction()
    {
        $categoryService = $this->_serviceObject;
        $categoryList    = $categoryService->fetchListAll();
        
        $this->view->categoryList  = $categoryList;
    }

    public function createAction()
    {
        // create category
        $id = $this->_serviceObject->create($this->getRequest()->getPost());
    
        // check category creation
        if ($id) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'category', 'action' => 'update', 'id' => $id), 'default', true));
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
    
        // get category model
        $category = $this->_serviceObject->fetchSingleById($id);
        
        // check for category
        if (!$category)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'category', 'action' => 'index'), 'default', true));
        }
    
        // redirect if category update was successfully
        if ($this->_serviceObject->update($category->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'category', 'action' => 'update', 'id' => $id), 'default', true));
        }
    
        // get update form and set action
        $updateForm = $this->_serviceObject->getForm('update');
        $updateForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass update form to view
        $this->view->updateForm = $updateForm;
        $this->view->category   = $category;
    }

    public function deleteAction()
    {
        // get id
        $id = $this->getRequest()->getParam('id');
    
        // get category model
        $category = $this->_serviceObject->fetchSingleById($id);
        
        // check for category
        if (!$category)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'category', 'action' => 'index'), 'default', true));
        }
    
        // redirect if category delete was successfully
        if ($this->_serviceObject->delete($category->getId(), $this->getRequest()->getPost())) {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'category', 'action' => 'delete', 'id' => $id), 'default', true));
        }
    
        // get delete form and set action
        $deleteForm = $this->_serviceObject->getForm('delete');
        $deleteForm->setAction($this->getHelper('url')->url(array('id' => $id)));
        
        // pass delete form to view
        $this->view->deleteForm = $deleteForm;
        $this->view->category   = $category;
    }
}







