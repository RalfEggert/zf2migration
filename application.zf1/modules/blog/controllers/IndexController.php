<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Index Controller for Blog module
 *
 * Handles the main pages in the blog module
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_IndexController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return Blog_Service_Article::getInstance();
    }
    
    public function indexAction()
    {
        $page = $this->getRequest()->getParam('page');
        
        $articleService = $this->_serviceObject;
        $articleList    = $articleService->fetchListApproved($page);
        $pageHandling   = $articleService->pageListApproved($page);
        
        if (empty($articleList) && $page > 0)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'index'), 'default', true));
        }
        
        $this->view->articleList   = $articleList;
        $this->view->pageHandling  = $pageHandling;
    }

    public function showAction()
    {
        $url = $this->getRequest()->getParam('url');
        
        $articleService = $this->_serviceObject;
        $article = $articleService->fetchSingleByUrl($url);
        
        if (!$article) 
        {
            $id = $this->getRequest()->getParam('id');
            
            $article = $articleService->fetchSingleById($id); 
            
            if (!$article)
            {
                return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'index'), 'default', true));
            }
        }
        
        $this->view->article = $article;
    }

    public function categoryAction()
    {
        $page = $this->getRequest()->getParam('page');
        $url = $this->getRequest()->getParam('url');
        
        $categoryService = Blog_Service_Category::getInstance();
        $category = $categoryService->fetchSingleByUrl($url);
        
        if (!$category)
        {
            $id   = $this->getRequest()->getParam('id');;
        
            $category = $categoryService->fetchSingleById($id);
            
            if (!$category)
            {
                return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'index'), 'default', true));
            }
        }
        
        $articleService = $this->_serviceObject;
        $articleList    = $articleService->fetchListByCategory($category->getId(), $page);
        $pageHandling   = $articleService->pageListByCategory($category->getId(), $page);
        
        if (empty($articleList) && $page > 0)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'category', 'id' => $category->getId()), 'default', true));
        }
        
        $this->view->category      = $category;
        $this->view->articleList   = $articleList;
        $this->view->pageHandling  = $pageHandling;
    }

    public function userAction()
    {
        $page = $this->getRequest()->getParam('page');
        $url = $this->getRequest()->getParam('url');
        
        $userService = User_Service_User::getInstance();
        $user = $userService->fetchSingleByUrl($url);
        
        if (!$user)
        {
            $id   = $this->getRequest()->getParam('id');;
        
            $user = $userService->fetchSingleById($id);
            
            if (!$user)
            {
                return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'index'), 'default', true));
            }
        }
        
        $articleService = $this->_serviceObject;
        $articleList    = $articleService->fetchListByUser($user->getId(), $page);
        $pageHandling   = $articleService->pageListByUser($user->getId(), $page);
        
        if (empty($articleList) && $page > 0)
        {
            return $this->_redirect($this->getHelper('url')->url(array('module' => 'blog', 'controller' => 'index', 'action' => 'user', 'id' => $user->getId()), 'default', true));
        }
        
        $this->view->user          = $user;
        $this->view->articleList   = $articleList;
        $this->view->pageHandling  = $pageHandling;
    }
}
