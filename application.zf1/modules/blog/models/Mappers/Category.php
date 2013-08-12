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
class Blog_Model_Mappers_Category
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
            $this->_dbTable = new Blog_Model_DbTable_Categories();
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
     * @param Zend_Db_Table_Row $row
     * @return Blog_Model_Category
     */
    public function getModel(Zend_Db_Table_Row $row)
    {
        $model = new Blog_Model_Category();
        $model->setId($row->category_id);
        $model->setName($row->category_name);
        $model->setUrl($row->category_url);
        
        return $model;
    }
    
    /**
     * Fetch category by identifier
     * 
     * @param integer $identifier
     * @return Blog_Model_Category
     */
    public function fetchSingle($identifier)
    {
        $cacheId = 'blog_category_single_' . $identifier;
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('category_id = "' . (int) $identifier . '"');
        
            if (is_null($row))
            {
                return false;
            }
            
            $model = $this->getModel($row);
        
            $this->getCache()->save($model, $cacheId, array('blog_category'));
        }
        
        return $model;
    }
    
    /**
     * Fetch category by url
     * 
     * @param integer $url
     * @return Blog_Model_Category
     */
    public function fetchSingleByUrl($url)
    {
        $cacheId = 'blog_category_single_' . md5($url);
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('category_url = "' . $url . '"');
        
            $model = $this->getModel($row);
            
            $this->getCache()->save($model, $cacheId, array('blog_category'));
        }
        
        return $model;
    }
    
    /**
     * Fetch list of categorys
     * 
     * @return array list of Blog_Model_Category
     */
    public function fetchList()
    {
        $cacheId = 'blog_category_all';
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->order('category_name ASC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
        
            $this->getCache()->save($list, $cacheId, array('blog_category'));
        }
        
        return $list;
    }
    
    /**
     * Prepare the url
     *
     * @param array $data form data category to be saved
     * @return string new checked url
     */
    protected function _prepareUrl($text)
    {
        // get url
        $url = Zend_Filter::filterStatic($text, 'StringToUrl');
        
        // build select to catch similar urls
        $select = $this->getTable()->select();
        $select->where('category_url LIKE ?', $url . '%');
        $select->order('category_id DESC');
        
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
            // add to found urls
            $foundUrls[] = $row['category_url'];
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
     * Create new category
     *
     * @param array $data form data category to be saved
     * @return integer new primary key
     */
    public function create(array $data)
    {
        // set input data
        $inputData = array(
            'category_name' => $data['category_name'],
            'category_url'   => $this->_prepareUrl($data['category_name']),
        );
    
        // save to database
        $row = $this->getTable()->createRow($inputData);
        $row->save();
    
        // clear cache for category
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_category'));
    
        return $row->category_id;
    }
    
    /**
     * Update existing category
     *
     * @param integer $id category id
     * @param array $data input data
     * @return void
     */
    public function update($id, array $data)
    {
        // set input data
        $inputData = array(
            'category_name' => $data['category_name'],
        );
        
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->setFromArray($inputData);
        $row->save();
    
        // clear cache for category
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_category'));
    }
    
    /**
     * Delete existing category
     *
     * @param integer $id category id
     * @return void
     */
    public function delete($id)
    {
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->delete();
        
        // clear cache for category
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_category'));
    }
}

