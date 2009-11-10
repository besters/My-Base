<?php

/**
 * Application Resource ktera nastavuje DB
 * 
 */
class Resource_Db extends Zend_Application_Resource_ResourceAbstract{
	
	/**
	 * 
	 * @var string
	 */
    protected $_adapter = null;

    /**
     * 
     * @var Zend_Db
     */
    protected $_db;
    
    /**
     * 
     * @var array
     */
    protected $_params = array();
    
    /**
     * 
     * @var bool
     */
    protected $_isDefaultTableAdapter = true; 
    
    /**
     * 
     * @var Zend_Cache
     */
    protected $_cache;
    
    /**
     * Nastavuje databazovy adapter
     * 
     * @param string $adapter Adapter
     */
    public function setAdapter($adapter)
    {
        $this->_adapter = $adapter;
        return $this;
    }

    /**
     * Vraci nazev db adapteru
     * 
     * @return string Adapter
     */
    public function getAdapter()
    {
        return $this->_adapter;
    }

    /**
     * Nastavuje parametry
     * 
     * @param $params
     */
    public function setParams(array $params)
    {
        $this->_params = $params;
        return $this;
    }

    /**
     * Vraci parametry
     * 
     * @return string
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * Nastavuje jestli je to vychozi adapter nebo ne
     * 
     * @param bool $isDefaultTableAdapter
     */
    public function setIsDefaultTableAdapter($isDefaultTableAdapter)
    {
        $this->_isDefaultTableAdapter = $isDefaultTableAdapter;
        return $this;
    }

    /**
     * Zjistuje nastaveni parametru DefaultAdapter
     * 
     * @return bool
     */
    public function isDefaultTableAdapter()
    {
        return $this->_isDefaultTableAdapter;
    }

    /**
     * Vraci DB adapter
     * 
     * @return Zend_Db
     */
    public function getDbAdapter()
    {
        if ((null === $this->_db) 
            && (null !== ($adapter = $this->getAdapter()))
        ) {
            $this->_db = Zend_Db::factory($adapter, $this->getParams());
        }
        return $this->_db;
    }
    
    /**
     * Nastavuje metadata cache
     * 
     * @return Zend_Cache
     */
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
    
    /**
     * Vraci nazev backendu cache
     * 
     * @return string Backend
     */
    public function getCacheBackend(){
        return $this->_cache->getBackend();    
    }
    
     /**
     * Defined by Zend_Application_Resource_Resource
     * 
     */
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
