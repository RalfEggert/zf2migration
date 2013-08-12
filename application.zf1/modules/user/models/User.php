<?php
/**
 * ZF1 example
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * User user model
 * 
 * Handles the user user model
 * 
 * @package    Application
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class User_Model_User
{
    /**
     * Protected user elements
     */
    protected $_id = null;
    protected $_date = null;
    protected $_group = null;
    protected $_status = null;
    protected $_name = null;
    protected $_password = null;
    protected $_email = null;
    protected $_website = null;
    protected $_text = null;
    protected $_url = null;
    protected $_info = null;
    
    /**
     * Set user id
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
     * Get user id
     * 
     * @return integer
     */
    public function getId() 
    {
        return $this->_id;
    }
    
    /**
     * Set user date
     * 
     * @param string $date
     */
    public function setDate($date) 
    {
        $this->_date = $date;
    }
    
    /**
     * Get user date
     * 
     * @return integer
     */
    public function getDate() 
    {
        return $this->_date;
    }
    
    /**
     * Set user status
     * 
     * @param string $status
     */
    public function setStatus($status) 
    {
        if (!in_array($status, array('approved', 'blocked')))
        {
            return false;
        }
        
        $this->_status = $status;
    }
    
    /**
     * Get user status
     * 
     * @return integer
     */
    public function getStatus() 
    {
        return $this->_status;
    }
    
    /**
     * Set user group
     * 
     * @param string $group
     */
    public function setGroup($group) 
    {
        if (!in_array($group, array('guest', 'reader', 'editor', 'admin')))
        {
            return false;
        }
        
        $this->_group = $group;
    }
    
    /**
     * Get user group
     * 
     * @return integer
     */
    public function getGroup() 
    {
        return $this->_group;
    }
    
    /**
     * Set user name
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
     * Get user name
     * 
     * @return integer
     */
    public function getName() 
    {
        return $this->_name;
    }
    
    /**
     * Set user password
     * 
     * @param string $password
     */
    public function setPassword($password) 
    {
        if (is_string($password)) {
            $this->_password = $password;
        } 
    }
    
    /**
     * Get user password
     * 
     * @return integer
     */
    public function getPassword() 
    {
        return $this->_password;
    }
    
    /**
     * Set user email
     * 
     * @param string $email
     */
    public function setEmail($email) 
    {
        if (is_string($email)) {
            $this->_email = $email;
        } 
    }
    
    /**
     * Get user email
     * 
     * @return integer
     */
    public function getEmail() 
    {
        return $this->_email;
    }
    
    /**
     * Set user website
     * 
     * @param string $website
     */
    public function setWebsite($website) 
    {
        if (is_string($website)) {
            $this->_website = $website;
        } 
    }
    
    /**
     * Get user website
     * 
     * @return integer
     */
    public function getWebsite() 
    {
        return $this->_website;
    }
    
    /**
     * Set user text
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
     * Get user text
     * 
     * @return integer
     */
    public function getText() 
    {
        return $this->_text;
    }
    
    /**
     * Set user info
     * 
     * @param string $info
     */
    public function setInfo($info) 
    {
        if (is_string($info)) {
            $this->_info = $info;
        } 
    }
    
    /**
     * Get user info
     * 
     * @return integer
     */
    public function getInfo() 
    {
        return $this->_info;
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
            'user_id'            => $this->getId(),
            'user_date'          => $this->getDate(),
            'user_group'         => $this->getGroup(),
            'user_status'        => $this->getStatus(),
            'user_name'          => $this->getName(),
            'user_password'      => $this->getPassword(),
            'user_email'         => $this->getEmail(),
            'user_website'       => $this->getWebsite(),
            'user_text'          => $this->getText(),
            'user_url'           => $this->getUrl(),
        );
        
        return $data;
    }
    
}
