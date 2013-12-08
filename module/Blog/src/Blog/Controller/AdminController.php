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

use Blog\Form\ArticleForm;
use Blog\Service\ArticleService;
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
     * @var ArticleForm
     */
    protected $articleForm = null;
    /**
     * @var ArticleService
     */
    protected $articleService = null;

    /**
     * @param $articleService
     * @param $categoryService
     * @param $userService
     */
    function __construct(
        ArticleService $articleService, ArticleForm $articleForm
    ) {
        $this->setArticleService($articleService);
        $this->setArticleForm($articleForm);
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

        $createForm = $this->getArticleForm();
        $createForm->setAttribute(
            'action',
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
                'article' => $article,
                'deleteForm' => $deleteForm,
            )
        );
    }

    /**
     * @return \Blog\Form\ArticleForm
     */
    public function getArticleForm()
    {
        return $this->articleForm;
    }

    /**
     * @param \Blog\Form\ArticleForm $articleForm
     */
    public function setArticleForm($articleForm)
    {
        $this->articleForm = $articleForm;
    }

    /**
     * @return ArticleService
     */
    public function getArticleService()
    {
        return $this->articleService;
    }

    /**
     * @param ArticleService $articleService
     */
    public function setArticleService($articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Blog page
     *
     * @return \Zend\Http\Response|ViewModel
     */
    public function indexAction()
    {
        $page = $this->params()->fromRoute('page');

        $articleList = $this->getArticleService()->fetchMany();

        return new ViewModel(
            array(
                'articleList' => $articleList,
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

        $updateForm = $this->getArticleForm();
        $updateForm->setData(
            $this->getArticleService()->getHydrator()->extract($article)
        );
        $updateForm->setAttribute(
            'action',
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
