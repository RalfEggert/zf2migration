<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Validate a link url
 * 
 * Validator to check if an input is an url
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Validate_LinkUrl extends Zend_Validate_Abstract
{
    /**
     * constant for error message
     */
    const NOT_URL = 'notUrl';
    
	/**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_URL => "The value is not a valid URL. Must start with http(s)://"
    );

    /**
     * Validate the input
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        // prepare and set value
        $value = (string) $value;
        $this->_setValue($value);
        
        // check with Zend_Uri_Http object for http(s) schemes
        try {
            $uriHttp = Zend_Uri_Http::fromString($value);
        } catch (Zend_Uri_Exception $e) {
            $this->_error(self::NOT_URL);
            return false;
        }
        
        // check for valid hostname
        $hostnameValidator = new Zend_Validate_Hostname(Zend_Validate_Hostname::ALLOW_DNS);
        if (!$hostnameValidator->isValid($uriHttp->getHost())) {
            $this->_error(self::NOT_URL);
            return false;
        }
        
        // valid url
        return true;
    }
}
