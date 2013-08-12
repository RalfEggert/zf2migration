<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User authentication plugin
 * 
 * Checks the user authentication
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Plugin_Authentication extends Zend_Controller_Plugin_Abstract
{
    /**
     * Check authentication
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl  = Zend_Registry::get('acl');
        $auth = Zend_Auth::getInstance();
 
        $resource  = $request->getModuleName() . '_' . $request->getControllerName();
        $privilege = $request->getActionName();
 
        // Get User Role
        $role = $auth->hasIdentity() ? $auth->getIdentity()->getGroup() : 'guest';
 
        // Check User Rights
        if (!$acl->isAllowed($role, $resource, $privilege)) {
            $request->setModuleName('user');
            $request->setControllerName('index');
            $request->setActionName('forbidden');
        }
    }
}
