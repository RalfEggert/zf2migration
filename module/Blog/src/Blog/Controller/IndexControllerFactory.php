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
namespace Blog\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Blog module index controller factory
 *
 * @package    Blog
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $controllerLoader
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $controllerLoader)
    {
        $serviceLocator = $controllerLoader->getServiceLocator();

        $articleService  = $serviceLocator->get('Blog\Service\Article');
        $categoryService = $serviceLocator->get('Blog\Service\Category');
        $userService     = $serviceLocator->get('User\Service\User');

        $controller = new IndexController(
            $articleService, $categoryService, $userService
        );

        return $controller;
    }

} 