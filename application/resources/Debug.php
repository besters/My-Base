<?php

/**
 * Application Resource ktera nastavuje ZFDebug plugin
 * 
 */
class Resource_Debug extends Zend_Application_Resource_ResourceAbstract
{
   /**
    * @var boolean
    */
   protected $_init = false;
   /**
    * @var boolean
    */
   protected $_enabled = false;
   /**
    * @var array
    */
   protected $_params = array();

   /**
    * Nastavuje plugin options
    *
    * @param array $params
    */
   public function setParams(array $params)
   {
      $this->_params = $params;
   }

   /**
    * Vraci plugin options
    *
    * @return array
    */
   public function getParams()
   {
      return $this->_params;
   }

   /**
    * Aktivuje plugin
    *
    * @param boolean $enabled
    */
   public function setEnabled($enabled)
   {
      $this->_enabled = (boolean)$enabled;
   }

   /**
    * Vraci True pokud je plugin povolen
    *
    * @return boolean
    */
   public function getEnabled()
   {
      return $this->_enabled;
   }

   /**
    * Defined by Zend_Application_Resource_Resource
    *
    */
   public function init()
   {
      $this->initDebugPlugin();
   }

   /**
    * Initialize ZFDebug plugin
    *
    */
   public function initDebugPlugin()
   {
      if(!$this->_init && $this->getEnabled()){

         $this->_init = true;

         $options = $this->getParams();

         if(isset($options['plugins']['Database'])){
            if($this->getBootstrap()->hasPluginResource('db')){
               $this->getBootstrap()->bootstrap('db');
            }
         }

         if(isset($options['plugins']['Cache'])){
            if($this->getBootstrap()->hasPluginResource('cache')){
               $cache = $this->getBootstrap()->bootstrap('cache');
               $options['plugins']['Cache']['backend'] = $cache->getbackend();
            }else{
               $options['plugins']['Cache']['backend'] = '';
            }
         }

         if(isset($options['ladenka']) AND $options['ladenka'] == true){
            require_once 'Nette/Debug.php';
            Debug::enable();
         }

         if(isset($options['plugins']['File']['base_path'])){
            $options['plugins']['File']['base_path'] = realpath($options['plugins']['File']['base_path']);
         }

         $autoloader = Zend_Loader_Autoloader::getInstance();
         $autoloader->registerNamespace('ZFDebug_');

         $this->getBootstrap()->bootstrap('frontController');

         $debug = new ZFDebug_Controller_Plugin_Debug($options);

         $frontController = $this->getBootstrap()->getResource('frontController');
         $frontController->registerPlugin($debug);
      }
   }

}
