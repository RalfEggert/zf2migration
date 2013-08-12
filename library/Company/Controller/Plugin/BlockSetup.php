<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Block Setup plugin
 * 
 * Sets up the block build to let menu, sidebar and footer action be processed for each request
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Controller_Plugin_BlockSetup extends Zend_Controller_Plugin_Abstract
{
    /**
     * Set up the block build to let header, footer and sidebar actions be processed for each request
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        // build menu
        $this->_buildHeader($request);
        
        // build sidebar
        $this->_buildSidebar($request);
        
        // build footer
        $this->_buildFooter($request);
    }
    
	/**
	 * Builds the header
	 * 
	 * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    private function _buildHeader($request)
    {
        // get view renderer and initialize
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        
        // set view object
        $view = $viewRenderer->view; /* @var $view Zend_View */
        
        // render script
        $output = $view->render('block/header.phtml');
        
        // pass to layout segment
        Zend_Layout::getMvcInstance()->header = $output;
    }
    
    /**
     * Builds the sidebar
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    private function _buildSidebar($request)
    {
        // get view renderer and initialize
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        
        // set view object
        $view = $viewRenderer->view; /* @var $view Zend_View */
        
        // render script
        $output = $view->render('block/sidebar.phtml');
        
        // pass to layout segment
        Zend_Layout::getMvcInstance()->sidebar = Zend_Layout::getMvcInstance()->sidebar . $output;
    }
    
    /**
     * Builds the footer
     * 
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    private function _buildFooter($request)
    {
        // get view renderer and initialize
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        
        // set view object
        $view = $viewRenderer->view; /* @var $view Zend_View */
        
        // render script
        $output = $view->render('block/footer.phtml');
        
        // pass to layout segment
        Zend_Layout::getMvcInstance()->footer = $output;
    }
}
