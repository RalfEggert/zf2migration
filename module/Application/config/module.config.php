<?php
/**
 * ZF2 migration
 *
 * Application module configuration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
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
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables'=> array(
            'date' => 'Application\View\Helper\Date',
        ),
    ),
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    
    'navigation' => array(
        'default' => array(
            'blog' => array(
                'type'       => 'uri',
                'label'      => 'title_blog_index_index',
                'uri'        => '/de/blog',
            ),
            'about' => array(
                'type'       => 'uri',
                'label'      => 'title_default_about_index',
                'uri'        => '/de/default/about',
            ),
            'user' => array(
                'type'       => 'uri',
                'label'      => 'title_user_index_index',
                'uri'        => '/de/user',
            ),
            'admin' => array(
                'type'       => 'uri',
                'label'      => 'title_default_admin_index',
                'uri'        => '#dropdown1',
                'pages'      => array(
                    'blog-admin' => array(
                        'type'       => 'uri',
                        'label'      => 'title_blog_admin_index',
                        'uri'        => '/de/blog/admin',
                    ),
                    'blog-category' => array(
                        'type'       => 'uri',
                        'label'      => 'title_blog_category_index',
                        'uri'        => '/de/blog/category',
                    ),
                    'user-admin' => array(
                        'type'       => 'uri',
                        'label'      => 'title_user_admin_index',
                        'uri'        => '/de/user/admin',
                    ),
                ),
            ),
        ),
    ),
);
