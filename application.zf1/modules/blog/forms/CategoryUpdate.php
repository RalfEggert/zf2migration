<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Category update form
 * 
 * Handles the category update form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Form_CategoryUpdate extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'category_update';
    
    /**
     * form action
     */
    public $formAction = '/blog/category/update';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Text', 'category_name', array(
            'required'       => true,
            'label'          => 'label_blog_category_name',
            'description'    => 'text_blog_category_name',
            'size'           => '128',
            'class'          => 'span6',
            'filters'        => array('StringTrim'),
        ));
        
        $this->addElement('Submit', 'submit_category_update', array(
            'label'         => 'submit_blog_category_update',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
        $this->getElement('category_name')->getDecorator('Description')->setOption('placement', 'prepend');
    }
}

