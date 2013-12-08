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
namespace Blog\Table;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ArticleTableFactory implements FactoryInterface
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

        $hydrator  = $hydratorManager->get('Blog\Hydrator\Article');
        $entity    = $serviceLocator->get('Blog\Entity\Article');
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter');

        $resultSetPrototype = new HydratingResultSet($hydrator, $entity);

        $table = new ArticleTable($dbAdapter, $resultSetPrototype);

        return $table;
    }

} 