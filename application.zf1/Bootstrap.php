<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

use ZFBootstrap\View\Helper\Navigation\Menu;

/**
 * Bootstrap
 *
 * Handles the bootstrap process
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Setup the acl resource
     *
     * @param array $options options for autoloader resources
     */
    protected function _initAcl(array $options = array())
    {
        // start resource loader
        $resourceLoader = $this->getResourceLoader();
        $resourceLoader->addResourceType('acl', 'modules/user/acls/', 'Acl');
        
        // create acl
        $acl = new Company_Acl();
        $acl->addIniFile(APPLICATION_PATH . '/modules/user/configs/roles.ini');
        
        // set acl in registry
        Zend_Registry::set('acl', $acl);
    }
    
    /**
     * Setup the cache registry
     *
     * @param array $options options for autoloader resources
     */
    protected function _initCache(array $options = array())
    {
        // make sure that Cachemanager resource is loaded
        $this->bootstrap('Cachemanager');
    
        // get cachemanager and save in registry
        $cache = $this->getResource('cachemanager');
        Zend_Registry::set('cache', $cache->getCache('database'));
    }
    
    /*
     * Setup miscellaneous stuff
    *
    * @param array $options options for autoloader resources
    */
    protected function _initMiscellaneous(array $options = array())
    {
        // make sure that View resource is loaded
        $this->bootstrap('View');
        
        // get view and add new Menu helper
        $view = $this->getResource('view');
        $view->registerHelper(new Menu(), 'menu');
        
        // add namespace for static filters
        Zend_Filter::addDefaultNamespaces('Company_Filter');
        Zend_Validate::addDefaultNamespaces('Company_Validate');
    }
}

