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

         if(isset($options['ladenka']) AND $options['ladenka'] == true){
            require_once 'Nette/Debug.php';
            Debug::enable();
         }

         $plugins = array(
             'plugins' => array(
                 'Variables',
                 'File' => array('base_path' => realpath(APP_PATH . "/../"), 'library' => array('Unodor', 'Nette')),
                 'Html',
                 'Exception',
                 'Time'));

         if($this->getBootstrap()->hasPluginResource('CacheManager')){
            $manager = $this->getBootstrap()->getResource('CacheManager');

            $dbCache = $manager->getCache('database');
            $dbTranslate = $manager->getCache('translate');

            $plugins['plugins']['Cache']['backend'] = $manager->getCaches();
         }

         if($this->getBootstrap()->hasPluginResource('db')){
            $plugins['plugins']['Database']['adapter'] = array();
            //$plugins['plugins']['Database']['explain'] = true;
         }

         $plugins['plugins']['Unodor_Controller_Plugin_Debug_Plugin_Auth'] = true;

         $autoloader = Zend_Loader_Autoloader::getInstance();
         $autoloader->registerNamespace('ZFDebug_');

         $this->getBootstrap()->bootstrap('frontController');

         $debug = new ZFDebug_Controller_Plugin_Debug($plugins);

         $frontController = $this->getBootstrap()->getResource('frontController');
         $frontController->registerPlugin($debug);
      }
   }

}
