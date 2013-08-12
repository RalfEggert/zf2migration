<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Index Controller
 *
 * Handles the main pages in the default module
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class IndexController extends Company_Controller_Action
{
    public function initServiceObject()
    {
        return Blog_Service_Article::getInstance();
    }
    
    public function indexAction()
    {
        $articleList = $this->_serviceObject->fetchListApproved();
        
        $this->view->articleList = $articleList;
    }
    
    public function adminAction()
    {
        // action body
    }
}

