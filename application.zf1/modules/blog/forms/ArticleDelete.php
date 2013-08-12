<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Article delete form
 * 
 * Handles the article delete form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Form_ArticleDelete extends Company_Form
{
    /**
     * form name
     */
    public $formName = 'blog_delete';
    
    /**
     * form action
     */
    public $formAction = '/blog/admin/delete';
    
    /**
     * Initialize form elements
     */
    public function initElements()
    {
        $this->addElement('Hidden', 'article_id', array(
            'required'      => true,
            'decorators'    => $this->_hiddenDecorators,
        ));
        
        $this->addElement('Submit', 'submit_article_delete', array(
            'label'         => 'submit_blog_article_delete',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
    }
}

