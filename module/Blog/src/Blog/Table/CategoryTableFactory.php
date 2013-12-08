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

class CategoryTableFactory implements FactoryInterface
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

        $hydrator  = $hydratorManager->get('Blog\Hydrator\Category');
        $entity    = $serviceLocator->get('Blog\Entity\Category');
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter');

        $resultSetPrototype = new HydratingResultSet($hydrator, $entity);

        $table = new CategoryTable($dbAdapter, $resultSetPrototype);

        return $table;
    }

} 