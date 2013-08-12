<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Paginate View Helper
 *
 * Outputs the page navigation
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Application_View_Helper_Paginate extends Zend_View_Helper_Abstract
{
    /**
     * Handle the pagination
     */
    function paginate($url, $pageHandling)
    {
        // get params
        $max = ceil($pageHandling['max'] / $pageHandling['step']);
        $current = $pageHandling['current'];
        
        // initialize output
        $output = '<div class="pagination">';
        $output.= '<ul>';
        
        // add pages
        $output.= ($current > 10) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current - 10))) . '">-10</a></li>' : '';
        $output.= ($current >  3) ? ' <li><a href="' . $this->view->url(array_merge($url, array('page' => 1))) . '">1</a></li>' : '';
        $output.= (($current - 2) > 0) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current - 2))) . '">' . ($current - 2) . '</a></li>' : '';
        $output.= (($current - 1) > 0) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current - 1))) . '">' . ($current - 1) . '</a></li>' : '';
        $output.= '<li class="active"><a href="' . $this->view->url(array_merge($url, array('page' => $current))) . '">' . ($current) . '</a></li>';
        $output.= (($current + 1) <= $max) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current + 1))) . '">' . ($current + 1) . '</a></li>' : '';
        $output.= (($current + 2) <= $max) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current + 2))) . '">' . ($current + 2) . '</a></li>' : '';
        $output.= (($current + 3) <= $max) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $max))) . '">' . ($max) . '</a></li>' : '';
        $output.= (($current + 10) <= $max) ? '<li><a href="' . $this->view->url(array_merge($url, array('page' => $current + 10))) . '">+10</a></li>' : '';
        
        // add end
        $output.= '</ul>';
        $output.= '</div>';
        
        return $output;
    }
}