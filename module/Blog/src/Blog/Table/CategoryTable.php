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

use Blog\Entity\CategoryEntity;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGateway;

/**
 * Blog category table
 *
 * Handles the blog category table
 *
 * @package    Blog
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class CategoryTable extends TableGateway
{
    /**
     * @param AdapterInterface   $adapter
     * @param ResultSetInterface $resultSetPrototype
     */
    public function __construct(
        AdapterInterface $adapter, ResultSetInterface $resultSetPrototype = null
    ) {
        parent::__construct(
            'blog_categories', $adapter, null, $resultSetPrototype
        );
    }

    /**
     * @param $identifier
     *
     * @return CategoryEntity
     */
    public function fetchSingleById($identifier)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('category_id', $identifier);

        return $this->selectWith($select)->current();
    }

    /**
     * @param $url
     *
     * @return CategoryEntity
     */
    public function fetchSingleByUrl($url)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('category_url', $url);

        return $this->selectWith($select)->current();
    }

    /**
     * @return ResultSetInterface
     */
    public function fetchMany()
    {
        $select = $this->getSql()->select();
        $select->order('category_name ASC');

        return $this->selectWith($select);
    }
}

