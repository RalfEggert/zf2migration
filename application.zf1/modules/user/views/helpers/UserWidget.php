<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Show user widget View Helper
 *
 * Outputs the user widget 
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_View_Helper_UserWidget extends Zend_View_Helper_Abstract
{
    /**
     * Handle the user widget output
     */
    function userWidget()
    {
        $identity = Zend_Auth::getInstance()->getIdentity(); /* @var $identity User_Model_User */
        $service  = User_Service_User::getInstance();
        $view     = $this->view;
        
        $output = '';
        
        if (!$identity)
        {
            $loginForm = $service->getForm('login');
            $loginForm->setAction($view->url(array('module' => 'user', 'controller' => 'index', 'action' => 'login'), 'default'));
            $loginForm->setAttrib('class', 'form-vertical');
            $loginForm->getElement('user_name')->setAttrib('class', 'span3');
            $loginForm->getElement('user_password')->setAttrib('class', 'span3');
            
            $output.= '<h3>' . $view->translate('heading_user_user_loggedin') . '</h3>';
            $output.= $loginForm->render();
        } else {
            $output.= '<h3>' . $view->translate('heading_user_user_loggedout') . '</h3>';
            $output.= '<p><i class="icon-user icon-white"></i> ' . $identity->getName() . '</p>';
            $output.= '<p><i class="icon-envelope icon-white"></i> ' . $identity->getEmail() . '</p>';
            $output.= '<p><a href="' . $view->url(array('module' => 'user', 'controller' => 'index', 'action' => 'logout'), 'default') . ' " class="btn btn-success">' . $view->translate('action_user_user_logout') . '</a></p>';
        }
        
        return $output;
    }
}