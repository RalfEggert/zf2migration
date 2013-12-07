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
                    'route'    => '/:lang/blog[/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'lang'   => 'de',
                        'controller' => 'index',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'page'       => '[0-9]*',
                    ),
                ),
            ),
            'blog-admin' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/blog/:controller[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'   => 'de',
                        'controller' => 'admin',
                        'action'     => 'index',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'controller' => '(admin|category)',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'page' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/page/:page',
                            'constraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults' => array(
                                'page' => '1',
                            ),
                        ),
                    ),
                    'id' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/id/:id',
                            'constraints' => array(
                                'id' => '[0-9]*',
                            ),
                        ),
                    ),
                ),
            ),
            'blog-article' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/beitrag/:url',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'   => 'de',
                        'controller' => 'index',
                        'action'     => 'show',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'url'        => '[a-z0-9-]*',
                    ),
                ),
            ),
            'blog-category' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/kategorie/:url[/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'   => 'de',
                        'controller' => 'index',
                        'action'     => 'category',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'url'        => '[a-z0-9-]*',
                        'page'       => '[0-9]*',
                    ),
                ),
            ),
            'blog-user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/nutzer/:url[/:page]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'   => 'de',
                        'controller' => 'index',
                        'action'     => 'user',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'url'        => '[a-z0-9-]*',
                        'page'       => '[0-9]*',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'services' => array(
            'Blog\Service\Article'  => \Blog_Service_Article::getInstance(),
            'Blog\Service\Category' => \Blog_Service_Category::getInstance(),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexControllerFactory',
            'Blog\Controller\Admin' => 'Blog\Controller\AdminControllerFactory',
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
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'showArticle' => 'Blog\View\Helper\ShowArticle'
        ),
    ),

    'navigation'      => array(
        'default' => array(
            'blog'  => array(
                'type'  => 'mvc',
                'label' => 'title_blog_index_index',
                'route' => 'blog',
                'order' => 100,
            ),
            'admin' => array(
                'pages' => array(
                    'blog-admin'    => array(
                        'type'  => 'uri',
                        'label' => 'title_blog_admin_index',
                        'uri'   => '/de/blog/admin',
                    ),
                    'blog-category' => array(
                        'type'  => 'uri',
                        'label' => 'title_blog_category_index',
                        'uri'   => '/de/blog/category',
                    ),
                ),
            ),
        ),
    ),
);