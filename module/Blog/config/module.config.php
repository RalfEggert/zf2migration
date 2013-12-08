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
    'router'          => array(
        'routes' => array(
            'blog'          => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/:lang/blog[/:page]',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'lang'          => 'de',
                        'module'        => 'blog',
                        'controller'    => 'index',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'lang' => '(de|en)',
                        'page' => '[0-9]*',
                    ),
                ),
            ),
            'blog-admin'    => array(
                'type'          => 'Segment',
                'options'       => array(
                    'route'       => '/:lang/blog/:controller[/:action]',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'      => 'de',
                        'module'        => 'blog',
                        'controller'    => 'admin',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'controller' => '(admin|category)',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'page' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/page/:page',
                            'constraints' => array(
                                'page' => '[0-9]*',
                            ),
                            'defaults'    => array(
                                'page' => '1',
                            ),
                        ),
                    ),
                    'id'   => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/id/:id',
                            'constraints' => array(
                                'id' => '[0-9]*',
                            ),
                        ),
                    ),
                ),
            ),
            'blog-article'  => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/:lang/beitrag/:url',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'      => 'de',
                        'module'        => 'blog',
                        'controller'    => 'index',
                        'action'        => 'show',
                    ),
                    'constraints' => array(
                        'lang' => '(de|en)',
                        'url'  => '[a-z0-9-]*',
                    ),
                ),
            ),
            'blog-category' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/:lang/kategorie/:url[/:page]',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'      => 'de',
                        'module'        => 'blog',
                        'controller'    => 'index',
                        'action'        => 'category',
                    ),
                    'constraints' => array(
                        'lang' => '(de|en)',
                        'url'  => '[a-z0-9-]*',
                        'page' => '[0-9]*',
                    ),
                ),
            ),
            'blog-user'     => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/:lang/nutzer/:url[/:page]',
                    'defaults'    => array(
                        '__NAMESPACE__' => 'Blog\Controller',
                        'language'      => 'de',
                        'module'        => 'blog',
                        'controller'    => 'index',
                        'action'        => 'user',
                    ),
                    'constraints' => array(
                        'lang' => '(de|en)',
                        'url'  => '[a-z0-9-]*',
                        'page' => '[0-9]*',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'shared'     => array(
            'Blog\Entity\Article'  => false,
            'Blog\Entity\Category' => false,
        ),
        'invokables' => array(
            'Blog\Entity\Article'  => 'Blog\Entity\ArticleEntity',
            'Blog\Entity\Category' => 'Blog\Entity\CategoryEntity',
        ),
        'factories'  => array(
            'Blog\Table\Article'    => 'Blog\Table\ArticleTableFactory',
            'Blog\Table\Category'   => 'Blog\Table\CategoryTableFactory',
            'Blog\Service\Article'  => 'Blog\Service\ArticleServiceFactory',
            'Blog\Service\Category' => 'Blog\Service\CategoryServiceFactory',
        ),
    ),
    'hydrators'       => array(
        'invokables' => array(
            'Blog\Hydrator\Article'  => 'Blog\Hydrator\ArticleHydrator',
            'Blog\Hydrator\Category' => 'Blog\Hydrator\CategoryHydrator',
        ),
    ),
    'controllers'     => array(
        'factories' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexControllerFactory',
            'Blog\Controller\Admin' => 'Blog\Controller\AdminControllerFactory',
        ),
    ),
    'form_elements'   => array(
        'invokables' => array(
            'Blog\Form\Category' => 'Blog\Form\CategoryForm',
        ),
        'factories'  => array(
            'Blog\Form\Article' => 'Blog\Form\ArticleFormFactory',
        ),
    ),
    'translator'      => array(
        'locale'                    => 'de',
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => realpath(__DIR__ . '/../language'),
                'pattern'  => '%s.php',
            ),
        ),
    ),
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers'    => array(
        'invokables' => array(
            'showArticle' => 'Blog\View\Helper\ShowArticle'
        ),
    ),
    'acl'             => array(
        'guest'  => array(
            'blog-index' => array(
                'allow' => null
            ),
        ),
        'editor' => array(
            'blog-admin' => array(
                'allow' => null,
                'deny'  => array('delete'),
            ),
        ),
        'admin'  => array(
            'blog-index'    => array('allow' => null),
            'blog-category' => array('allow' => null),
            'blog-admin'    => array('allow' => null),
        ),
    ),

    'navigation'      => array(
        'default' => array(
            'blog'  => array(
                'type'       => 'mvc',
                'label'      => 'title_blog_index_index',
                'route'      => 'blog',
                'order'      => 100,
                'module'     => 'blog',
                'controller' => 'index',
                'action'     => 'index',
                'resource'   => 'blog-index',
                'privilege'  => 'index',
            ),
            'admin' => array(
                'pages' => array(
                    'blog-admin'    => array(
                        'type'       => 'mvc',
                        'order'      => '910',
                        'label'      => 'title_blog_admin_index',
                        'route'      => 'blog',
                        'controller' => 'admin',
                        'action'     => 'index',
                        'resource'   => 'blog-admin',
                        'privilege'  => 'index',
                    ),
                    'blog-category' => array(
                        'type'       => 'mvc',
                        'order'      => '920',
                        'label'      => 'title_blog_category_index',
                        'route'      => 'blog',
                        'controller' => 'category',
                        'action'     => 'index',
                        'resource'   => 'blog-category',
                        'privilege'  => 'index',
                    ),
                ),
            ),
        ),
    ),
);