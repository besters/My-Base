<?php

class Resource_Debug extends Zend_Application_Resource_ResourceAbstract{
    
    public function init()
	{
		$this->ladenka();
        $this->bar();
    }
    
    public function bar()
	{
        $front = $this->getBootstrap()->getResource('FrontController');
        $options = $this->getOptions();
        if($options['bar'] == true){      
            $resource = $this->getBootstrap()->getPluginResource('db');
            $settings = array(
                 'plugins' => array('Variables', 
                                    'Database' => array('adapter' => array('standard' => $resource->getDbAdapter())), 
                                    'File' => array('base_path' => APP_PATH, 'library' => 'Unodor'),
                                    'Memory', 
                                    'Time', 
                                    'Registry', 
                                    //'Auth',
                                    'Cache' => array('backend' => array('memcache' => $resource->getCacheBackend())), 
                                    'Exception',
                                    'Html'
                                    )
             );
             $zfdebug = new ZFDebug_Controller_Plugin_Debug($settings);
             $front->registerPlugin($zfdebug);            
        }
    }   
	
	public function ladenka()
	{
		$options = $this->getOptions();
		if(isset($options['ladenka']) AND $options['ladenka']  == true){
	    	require_once 'Nette/Debug.php';
			Debug::enable();			
		}
	}
}