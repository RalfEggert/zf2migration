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
namespace Blog\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArticleServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $hydratorManager = $serviceLocator->get('HydratorManager');

        $table    = $serviceLocator->get('Blog\Table\Article');
        $hydrator = $hydratorManager->get('Blog\Hydrator\Article');
        $entity   = $serviceLocator->get('Blog\Entity\Article');

        $service = new ArticleService($table, $entity, $hydrator);

        return $service;
    }

} 