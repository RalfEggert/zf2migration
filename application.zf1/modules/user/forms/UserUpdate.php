<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User update form
 * 
 * Handles the user update form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Form_UserUpdate extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'user_update';
    
    /**
     * form action
     */
    public $formAction = '/user/index/update';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Hidden', 'user_id', array(
            'decorators'    => $this->_hiddenDecorators,
        ));
        
        $this->addElement('Select', 'user_status', array(
            'required'      => true,
            'label'         => 'label_user_user_status',
            'description'    => 'text_user_user_status',
            'class'         => 'span6',
            'multiOptions'  => array('approved' => 'approved', 'blocked' => 'blocked'),
        ));
        
        $this->addElement('Select', 'user_group', array(
            'required'      => true,
            'label'         => 'label_user_user_group',
            'description'    => 'text_user_user_group',
            'class'         => 'span6',
            'multiOptions'  => array('guest' => 'guest', 'reader' => 'reader', 'editor' => 'editor', 'admin' => 'admin'),
        ));
        
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
            'required'      => false,
            'label'         => 'label_user_user_password',
            'description'    => 'text_user_user_password_update',
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
            'required'      => false,
            'label'         => 'label_user_user_password2',
            'description'    => 'text_user_user_password2_update',
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
            'description'    => 'text_user_user_website',
            'size'          => '255',
            'class'         => 'span6',
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array(
                    'validator' => 'LinkUrl',
                ),
            ),
        ));

        $this->addElement('Textarea', 'user_text', array(
            'required'      => false,
            'label'         => 'label_user_user_text',
            'description'    => 'text_user_user_text',
            'cols'          => '80',
            'rows'          => '5',
            'class'         => 'ckeditor',
            'filters'       => array(
                'StringTrim', 'StripSlashes', 'HtmlPurifier',
            ),
        ));
        
        $this->addElement('Submit', 'submit_user_update', array(
            'label'         => 'submit_user_user_update',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
        $this->getElement('user_status')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_group')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_name')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_email')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_password')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_password2')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_website')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('user_text')->getDecorator('Description')->setOption('placement', 'prepend');
        
    }
}

