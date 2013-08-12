<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Compare validate
 * 
 * Validator to check a maximum string length with html tags allowed
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Validate_StringMaxHtml extends Zend_Validate_Abstract
{
    /**
     * constant for error message
     */
    const TOO_LONG = 'stringLengthTooLong';
    
	/**
     * @var array
     */
    protected $_messageTemplates = array(
        self::TOO_LONG => "The text is too long, please shorten!"
    );

    /**
     * Validate string length after stripping tags
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        // prepare value
        $value = strip_tags($value);
        
        if (strlen($value) <= 300) 
        {
            return true;
        }

        // values not equal, set error
        $this->_error(self::TOO_LONG);
        return false;
    }
}
