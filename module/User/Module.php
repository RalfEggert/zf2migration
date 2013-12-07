<?php
/**
 * ZF2 migration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace User;

use User\Listener\AuthorizationListener;
use Zend\Mvc\MvcEvent;

/**
 * User module class
 *
 * @package    Application
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        // add authorization listener
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attachAggregate(new AuthorizationListener());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
