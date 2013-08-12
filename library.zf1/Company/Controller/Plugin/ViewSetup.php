<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * View Setup plugin
 * 
 * Sets up the block build to let menu, sitebar and footer action be processed for each request
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Controller_Plugin_ViewSetup extends Zend_Controller_Plugin_Abstract
{
    /**
     * Initializes the view renderer and sets it up
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // set view object
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view; /* @var $view Zend_View */
        
        // set up common variables for the view
        $view->module = $request->getModuleName();
        $view->controller = $request->getControllerName();
        $view->action = $request->getActionName();
        
        // get text token
        $token = $request->getModuleName() . '_' . $request->getControllerName() . '_' . $request->getActionName();
        
        // get title
        if (!Zend_Registry::get('Zend_Translate')->isTranslated('title_' . $token))
        {
            $token = 'default_error_error';
        }
        
        // setup title
        $view->headTitle(Zend_Registry::get('Zend_Translate')->translate('title_' . $token));
        $view->headTitle(' - ' . Zend_Registry::get('Zend_Translate')->translate('title_default_index_index'), Zend_View_Helper_Placeholder_Container_Abstract::APPEND);
        
        // setup meta data
        $view->doctype(Zend_View_Helper_Doctype::XHTML5);
        $view->headMeta()->setName('description', Zend_Registry::get('Zend_Translate')->translate('description_' . $token));
        $view->headMeta()->setCharset('utf-8');
        $view->headMeta()->setName('viewport', 'width=device-width, initial-scale=1.0');
        
        // setup styles
        $view->headLink()->appendStylesheet('/css/bootstrap.min.css', 'screen');
        $view->headLink()->appendStylesheet('/css/styles.css', 'screen, print');
        $view->headScript()->appendFile('/js/html5shiv.js', 'text/javascript', array('conditional' => 'lt IE 9'));
    }
    
}
