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
        'services' => array(
            'Zend\Auth'  => \Zend_Auth::getInstance(),
            'User\Service\User'  => \User_Service_User::getInstance(),
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
);