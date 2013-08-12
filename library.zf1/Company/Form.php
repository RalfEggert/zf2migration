<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Form
 * 
 * Extends the standard form
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Form extends Zend_Form
{
    /**
     * Form name
     */
    public $formName = null;
    
    /**
     * Form action
     */
    public $formAction = null;
    
    /**
     * Form decorators
     */
    protected $_formDecorators = array(
        'FormElements',
        array('Form', array('class' => 'form-horizontal')),
    );
    
    /**
     * Element decorators
     */
    protected $_elementDecorators = array(
        'ViewHelper',
        array('Description', array('tag' => 'p', 'class' => 'description')),
        'Errors',
        array(array('controls' => 'HtmlTag'), array('tag' => 'div', 'class' => 'controls')),
        array('Label', array('class' => 'control-label')),
        array(array('control-group' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group')),
    );
    
    /**
     * Captcha decorators
     */
    protected $_captchaDecorators = array(
        'Captcha',
        array('Description', array('tag' => 'p', 'class' => 'description')),
        'Errors',
        array(array('controls' => 'HtmlTag'), array('tag' => 'div', 'class' => 'controls')),
        array('Label', array('class' => 'control-label')),
        array(array('control-group' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group')),
    );
    
    /**
     * hidden decorators
     */
    public $_hiddenDecorators = array(
        array('ViewHelper'),
    );
    
    /**
     * Submit decorators
     */
    protected $_submitDecorators = array(
        'ViewHelper',
        array(array('form-actions' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-actions')),
    );
    
    /**
     * Define element prefix paths
     *
     * @var array
     */
    public $_elementPrefixPaths = array(
        1 => array(
            'prefix' => 'Company_Validate',
            'path'   => 'Company/Validate/',
            'type'   => 'validate',
        ),
        2 => array(
            'prefix' => 'Company_Filter',
            'path'   => 'Company/Filter/',
            'type'   => 'filter',
        ),
    );

    /**
     * Initialize form elements
     */
    public function init()
    {
        // decorators
        $this->setDisableLoadDefaultDecorators(false);
        $this->setDecorators($this->_formDecorators);
        $this->setElementDecorators($this->_elementDecorators);

        // add element prefix paths
        $this->addElementPrefixPaths($this->_elementPrefixPaths);
        
        // settings
        $this->setMethod('post');
        $this->setName($this->formName);
        $this->setAction($this->formAction);
        
        // init elements
        $this->initElements();
    }
    
    /**
     * Initialize form elements (used by extending classes)
     *
     * @return void
     */
    public function initElements()
    {
    }
}