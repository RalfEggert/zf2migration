<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User bootstrap
 * 
 * Handles the bootstrapping for the User module
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Bootstrap extends Company_Application_Module_Bootstrap
{
    /**
     * Setup authentication plugin
     *
     * @param array $options options for autoloader resources
     */
    protected function _initPlugin(array $options = array())
    {
        // make sure that frontcontroller ressources has been set up
        $this->getApplication()->bootstrap('frontcontroller');
        
        // get frontcontroller
        $frontcontroller = $this->getApplication()->getResource('frontcontroller');
        
        // register plugin
        $frontcontroller->registerPlugin(new User_Plugin_Authentication());
    }
    
    /**
     * Setup the navigation resource
     *
     * @param array $options options for autoloader resources
     */
    protected function _initNavigation(array $options = array())
    {
        // make sure that view ressources has been set up
        $this->getApplication()->bootstrap('session');
        $this->getApplication()->bootstrap('view');
        $this->getApplication()->bootstrap('navigation');
        
        // get view, acl and role
        $view       = $this->getApplication()->getResource('view');
        $navigation = $this->getApplication()->getResource('navigation');
        $acl        = Zend_Registry::get('acl');
        $role       = Zend_Auth::getInstance()->hasIdentity()
                    ? Zend_Auth::getInstance()->getIdentity()->getGroup()
                    : 'guest';
        
        // set acl and role
        $view->navigation($navigation);
        $view->navigation()->setAcl($acl);
        $view->navigation()->setRole($role);
    }
}