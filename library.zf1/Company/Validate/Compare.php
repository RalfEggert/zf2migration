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
 * Validator to compare two values
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Validate_Compare extends Zend_Validate_Abstract
{
    /**
     * constant for error message
     */
    const NOT_MATCH = 'notMatch';
    
	/**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_MATCH => "The values do not match"
    );

    /**
     * compare field
     *
     * @var string
     */
    protected $_compare;

    /**
     * Sets validator options
     *
     * @param  string $compare
     * @return void
     */
    public function __construct($compare = 'compare')
    {
        $this->setCompareField($compare);
    }

    /**
     * Returns the compare field
     *
     * @return string
     */
    public function getCompareField()
    {
        return $this->_compare;
    }

    /**
     * Sets the compare field
     *
     * @param  string $compare
     * @return Interpersonal_Validate_Compare Provides a fluent interface
     */
    public function setCompareField($compare)
    {
        $this->_compare = $compare;
        return $this;
    }

    /**
     * Validate and compare given value with the value of the compare field
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        // prepare and set value
        $value = (string) $value;
        $this->_setValue($value);
        
        // check context type
        if (is_array($context))
        {
            if (isset($context[$this->getCompareField()])
                && ($value == $context[$this->getCompareField()]))
            {
                return true;
            }
        } 
        elseif (is_string($context) && ($value == $context)) 
        {
            return true;
        }

        // values not equal, set error
        $this->_error(self::NOT_MATCH);
        return false;
    }
}
