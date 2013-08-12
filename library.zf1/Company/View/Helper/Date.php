<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Date view helper
 * 
 * Handles the view output for dates
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_View_Helper_Date extends Zend_View_Helper_Abstract
{
	/**
     * Generates a date
     *
     * @access public
     * @return string html output for date
     */
    public function date($input = '')
    {
        // check for null value
        if (is_null($input) || '0000-00-00 00:00:00' == $input) {
            return '-';
        }
        
        // initialize date object
        try {
            $date = new Zend_Date($input, null, 'de');
        } catch (Zend_Date_Exception $e) {
            return '-';
        }
        
        // get date
        $output = $date->get(Zend_Date::DATE_MEDIUM);
        
        // return date
        return $output;
    }
}
