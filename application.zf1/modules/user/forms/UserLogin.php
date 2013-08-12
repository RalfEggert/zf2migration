<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User login form
 * 
 * Handles the user login form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Form_UserLogin extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'user_login';
    
    /**
     * form action
     */
    public $formAction = '/user/index/login';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Text', 'user_name', array(
            'required'       => true,
            'label'          => 'label_user_user_name',
            'size'           => '64',
            'class'          => 'span6',
            'filters'        => array(
                'StringTrim', 'StripSlashes', 'HtmlPurifier',
            ),
        ));
        
        $this->addElement('Password', 'user_password', array(
            'required'      => false,
            'label'         => 'label_user_user_password',
            'size'          => '64',
            'class'         => 'span6',
            'validators'    => array(
                array(
                    'validator' => 'StringLength',
                    'break'     => false,
                    'options'   => array(6, 32),
                ),
            ),
        ));
        
        $this->addElement('Submit', 'submit_user_login', array(
            'label'         => 'submit_user_user_login',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
    }
}

