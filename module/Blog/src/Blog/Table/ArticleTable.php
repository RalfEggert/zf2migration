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

use Blog\Entity\ArticleEntity;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\TableGateway\TableGateway;

/**
 * Blog article table
 *
 * Handles the blog article table
 *
 * @package    Blog
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class ArticleTable extends TableGateway
{
    /**
     * @param AdapterInterface   $adapter
     * @param ResultSetInterface $resultSetPrototype
     */
    public function __construct(
        AdapterInterface $adapter, ResultSetInterface $resultSetPrototype = null
    ) {
        parent::__construct(
            'blog_articles', $adapter, null, $resultSetPrototype
        );
    }

    /**
     * @param $identifier
     *
     * @return ArticleEntity
     */
    public function fetchSingleById($identifier)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_id', $identifier);

        return $this->selectWith($select)->current();
    }

    /**
     * @param $url
     *
     * @return ArticleEntity
     */
    public function fetchSingleByUrl($url)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_url', $url);

        return $this->selectWith($select)->current();
    }

    /**
     * @return ResultSetInterface
     */
    public function fetchMany()
    {
        $select = $this->getSql()->select();
        $select->order('article_date DESC');

        return $this->selectWith($select);
    }

    /**
     * @param $category
     *
     * @return ResultSetInterface
     */
    public function fetchManyByCategory($category)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_category', $category);
        $select->where->equalTo('article_status', 'approved');
        $select->order('article_date DESC');

        return $this->selectWith($select);
    }

    /**
     * @param $user
     *
     * @return ResultSetInterface
     */
    public function fetchManyByUser($user)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_user', $user);
        $select->where->equalTo('article_status', 'approved');
        $select->order('article_date DESC');

        return $this->selectWith($select);
    }

    /**
     * @param $status
     *
     * @return ResultSetInterface
     */
    public function fetchManyByStatus($status)
    {
        $select = $this->getSql()->select();
        $select->where->equalTo('article_status', $status);
        $select->order('article_date DESC');

        return $this->selectWith($select);
    }

}

