<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Category create form
 * 
 * Handles the category create form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Form_CategoryCreate extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'blog_create';
    
    /**
     * form action
     */
    public $formAction = '/blog/admin/create';
    
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
        
        $this->addElement('Submit', 'submit_category_create', array(
            'label'         => 'submit_blog_category_create',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
        $this->getElement('category_name')->getDecorator('Description')->setOption('placement', 'prepend');
    }
}

