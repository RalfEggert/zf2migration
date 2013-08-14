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
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Listener\ApplicationListener;
use Application\Listener\CompatibilityListener;

/**
 * Application module class
 *
 * @package    Application
 */
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        // add application listener
        $eventManager->attachAggregate(new ApplicationListener());
        $eventManager->attachAggregate(new CompatibilityListener());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        // configure autoloading
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                'zf1-application' => PROJECT_PATH . '/application.zf1/modules/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'autoregister_zf' => true,
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
                'prefixes' => array(
                    'Zend'    => PROJECT_PATH . '/library.zf1/Zend',
                    'Company' => PROJECT_PATH . '/library.zf1/Company',
                ),
            ),
        );
    }
}
