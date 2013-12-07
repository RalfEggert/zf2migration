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
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Blog module index controller
 *
 * @package    Blog
 */
class IndexController extends AbstractActionController
{
    /**
     * @var \Blog_Service_Article
     */
    protected $articleService = null;
    /**
     * @var \Blog_Service_Category
     */
    protected $categoryService = null;
    /**
     * @var \Blog_Service_User
     */
    protected $userService = null;

    /**
     * @param $articleService
     * @param $categoryService
     * @param $userService
     */
    function __construct(
        \Blog_Service_Article $articleService,
        \Blog_Service_Category $categoryService,
        \User_Service_User $userService
    ) {
        $this->setArticleService($articleService);
        $this->setCategoryService($categoryService);
        $this->setUserService($userService);
    }

    /**
     * Category page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function categoryAction()
    {
        $page = $this->params()->fromRoute('page');
        $url  = $this->params()->fromRoute('url');

        $category = $this->getCategoryService()->fetchSingleByUrl($url);

        if (!$category) {
            $id = $this->params()->fromRoute('id');

            $category = $this->getCategoryService()->fetchSingleById($id);

            if (!$category) {
                return $this->redirect()->toRoute('blog', array(), true);
            }
        }

        $articleList  = $this->getArticleService()->fetchListByCategory(
            $category->getId(), $page
        );
        $pageHandling = $this->getArticleService()->pageListByCategory(
            $category->getId(), $page
        );

        if (empty($articleList) && $page > 0) {
            return $this->redirect()->toRoute(
                'blog-category', array('url' => $category->getUrl()), true
            );
        }

        return new ViewModel(
            array(
                'category'     => $category,
                'articleList'  => $articleList,
                'pageHandling' => $pageHandling,
            )
        );
    }

    /**
     * @return \Blog_Service_Article
     */
    public function getArticleService()
    {
        return $this->articleService;
    }

    /**
     * @param \Blog_Service_Article $articleService
     */
    public function setArticleService($articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * @return \Blog_Service_Category
     */
    public function getCategoryService()
    {
        return $this->categoryService;
    }

    /**
     * @param \Blog_Service_Category $categoryService
     */
    public function setCategoryService($categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return \Blog_Service_User
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @param \Blog_Service_User $userService
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    /**
     * Blog page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page');

        $articleList  = $this->getArticleService()->fetchListApproved($page);
        $pageHandling = $this->getArticleService()->pageListApproved($page);

        if (empty($articleList) && $page > 0) {
            return $this->redirect()->toRoute('blog', array(), true);
        }

        return new ViewModel(
            array(
                'articleList'  => $articleList,
                'pageHandling' => $pageHandling,
            )
        );
    }

    /**
     * Article page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function showAction()
    {
        $url = $this->params()->fromRoute('url');

        $article = $this->getArticleService()->fetchSingleByUrl($url);

        if (!$article) {
            $id = $this->params()->fromRoute('id');

            $article = $this->getArticleService()->fetchSingleById($id);

            if (!$article) {
                return $this->redirect()->toRoute('blog', array(), true);
            }
        }

        return new ViewModel(
            array(
                'article' => $article,
            )
        );
    }

    /**
     * User page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function userAction()
    {
        $page = $this->params()->fromRoute('page');
        $url  = $this->params()->fromRoute('url');

        $user = $this->getUserService()->fetchSingleByUrl($url);

        if (!$user) {
            $id = $this->params()->fromRoute('id');

            $user = $this->getUserService()->fetchSingleById($id);

            if (!$user) {
                return $this->redirect()->toRoute('blog', array(), true);
            }
        }

        $articleList  = $this->getArticleService()->fetchListByUser(
            $user->getId(), $page
        );
        $pageHandling = $this->getArticleService()->pageListByUser(
            $user->getId(), $page
        );

        if (empty($articleList) && $page > 0) {
            return $this->redirect()->toRoute(
                'blog-user', array('url' => $user->getUrl()), true
            );
        }

        return new ViewModel(
            array(
                'user'         => $user,
                'articleList'  => $articleList,
                'pageHandling' => $pageHandling,
            )
        );
    }
}
