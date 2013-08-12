<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Time view helper
 * 
 * Handles the view output for times
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_View_Helper_Time extends Zend_View_Helper_Abstract
{
	/**
     * Generates a time
     *
     * @access public
     * @return string html output for time
     */
    public function time($input = '')
    {
        // check for null value
        if (is_null($input) || '0000-00-00 00:00:00' == $input) {
            return '-';
        }
        
        // initialize time object
        try {
            $time = new Zend_Date($input, null, 'de');
        } catch (Zend_Date_Exception $e) {
            return '-';
        }
        
        // get time
        $output = $time->get(Zend_Date::TIME_SHORT);
        
        // return time
        return $output;
    }
}
