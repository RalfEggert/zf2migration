<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User create form
 * 
 * Handles the user create form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Form_UserCreate extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'user_create';
    
    /**
     * form action
     */
    public $formAction = '/user/index/create';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Text', 'user_name', array(
            'required'       => true,
            'label'          => 'label_user_user_name',
            'description'    => 'text_user_user_name',
            'size'           => '64',
            'class'          => 'span6',
            'filters'        => array(
                'StringTrim', 'StripSlashes', 'HtmlPurifier',
            ),
        ));
        
        $this->addElement('Text', 'user_email', array(
            'required'       => true,
            'label'          => 'label_user_user_email',
            'description'    => 'text_user_user_email',
            'size'           => '64',
            'class'          => 'span6',
            'filters'        => array(
                'StringTrim', 'StripSlashes', 'HtmlPurifier',
            ),
            'validators'     => array(
                array(
                    'validator' => 'EmailAddress',
                    'break'     => false,
                    'options'   => array(),
                ),
            ),
        ));
        
        $this->addElement('Password', 'user_password', array(
            'required'      => true,
            'label'         => 'label_user_user_password',
            'description'   => 'text_user_user_password',
            'size'          => '64',
            'class'         => 'span6',
            'validators'    => array(
                array(
                    'validator' => 'StringLength',
                    'break'     => false,
                    'options'   => array(6, 64),
                ),
                array(
                    'validator' => 'Compare',
                    'break'     => false,
                    'options'   => array('user_password2'),
                ),
            ),
        ));
        
        $this->addElement('Password', 'user_password2', array(
            'required'      => true,
            'label'         => 'label_user_user_password2',
            'description'    => 'text_user_user_password2',
            'size'          => '64',
            'class'         => 'span6',
            'validators'    => array(
                array(
                    'validator' => 'StringLength',
                    'break'     => false,
                    'options'   => array(6, 64),
                ),
            ),
        ));
        
        $this->addElement('Text', 'user_website', array(
            'required'      => false,
            'label'         => 'label_user_user_website',
            'description'   => 'text_user_user_website',
            'size'          => '255',
            'class'         => 'span6',
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array(
                    'validator' => 'LinkUrl',
                ),
            ),
        ));
        
        $this->addElement('Captcha', 'user_captcha', array(
            'required'      => true,
            'label'         => 'label_user_user_captcha',
            'description'   => 'text_user_user_captcha',
            'class'         => 'span6',
            'captcha'       => new Zend_Captcha_Figlet(array('wordLen' => 4)),
            'decorators'    => $this->_captchaDecorators,
        ));
        
        $this->addElement('Submit', 'submit_user_create', array(
            'label'         => 'submit_user_user_create',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
        $this->getElement('user_name')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_email')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_password')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_password2')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_website')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_captcha')->getDecorator('Description')->setOption('placement', 'prepend');
        
    }
}

