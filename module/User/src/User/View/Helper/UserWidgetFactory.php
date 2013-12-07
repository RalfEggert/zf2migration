<?php
/**
 * ZF2 migration
 *
 * @package    User
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace User\View\Helper;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Application module admin controller factory
 *
 * @package    User
 */
class UserWidgetFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $viewHelperManager
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $viewHelperManager)
    {
        $serviceLocator = $viewHelperManager->getServiceLocator();

        $identity    = $serviceLocator->get('Zend\Auth');
        $userService = $serviceLocator->get('User\Service\User');

        $controller = new UserWidget($identity->getIdentity(), $userService);

        return $controller;
    }

} 