<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Category delete form
 * 
 * Handles the category delete form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Form_CategoryDelete extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'blog_delete';
    
    /**
     * form action
     */
    public $formAction = '/blog/category/delete';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Hidden', 'category_id', array(
            'required'      => true,
            'decorators'    => $this->_hiddenDecorators,
        ));
        
        $this->addElement('Submit', 'submit_category_delete', array(
            'label'         => 'submit_blog_category_delete',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
    }
}

