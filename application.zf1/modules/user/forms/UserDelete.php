<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User delete form
 * 
 * Handles the user delete form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Form_UserDelete extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'user_delete';
    
    /**
     * form action
     */
    public $formAction = '/user/index/delete';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Hidden', 'user_id', array(
            'decorators'    => $this->_hiddenDecorators,
        ));
        
        $this->addElement('Submit', 'submit_user_delete', array(
            'label'         => 'submit_user_user_delete',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
    }
}

