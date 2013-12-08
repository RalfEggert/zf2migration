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
 * Blog module admin controller factory
 *
 * @package    Blog
 */
class AdminControllerFactory implements FactoryInterface
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
        $serviceLocator     = $controllerLoader->getServiceLocator();
        $formElementManager = $serviceLocator->get('FormElementManager');

        $articleService = $serviceLocator->get('Blog\Service\Article');
        $articleForm    = $formElementManager->get('Blog\Form\Article');

        $controller = new AdminController(
            $articleService, $articleForm
        );

        return $controller;
    }

} 