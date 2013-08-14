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
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Application module index controller
 *
 * @package    Application
 */
class IndexController extends AbstractActionController
{
    /*
     * Home page
     */
    public function indexAction()
    {
        $articleList = \Blog_Service_Article::getInstance()->fetchListApproved();
        
        return new ViewModel(array(
            'articleList' => $articleList,
        ));
    }
}
