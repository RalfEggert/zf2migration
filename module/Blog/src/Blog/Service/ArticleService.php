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

use Blog\Entity\ArticleEntity;
use Blog\Hydrator\ArticleHydrator;
use Blog\Table\ArticleTable;
use Zend\Db\Adapter\Exception\InvalidQueryException;

/**
 * Class ArticleService
 *
 * @package Blog\Service
 */
class ArticleService
{
    /**
     * @var ArticleEntity
     */
    protected $entity;
    /**
     * @var ArticleHydrator
     */
    protected $hydrator;
    /**
     * @var ArticleTable
     */
    protected $table;

    /**
     * @param ArticleTable    $table
     * @param ArticleEntity   $entity
     * @param ArticleHydrator $hydrator
     */
    function __construct(
        ArticleTable $table, ArticleEntity $entity, ArticleHydrator $hydrator
    ) {
        $this->setTable($table);
        $this->setEntity($entity);
        $this->setHydrator($hydrator);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function create(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $entity = clone $this->getEntity();

        $this->getHydrator()->hydrate($data, $entity);

        $saveData = $this->getHydrator()->extract($entity);

        $saveData['article_date']  = date('Y-m-d H:i:s');
        $saveData['article_user']  = 1;
        $saveData['article_count'] = 0;
        $saveData['article_url']   = md5(serialize($saveData));

        try {
            $this->getTable()->insert($saveData);
        } catch (InvalidQueryException $e) {
            return false;
        }

        return $this->getTable()->getLastInsertValue();
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function update($id, array $data)
    {
        if (empty($data)) {
            return false;
        }

        $entity = $this->fetchSingleById($id);

        $this->getHydrator()->hydrate($data, $entity);

        $saveData = $this->getHydrator()->extract($entity);

        try {
            $this->getTable()->update($saveData, array('id' => $id));
        } catch (InvalidQueryException $e) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function fetchMany()
    {
        $list = $this->getTable()->fetchMany();

        return $this->getEntityList($list);
    }

    /**
     * @param $category
     *
     * @return array
     */
    public function fetchManyByCategory($category)
    {
        $list = $this->getTable()->fetchManyByCategory($category);

        return $this->getEntityList($list);
    }

    /**
     * @param $status
     *
     * @return array
     */
    public function fetchManyByStatus($status)
    {
        $list = $this->getTable()->fetchManyByStatus($status);

        return $this->getEntityList($list);
    }

    /**
     * @param $user
     *
     * @return array
     */
    public function fetchManyByUser($user)
    {
        $list = $this->getTable()->fetchManyByUser($user);

        return $this->getEntityList($list);
    }

    /**
     * @param $identifier
     *
     * @return \Blog\Entity\ArticleEntity
     */
    public function fetchSingleById($identifier)
    {
        return $this->getTable()->fetchSingleById($identifier);
    }

    /**
     * @param $url
     *
     * @return \Blog\Entity\ArticleEntity
     */
    public function fetchSingleByUrl($url)
    {
        return $this->getTable()->fetchSingleByUrl($url);
    }

    /**
     * @return \Blog\Entity\ArticleEntity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param \Blog\Entity\ArticleEntity $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return \Blog\Hydrator\ArticleHydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * @param \Blog\Hydrator\ArticleHydrator $hydrator
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return \Blog\Table\ArticleTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param \Blog\Table\ArticleTable $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @param $list
     *
     * @return array
     */
    protected function getEntityList($list)
    {
        $newList = array();

        foreach ($list as $entity) {
            $newList[$entity->getId()] = $entity;
        }

        return $newList;
    }
}