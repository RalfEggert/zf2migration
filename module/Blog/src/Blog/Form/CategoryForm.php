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
 * Class CategoryForm
 *
 * @package Blog\Form
 */
class CategoryForm extends Form
{
    /**
     *
     */
    public function init()
    {
        $this->add(
            array(
                'type'       => 'text',
                'name'       => 'category_name',
                'options'    => array(
                    'label'         => 'label_blog_category_name',
                    'value_options' => array(),
                ),
                'attributes' => array(
                    'class' => 'span6',
                ),
            )
        );

        $this->add(
            array(
                'type'       => 'submit',
                'name'       => 'submit_category_update',
                'attributes' => array(
                    'class' => 'btn btn-success',
                    'value' => 'submit_blog_category_update',
                ),
            )
        );
    }

} 