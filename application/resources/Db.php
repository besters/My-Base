<?php

class Resource_Db extends Zend_Application_Resource_ResourceAbstract{

    protected $_adapter = null;

    protected $_db;
    
    protected $_params = array();
    
    protected $_isDefaultTableAdapter = true; 
    
    protected $_cache;
    
    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->_params;
    }
    
    public function setIsDefaultTableAdapter($isDefaultTableAdapter)
    {
        $this->_isDefaultTableAdapter = $isDefaultTableAdapter;
        return $this;
    }

    public function isDefaultTableAdapter()
    {
        return $this->_isDefaultTableAdapter;
    }

    public function getDbAdapter()
    {
        if ((null === $this->_db) 
            && (null !== ($adapter = $this->getAdapter()))
        ) {
            $this->_db = Zend_Db::factory($adapter, $this->getParams());
        }
        return $this->_db;
    }
    
    public function setCache(){
        $frontendOptions = array(
            'automatic_serialization' => true
        );

        $backendOptions  = array(
            'cache_dir' =>  './cache'
        );

        $this->_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);

        Zend_Db_Table_Abstract::setDefaultMetadataCache($this->_cache); 
        return $this->_cache;
    }
    
    public function getCacheBackend(){
        return $this->_cache->getBackend();    
    }
    
    public function init()
    {
        if (null !== ($db = $this->getDbAdapter())) {
            if ($this->isDefaultTableAdapter()) {
                Zend_Db_Table::setDefaultAdapter($db);
            }
            $this->setCache();
            return $db;
        }
    }
}
