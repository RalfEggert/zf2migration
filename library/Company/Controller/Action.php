<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Action controller
 * 
 * Extend the action controller
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
abstract class Company_Controller_Action extends Zend_Controller_Action
{
    protected $_serviceObject = null;
    
    abstract public function initServiceObject();
    
    public function init()
    {
        // get flash messenger
        $messenger = $this->_helper->getHelper('FlashMessenger');
    
        // add message if any
        if ($messenger->hasMessages())
        {
            $this->view->messages = $messenger->getMessages();
        }
        
        // init service object
        $this->_serviceObject = $this->initServiceObject();
    }
    
    public function postDispatch()
    {
        $messages = $this->_serviceObject->getMessages();
    
        if (!empty($messages))
        {
            $this->view->messages = $messages;
        }
    }
}
