<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Blog category model
 * 
 * Handles the blog category model
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Blog_Model_Category
{
    /**
     * Protected category elements
     */
    protected $_id = null;
    protected $_name = null;
    protected $_url = null;
    
    /**
     * Set category id
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
     * Get category id
     * 
     * @return integer
     */
    public function getId() 
    {
        return $this->_id;
    }
    
    /**
     * Set category name
     * 
     * @param string $name
     */
    public function setName($name) 
    {
        if (is_string($name)) {
            $this->_name = $name;
        } 
    }
    
    /**
     * Get category name
     * 
     * @return integer
     */
    public function getName() 
    {
        return $this->_name;
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
     * @return integer
     */
    public function getUrl() 
    {
        return $this->_url;
    }
    
    /**
     * Convert model data to array
     * 
     * @return array
     */
    public function toArray() 
    {
        $data = array(
            'category_id'      => $this->getId(),
            'category_name'    => $this->getName(),
            'category_url'     => $this->getUrl(),
        );
        
        return $data;
    }

}
