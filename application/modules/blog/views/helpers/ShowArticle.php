<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Show article View Helper
 *
 * Outputs the blog article
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_View_Helper_ShowArticle extends Zend_View_Helper_Abstract
{
    /**
     * Handle the article output
     */
    function showArticle(Blog_Model_Article $article, $showTitle = true, $showTeaser = true)
    {
        if ($showTitle) {
            $output = '<h2><a href="' . $this->view->url(array('url' => $article->getUrl()), 'blog-article') . '">' . $article->getTitle() . '</a></h2>';
        } else {
            $output = '';
        }
        
        $output.= '<p><em>';
        $output.= $this->view->translate('label_blog_written', array(
            ' <a href="' . $this->view->url(array('url' => $article->getUser()->getUrl()), 'blog-user') . '">' . $article->getUser()->getName() . '</a>',
            $this->view->date($article->getDate()),
            $this->view->time($article->getDate()),
            '<a href="' . $this->view->url(array('url' => $article->getCategory()->getUrl()), 'blog-category') . '">' . $article->getCategory()->getName() . '</a>',
        ));
        $output.= '</em></p>';
        $output.= $showTeaser ? $article->getTeaser() : $article->getText();
        
        return $output;
    }
}