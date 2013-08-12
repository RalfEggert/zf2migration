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
class Blog_Model_Mappers_Article
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
            $this->_dbTable = new Blog_Model_DbTable_Articles();
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
     * @return Blog_Model_Article
     */
    public function getModel(Zend_Db_Table_Row $row)
    {
        $categoryMapper = new Blog_Model_Mappers_Category();
        $categoryModel  = $categoryMapper->getModel($row->findParentRow('Blog_Model_DbTable_Categories'));
        
        $userMapper = new User_Model_Mappers_User();
        $user  = $userMapper->getModel($row->findParentRow('User_Model_DbTable_Users'));
        
        $model = new Blog_Model_Article();
        $model->setId($row->article_id);
        $model->setDate($row->article_date);
        $model->setStatus($row->article_status);
        $model->setUser($user);
        $model->setCategory($categoryModel);
        $model->setTitle($row->article_title);
        $model->setTeaser($row->article_teaser);
        $model->setText($row->article_text);
        $model->setUrl($row->article_url);
        $model->setCount($row->article_count);
        
        return $model;
    }
    
    /**
     * Fetch article by identifier
     * 
     * @param integer $identifier
     * @return Blog_Model_Article
     */
    public function fetchSingle($identifier)
    {
        $cacheId = 'blog_article_single_' . $identifier;
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('article_id = "' . (int) $identifier . '"');
        
            if (is_null($row))
            {
                return false;
            }
            
            $model = $this->getModel($row);
                    
            $this->getCache()->save($model, $cacheId, array('blog_article'));
        }
            
        return $model;
    }
    
    /**
     * Fetch article by url
     * 
     * @param integer $url
     * @return Blog_Model_Article
     */
    public function fetchSingleByUrl($url)
    {
        $cacheId = 'blog_article_url_' . md5($url);
        
        if (!$model = $this->getCache()->load($cacheId)) {
            $row = $this->getTable()->fetchRow('article_url = "' . $url . '"');
        
            if (is_null($row))
            {
                return false;
            }
            
            $model = $this->getModel($row);
                    
            $this->getCache()->save($model, $cacheId, array('blog_article'));
        }
        
        return $model;
    }
    
    /**
     * Fetch list of articles
     * 
     * @return array list of Blog_Model_Article
     */
    public function fetchList($status = null)
    {
        $cacheId = 'blog_article_all_' . $status;
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            
            if ($status) {
                $select->where('article_status = ?', $status);
            }
            
            $select->order('article_date DESC');
            
            $rows = $this->getTable()->fetchAll($select);
        
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
            
            $this->getCache()->save($list, $cacheId, array('blog_article'));
        }
            
        return $list;
    }
    
    /**
     * Fetch list of articles by category
     *
     * @param $category identifier for category
     * @return array list of Blog_Model_Article
     */
    public function fetchListByCategory($category)
    {
        $cacheId = 'blog_article_category_' . $category;
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->where('article_category = ?', (int) $category);
            $select->where('article_status = ?', 'approved');
            $select->order('article_date DESC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
            
            $this->getCache()->save($list, $cacheId, array('blog_article'));
        }
            
        return $list;
    }
    
    /**
     * Fetch list of articles by user
     *
     * @param $user identifier for user
     * @return array list of Blog_Model_Article
     */
    public function fetchListByUser($user)
    {
        $cacheId = 'blog_article_user_' . $user;
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->where('article_user = ?', (int) $user);
            $select->where('article_status = ?', 'approved');
            $select->order('article_date DESC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
            
            $this->getCache()->save($list, $cacheId, array('blog_article'));
        }
        
        return $list;
    }

    /**
     * Fetch list of articles by status
     *
     * @param $status identifier for status
     * @return array list of Blog_Model_Article
     */
    public function fetchListByStatus($status)
    {
        $cacheId = 'blog_article_status_' . $status;
        
        if (!$list = $this->getCache()->load($cacheId)) {
            $select = $this->getTable()->select();
            $select->where('article_status = ?', $status);
            $select->order('article_date DESC');
            
            $rows = $this->getTable()->fetchAll($select);
            
            $list = array();
            
            foreach ($rows as $row) {
                $model = $this->getModel($row);
                
                $list[] = $model;
            }
            
            $this->getCache()->save($list, $cacheId, array('blog_article'));
        }
            
        return $list;
    }
    
    /**
     * Prepare the url
     *
     * @param array $data form data article to be saved
     * @return string new checked url
     */
    protected function _prepareUrl($text)
    {
        // get url
        $url = Zend_Filter::filterStatic($text, 'StringToUrl');
        
        // build select to catch similar urls
        $select = $this->getTable()->select();
        $select->where('article_url LIKE ?', $url . '%');
        $select->order('article_id DESC');
        
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
            $foundUrls[] = $row['article_url'];
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
     * Create new article
     *
     * @param array $data form data article to be saved
     * @return integer new primary key
     */
    public function create(array $data)
    {
        // set input data
        $inputData = array(
            'article_date'     => date('Y-m-d H:i:s'),
            'article_status'   => 'new',
            'article_user'     => $data['article_user'    ],
            'article_category' => $data['article_category'],
            'article_title'    => $data['article_title'   ],
            'article_teaser'   => $data['article_teaser'  ],
            'article_text'     => $data['article_text'    ],
            'article_url'      => $this->_prepareUrl($data['article_title']),
            'article_count'    => 0,
        );
    
        // save to database
        $row = $this->getTable()->createRow($inputData);
        $row->save();
    
        // clear cache for article
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_article'));
    
        return $row->article_id;
    }
    
    /**
     * Update existing article
     *
     * @param integer $id article id
     * @param array $data input data
     * @return void
     */
    public function update($id, array $data)
    {
        // set input data
        $inputData = array(
            'article_category' => $data['article_category'],
            'article_title'    => $data['article_title'   ],
            'article_teaser'   => $data['article_teaser'  ],
            'article_text'     => $data['article_text'    ],
        );
    
        // check for article status
        if (!empty($data['article_status']))
        {
            $inputData['article_status'] = $data['article_status'];
        }
    
        // check for status
        if (empty($data['article_status']) || $inputData['article_status'] != 'approved')
        {
            $inputData['article_date'] = date('Y-m-d H:i:s');
        }
    
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->setFromArray($inputData);
        $row->save();
    
        // clear cache for article
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_article'));
    }
    
    /**
     * Delete existing article
     *
     * @param integer $id article id
     * @return void
     */
    public function delete($id)
    {
        // save to database
        $row = $this->getTable()->find($id)->current();
        $row->delete();
    
        // clear cache for article
        $this->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('blog_article'));
    }
    
    
}
