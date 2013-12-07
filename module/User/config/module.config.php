<?php
/**
 * ZF2 migration
 *
 * User module configuration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
return array(
    'router' => array(
        'routes' => array(
            'user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'    => '/:lang/user[/:controller[/:action]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'lang'          => 'de',
                        'module'        => 'user',
                        'controller'    => 'index',
                        'action'        => 'index',
                    ),
                    'constraints' => array(
                        'lang'       => '(de|en)',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                ),
            ),
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'user' => 'User\Controller\IndexController',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'User\Acl' => 'User\Acl\AclFactory',
        ),
        'services' => array(
            'Zend\Auth'         => \Zend_Auth::getInstance(),
            'User\Service\User' => \User_Service_User::getInstance(),
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'userWidget' => 'User\View\Helper\UserWidgetFactory'
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

    'acl' => array(
        'guest'   => array(
            'user-index' => array(
                'allow' => array('index', 'login', 'forbidden', 'create'),
            ),
        ),
        'reader' => array(
            'user-index' => array(
                'allow' => array('index', 'logout', 'forbidden', 'create'),
            ),
        ),
        'admin'   => array(
            'user-index' => array('allow' => null),
            'user-admin' => array('allow' => null),
        ),
    ),

    'navigation' => array(
        'default' => array(
            'user' => array(
                'type'       => 'mvc',
                'order'      => '300',
                'label'      => 'title_user_index_index',
                'route'      => 'user',
                'module'     => 'user',
                'controller' => 'index',
                'action'     => 'index',
                'resource'   => 'user-index',
                'privilege'  => 'index',
            ),
            'admin' => array(
                'pages'      => array(
                    'user-admin' => array(
                        'type'       => 'mvc',
                        'order'      => '930',
                        'label'      => 'title_user_admin_index',
                        'route'      => 'user',
                        'controller' => 'admin',
                        'action'     => 'index',
                        'resource'   => 'user-admin',
                        'privilege'  => 'index',
                    ),
                ),
            ),
        ),
    ),

);