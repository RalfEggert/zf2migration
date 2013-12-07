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
namespace Blog\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * ShowArticle view helper
 *
 * @package    Blog
 */
class ShowArticle extends AbstractHelper
{
    function __invoke(
        \Blog_Model_Article $article, $showTitle = true, $showTeaser = true
    ) {
        $articleUrl  = $this->getView()->url(
            'blog-article', array('url' => $article->getUrl()), true
        );
        $userUrl     = $this->getView()->url(
            'blog-user', array('url' => $article->getUser()->getUrl()), true
        );
        $categoryUrl = $this->getView()->url(
            'blog-category', array('url' => $article->getCategory()->getUrl()),
            true
        );

        if ($showTitle) {
            $output = '<h2><a href="' . $articleUrl . '">'
                . $article->getTitle()
                . '</a></h2>';
        } else {
            $output = '';
        }

        $output .= '<p><em>';
        $output .= sprintf(
            $this->getView()->translate('label_blog_written'),
            ' <a href="' . $userUrl . '">' . $article->getUser()
                ->getName() . '</a>',
            $this->getView()->date($article->getDate(), 'dateonly'),
            $this->getView()->date($article->getDate(), 'timeonly'),
            '<a href="' . $categoryUrl . '">' . $article->getCategory()
                ->getName() . '</a>'
        );
        $output .= '</em></p>';
        $output .= $showTeaser ? $article->getTeaser() : $article->getText();

        return $output;
    }

}