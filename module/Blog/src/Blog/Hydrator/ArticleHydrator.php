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
 * Class ArticleHydrator
 *
 * @package Blog\Hydrator
 */
class ArticleHydrator extends PrefixHydrator
{
    /**
     * @var string
     */
    protected $prefix = 'article_';
}