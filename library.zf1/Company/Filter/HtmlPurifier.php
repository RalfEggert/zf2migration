<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Filter a string with HtmlPurifier
 * 
 * Takes a string and filters it with HtmlPurifier
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Filter_HtmlPurifier implements Zend_Filter_Interface
{
    /**
     * The HTMLPurifier instance
     *
     * @var HTMLPurifier
     */
    protected $_instance;
 
    /**
     * Constructor
     *
     * @param mixed $config
     * @return void
     */
    public function __construct()
    {
    	if (!class_exists('HTMLPurifier_Bootstrap', false)) {
            require_once PROJECT_PATH . '/library.zf1/HTMLPurifier/HTMLPurifier/Bootstrap.php';
            spl_autoload_register(array('HTMLPurifier_Bootstrap', 'autoload'));
    	}
    	$config = HTMLPurifier_Config::createDefault();
    	$config->set('HTML.Doctype', 'HTML 4.01 Strict');
    	$config->set('Cache.SerializerPath', PROJECT_PATH . '/data/cache/htmlpurifier');
    	$def = $config->getHTMLDefinition(true);
    	$def->addAttribute('a', 'target', 'Enum#_blank,_self,_target,_top');
    	$this->_instance = new HTMLPurifier($config);
    }
 
    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns the string $value, purified by HTMLPurifier
     *
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $value = $this->_instance->purify($value);
        
        return $value;
    }
}
