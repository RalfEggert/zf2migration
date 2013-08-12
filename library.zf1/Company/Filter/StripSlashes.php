<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Filter stripslashes class
 * 
 * Filters input by stripping slashes
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Filter_StripSlashes implements Zend_Filter_Interface
{
    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns the string $value with slashes stripped off
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        if (!Zend_Controller_Front::getInstance()->getRequest()->isPost())
        {
            return $value;
        }
        
        preg_match_all('=\\\\[A-Z]{1}=', $value, $matches);
        
        foreach ($matches[0] as $key => $match)
        {
            $value = str_replace($match, '#######' . $key . '#######', $value);
        }
        
        $value = stripslashes((string) $value);
        
        foreach ($matches[0] as $key => $match)
        {
            $value = str_replace('#######' . $key . '#######', $match, $value);
        }
        
        return $value;
    }
    
}
