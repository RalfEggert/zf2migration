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
namespace Blog\Form;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ArticleFormFactory
 *
 * @package Blog\Form
 */
class ArticleFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $formElementManager
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $formElementManager)
    {
        $serviceLocator = $formElementManager->getServiceLocator();

        $categoryService = $serviceLocator->get('Blog\Service\Category');

        $categoryOptions = array();

        foreach ($categoryService->fetchMany() as $category) {
            $categoryOptions[$category->getId()] = $category->getName();
        }

        $statusOptions = array(
            'new' => 'new', 'approved' => 'approved', 'blocked' => 'blocked'
        );

        $form = new ArticleForm();
        $form->setCategoryOptions($categoryOptions);
        $form->setStatusOptions($statusOptions);

        return $form;
    }

} 