<?php
/**
 * ZF1 example
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog article model
 *
 * Handles the blog article model
 *
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Model_Article
{
    /**
     * Protected article elements
     */
    protected $_id = null;
    protected $_date = null;
    protected $_status = null;
    protected $_user = null;
    protected $_category = null;
    protected $_title = null;
    protected $_teaser = null;
    protected $_text = null;
    protected $_url = null;
    protected $_count = null;
    
    /**
     * Set article id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $id = (int) $id;
    
        if ($id != 0) {
            $this->_id = $id;
        }
    }
    
    /**
     * Get article id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set article date
     *
     * @param string $date
     */
    public function setDate($date)
    {
        $this->_date = $date;
    }
    
    /**
     * Get article date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Set article status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        if (!in_array($status, array('new', 'approved', 'blocked')))
        {
            return false;
        }
    
        $this->_status = $status;
    }
    
    /**
     * Get article status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->_status;
    }
    
    /**
     * Set article user
     *
     * @param User_Model_User $user
     */
    public function setUser(User_Model_User $user)
    {
        $this->_user = $user;
    }
    
    /**
     * Get article user
     *
     * @return User_Model_User
     */
    public function getUser()
    {
        return $this->_user;
    }
    
    /**
     * Set article category
     *
     * @param Blog_Model_Category $category
     */
    public function setCategory(Blog_Model_Category $category)
    {
        $this->_category = $category;
    }
    
    /**
     * Get article category
     *
     * @return Blog_Model_Category
     */
    public function getCategory()
    {
        return $this->_category;
    }
    
    /**
     * Set article title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }
    
    /**
     * Get article title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Set article teaser
     *
     * @param string $teaser
     */
    public function setTeaser($teaser)
    {
        if (is_string($teaser)) {
            $this->_teaser = $teaser;
        }
    }
    
    /**
     * Get article teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->_teaser;
    }
    
    /**
     * Set article text
     *
     * @param string $text
     */
    public function setText($text)
    {
        if (is_string($text)) {
            $this->_text = $text;
        }
    }
    
    /**
     * Get article text
     *
     * @return string
     */
    public function getText()
    {
        return $this->_text;
    }
    
    /**
     * Set article url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        if (is_string($url)) {
            $this->_url = $url;
        }
    }
    
    /**
     * Get article url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Set article count
     *
     * @param string $count
     */
    public function setCount($count)
    {
        if (is_string($count)) {
            $this->_count = $count;
        }
    }
    
    /**
     * Get article count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->_count;
    }
    
    /**
     * Convert model data to array
     *
     * @return array
     */
    public function toArray()
    {
        $data = array(
            'article_id'            => $this->getId(),
            'article_date'          => $this->getDate(),
            'article_status'        => $this->getStatus(),
            'article_user'          => $this->getUser()->toArray(),
            'article_category'      => $this->getCategory()->toArray(),
            'article_title'         => $this->getTitle(),
            'article_teaser'        => $this->getTeaser(),
            'article_text'          => $this->getText(),
            'article_url'           => $this->getUrl(),
            'article_count'         => $this->getCount(),
        );
    
        return $data;
    }

}

