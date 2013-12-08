<?php
/**
 * ZF2 migration
 *
 * @package    Blog
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace Blog\Form;

use Zend\Form\Form;

/**
 * Class ArticleForm
 *
 * @package Blog\Form
 */
class ArticleForm extends Form
{
    /**
     * @var array
     */
    protected $categoryOptions = array();
    protected $statusOptions = array();

    /**
     * @return array
     */
    public function getCategoryOptions()
    {
        return $this->categoryOptions;
    }

    /**
     * @param array $categoryOptions
     */
    public function setCategoryOptions($categoryOptions)
    {
        $this->categoryOptions = $categoryOptions;
    }

    /**
     * @return array
     */
    public function getStatusOptions()
    {
        return $this->statusOptions;
    }

    /**
     * @param array $statusOptions
     */
    public function setStatusOptions($statusOptions)
    {
        $this->statusOptions = $statusOptions;
    }

    /**
     *
     */
    public function init()
    {
        $this->add(
            array(
                'type'       => 'select',
                'name'       => 'article_status',
                'options'    => array(
                    'label'         => 'label_blog_article_status',
                    'value_options' => $this->getStatusOptions(),
                ),
                'attributes' => array(
                    'class' => 'span6',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'select',
                'name'       => 'article_category',
                'options'    => array(
                    'label'         => 'label_blog_article_category',
                    'value_options' => $this->getCategoryOptions(),
                ),
                'attributes' => array(
                    'class' => 'span6',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'text',
                'name'       => 'article_title',
                'options'    => array(
                    'label'         => 'label_blog_article_title',
                    'value_options' => array(),
                ),
                'attributes' => array(
                    'class' => 'span6',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'textarea',
                'name'       => 'article_teaser',
                'options'    => array(
                    'label'         => 'label_blog_article_teaser',
                    'value_options' => array(),
                ),
                'attributes' => array(
                    'class' => 'span6 ckeditor',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'textarea',
                'name'       => 'article_text',
                'options'    => array(
                    'label'         => 'label_blog_article_text',
                    'value_options' => array(),
                ),
                'attributes' => array(
                    'class' => 'span6 ckeditor',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'submit',
                'name'       => 'submit_article_update',
                'attributes' => array(
                    'class' => 'btn btn-success',
                    'value' => 'submit_blog_article_update',
                ),
            )
        );
    }

} 