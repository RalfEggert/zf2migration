<?php
/**
 * ZF2 migration
 *
 * Blog module configuration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
return array(
    'router' => array(
        'routes' => array(
            'blog' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/blog',
                    'defaults' => array(
                        'language'   => 'de',
                        'module'     => 'blog',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'blog-article' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/beitrag/:url',
                    'defaults' => array(
                        'language'   => 'de',
                        'module'     => 'blog',
                        'controller' => 'index',
                        'action'     => 'show',
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'de',
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => realpath(__DIR__ . '/../language'),
                'pattern'  => '%s.php',
            ),
        ),
    ),
);