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
namespace Blog\Hydrator;

use Application\Hydrator\PrefixHydrator;

/**
 * Class CategoryHydrator
 *
 * @package Blog\Hydrator
 */
class CategoryHydrator extends PrefixHydrator
{
    /**
     * @var string
     */
    protected $prefix = 'category_';
}