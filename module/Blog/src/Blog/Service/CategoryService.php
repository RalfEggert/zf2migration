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

use Blog\Table\CategoryTable;

/**
 * Class CategoryService
 *
 * @package Blog\Service
 */
class CategoryService
{
    /**
     * @var CategoryTable
     */
    protected $table;

    /**
     * @param CategoryTable $table
     */
    function __construct(CategoryTable $table)
    {
        $this->setTable($table);
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
     * @param $identifier
     *
     * @return \Blog\Entity\CategoryEntity
     */
    public function fetchSingleById($identifier)
    {
        return $this->getTable()->fetchSingleById($identifier);
    }

    /**
     * @param $url
     *
     * @return \Blog\Entity\CategoryEntity
     */
    public function fetchSingleByUrl($url)
    {
        return $this->getTable()->fetchSingleByUrl($url);
    }

    /**
     * @return \Blog\Table\CategoryTable
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param \Blog\Table\CategoryTable $table
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