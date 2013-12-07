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
 * Blog module admin controller
 *
 * @package    Blog
 */
class AdminController extends AbstractActionController
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
     * Create page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function createAction()
    {
        // create article
        $id = $this->getArticleService()->create(
            $this->getRequest()->getPost()->toArray()
        );

        if ($id) {
            return $this->redirect()->toRoute(
                'blog-admin/id',
                array(
                    'controller' => 'admin',
                    'action'     => 'update',
                    'id'         => $id
                ), true
            );
        }

        $createForm = $this->getArticleService()->getForm('create');
        $createForm->setAction(
            $this->url()->fromRoute(
                'blog-admin',
                array('controller' => 'admin', 'action' => 'create'),
                true
            )
        );

        return new ViewModel(
            array(
                'createForm' => $createForm,
            )
        );
    }

    /**
     * Delete page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        $article = $this->getArticleService()->fetchSingleById($id);

        if (!$article) {
            return $this->redirect()->toRoute(
                'blog-admin',
                array('controller' => 'admin', 'action' => null),
                true
            );
        }

        // delete article
        if ($this->getArticleService()->delete(
            $article->getId(), $this->getRequest()->getPost()->toArray()
        )
        ) {
            return $this->redirect()->toRoute(
                'blog-admin', array('controller' => 'admin'), true
            );
        }

        $deleteForm = $this->getArticleService()->getForm('delete');
        $deleteForm->setAction(
            $this->url()->fromRoute(
                'blog-admin/id',
                array(
                    'controller' => 'admin',
                    'action'     => 'delete',
                    'id'         => $article->getId()
                ),
                true
            )
        );

        return new ViewModel(
            array(
                'article'    => $article,
                'deleteForm' => $deleteForm,
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
            return $this->redirect()->toRoute(
                'blog-admin', array('controller' => 'admin'), true
            );
        }

        return new ViewModel(
            array(
                'articleList'  => $articleList,
                'pageHandling' => $pageHandling,
            )
        );
    }

    /**
     * Update page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function updateAction()
    {
        $id = $this->params()->fromRoute('id');

        $article = $this->getArticleService()->fetchSingleById($id);

        if (!$article) {
            return $this->redirect()->toRoute(
                'blog-admin', array('controller' => 'admin'), true
            );
        }

        // update article
        if ($this->getArticleService()->update(
            $article->getId(), $this->getRequest()->getPost()->toArray()
        )
        ) {
            return $this->redirect()->toRoute(
                'blog-admin/id',
                array(
                    'controller' => 'admin',
                    'action'     => 'update',
                    'id'         => $article->getId()
                ), true
            );
        }

        $updateForm = $this->getArticleService()->getForm('update');
        $updateForm->setAction(
            $this->url()->fromRoute(
                'blog-admin/id',
                array(
                    'controller' => 'admin',
                    'action'     => 'update',
                    'id'         => $article->getId()
                ),
                true
            )
        );

        return new ViewModel(
            array(
                'updateForm' => $updateForm,
            )
        );
    }
}
