<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Article create form
 * 
 * Handles the article create form
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Form_ArticleCreate extends Company_Form
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
        $this->addElement('Select', 'article_category', array(
            'required'      => true,
            'label'         => 'label_blog_article_category',
            'description'   => 'text_blog_article_category',
            'class'         => 'span6',
        ));
        
        $this->addElement('Text', 'article_title', array(
            'required'       => true,
            'label'          => 'label_blog_article_title',
            'description'    => 'text_blog_article_title',
            'size'           => '128',
            'class'          => 'span6',
            'filters'        => array('StringTrim'),
        ));
        
        $this->addElement('Textarea', 'article_teaser', array(
            'required'      => false,
            'label'         => 'label_blog_article_teaser',
            'description'   => 'text_blog_article_teaser',
            'cols'          => '80',
            'rows'          => '5',
            'class'         => 'span6 ckeditor',
            'filters'       => array('StringTrim', 'StripSlashes', 'HtmlPurifier'),
        ));
        
        $this->addElement('Textarea', 'article_text', array(
            'required'      => true,
            'label'         => 'label_blog_article_text',
            'description'   => 'text_blog_article_text',
            'cols'          => '80',
            'rows'          => '5',
            'class'         => 'span6 ckeditor',
            'filters'       => array('StringTrim', 'StripSlashes', 'HtmlPurifier'),
        ));
        
        $this->addElement('Submit', 'submit_article_create', array(
            'label'         => 'submit_blog_article_create',
            'class'         => 'btn btn-success',
            'decorators'    => $this->_submitDecorators,
        ));
        
        $this->getElement('article_category')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('article_title')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('article_teaser')->getDecorator('Description')->setOption('placement', 'prepend');
        $this->getElement('article_text')->getDecorator('Description')->setOption('placement', 'prepend');
    }
}

