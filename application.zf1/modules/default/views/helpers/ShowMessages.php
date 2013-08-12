<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * ShowMessages View Helper
 *
 * Outputs the page navigation
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Application_View_Helper_ShowMessages extends Zend_View_Helper_Abstract
{
    /**
     * Handle the messages output
     */
    function showMessages($messages)
    {
        $output = '';
        
        if (empty($messages))
        {
            return $output;
        }
        
        foreach ($messages as $message)
        {
            $output .= $this->view->translate($message);
        }
        
        return $output;
    }
}