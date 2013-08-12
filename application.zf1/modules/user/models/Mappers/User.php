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
class User_Model_Mappers_User
{
    /**
     * Database Table
     * 
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable = null;
    
    /**
     * Get current database table
     * 
     * @return Zend_Db_Table_Abstract
     */
    public function getTable()
    {
        if (!isset($this->_dbTable)) {
            $this->_dbTable = new User_Model_DbTable_Users();
        }
        return $this->_dbTable;
    }
    
    /**
     * Get Cache
     * 
     * @return Zend_Cache_Core
     */
    public function getCache()
    {
        return Zend_Registry::get('cache');
    }
    
    /**
     * Get Model for database row
     * 
     * @return User_Model_User
     */
    public function getModel($row)
    {
        $model = new User_Model_User();
        $model->setId($row->user_id);
        $model->setDate($row->user_date);
        $model->setGroup($row->user_group);
        $model->setStatus($row->user_status);
        $model->setName($row->user_name);
        $model->setPassword($row->user_password);
        $model->setEmail($row->user_email);
        $model->setWebsite($row->user_website);
        $model->setText($row->user_text);
        $model->setUrl($row->user_url);
        
        return $model;
    }
    
    /**
     * Fetch user by identifier
     * 
     * @param integer $identifier
     * @return User_Model_User
     */
    public function fetchSingle($identifier)
    {
        $cacheId = 'user_single_' . $identifier;
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('user_id = "' . (int) $identifier . '"');
            
            if (is_null($row))
            {
                return false;
            }
            
            $model = $this->getModel($row);
        
            $this->getCache()->save($model, $cacheId, array('user'));
        }
        
        return $model;
    }
    
    /**
     * Fetch user by url
     * 
     * @param integer $url
     * @return User_Model_User
     */
    public function fetchSingleByUrl($url)
    {
        $cacheId = 'user_single_' . md5($url);
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('user_url = "' . $url . '"');
        
            $model = $this->getModel($row);
            
            $this->getCache()->save($model, $cacheId, array('user'));
        }
        
        return $model;
    }
    
    /**
     * Fetch list of users
     * 
     * @return array list of User_Model_User
     */
    public function fetchList()
    {
        $cacheId = 'user_all';
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->order('user_name ASC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
        
            $this->getCache()->save($list, $cacheId, array('user'));
        }
        
        return $list;
    }
    
    /**
     * Fetch list of users by group
     *
     * @param $group identifier for group
     * @return array list of User_Model_User
     */
    public function fetchListByGroup($group)
    {
        $cacheId = 'user_group_' . $group;
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->where('user_group = ?', $group);
            $select->order('user_name ASC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
            
            $this->getCache()->save($list, $cacheId, array('user'));
        }
        
        return $list;
    }

    /**
     * Prepare the url
     *
     * @param array $data form data user to be saved
     * @return string new checked url
     */
    protected function _prepareUrl($id, $text)
    {
        // get url
        $url = Zend_Filter::filterStatic($text, 'StringToUrl');
        
        // build select to catch similar urls
        $select = $this->getTable()->select();
        $select->where('user_url LIKE ?', $url . '%');
        $select->order('user_id DESC');
        
        // fetch similar urls
        $rows = $this->getTable()->fetchAll($select)->toArray();
        
        // check for empty rows
        if (empty($rows))
        {
            return $url;
        }
        
        // initialize found urls
        $foundUrls = array();
        
        // loop through rows
        foreach ($rows as $row)
        {
            // check for current article
            if ($row['user_id'] == $id)
            {
                return $row['user_url'];
            }
            
            // add to found urls
            $foundUrls[] = $row['user_url'];
        }
        
        // sort found urls
        natsort($foundUrls);
        
        // get last found url
        $lastUrl = array_pop($foundUrls);
        
        // get number
        $lastNumber = str_replace($url . '-', '', $lastUrl);
        
        // build new url
        $url = $url . '-' . ($lastNumber + 1);
        
        // pass url
        return $url;
    }
    
    /**
     * Create new user
     *
     * @param array $data form data user to be saved
     * @return integer new primary key
     */
    public function create(array $data)
    {
        // get url
        $url = $this->_prepareUrl(null, $data['user_name']);
        
        // set input data
        $inputData = array(
            'user_date'     => date('Y-m-d H:i:s'),
            'user_status'   => 'approved',
            'user_group'    => 'reader',
            'user_name'     => $data['user_name'    ],
            'user_password' => md5($data['user_password']),
            'user_email'    => $data['user_email'   ],
            'user_website'  => $data['user_website' ],
            'user_url'      => $url,
        );
        
        // save to database
        $row = $this->getTable()->createRow($inputData);
        $row->save();
        
        // clear cache for user
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user'));
        
        return $row->user_id;
    }
    
    /**
     * Update existing user
     *
     * @param integer $id user id
     * @param array $data input data
     * @return void
     */
    public function update($id, array $data)
    {
        // get url
        $url = $this->_prepareUrl($id, $data['user_name']);
        
        // set input data
        $inputData = array(
            'user_date'     => date('Y-m-d H:i:s'),
            'user_name'     => $data['user_name'    ],
            'user_email'    => $data['user_email'   ],
            'user_website'  => $data['user_website' ],
            'user_text'     => $data['user_text'    ],
            'user_url'      => $url,
        );
        
        // check for user password
        if (!empty($data['user_password']))
        {
            $inputData['user_password'] = md5($data['user_password']);
        }
        
        // check for user status
        if (!empty($data['user_status']))
        {
            $inputData['user_status'] = $data['user_status'];
        }
        
        // check for user group
        if (!empty($data['user_group']))
        {
            $inputData['user_group'] = $data['user_group'];
        }
        
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->setFromArray($inputData);
        $row->save();
        
        // clear cache for user
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user'));
    }
    
    /**
     * Delete existing user
     *
     * @param integer $id user id
     * @return void
     */
    public function delete($id)
    {
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->delete();
        
        // clear cache for user
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('user'));
    }
}

