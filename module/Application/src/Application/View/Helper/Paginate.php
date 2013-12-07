<?php
/**
 * ZF2 migration
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * namespace definition and usage
 */
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Paginate view helper
 *
 * @package    Application
 */
class Paginate extends AbstractHelper
{
    function __invoke($url, $params, $pageHandling)
    {
        // get params
        $max     = ceil($pageHandling['max'] / $pageHandling['step']);
        $current = $pageHandling['current'];

        // initialize output
        $output = '<div class="pagination">';
        $output .= '<ul>';

        // add pages
        $output .= ($current > 10) ? '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current - 10)), true
            ) . '">-10</a></li>' : '';
        $output .= ($current > 3) ? ' <li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => 1)), true
            ) . '">1</a></li>' : '';
        $output .= (($current - 2) > 0) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current - 2)), true
            ) . '">' . ($current - 2) . '</a></li>' : '';
        $output .= (($current - 1) > 0) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current - 1)), true
            ) . '">' . ($current - 1) . '</a></li>' : '';
        $output .= '<li class="active"><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current)), true
            ) . '">' . ($current) . '</a></li>';
        $output .= (($current + 1) <= $max) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current + 1)), true
            ) . '">' . ($current + 1) . '</a></li>' : '';
        $output .= (($current + 2) <= $max) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current + 2)), true
            ) . '">' . ($current + 2) . '</a></li>' : '';
        $output .= (($current + 3) <= $max) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $max)), true
            ) . '">' . ($max) . '</a></li>' : '';
        $output .= (($current + 10) <= $max) ?
            '<li><a href="' . $this->getView()->url(
                $url, array_merge($params, array('page' => $current + 10)), true
            ) . '">+10</a></li>' : '';

        // add end
        $output .= '</ul>';
        $output .= '</div>';

        return $output;
    }

}