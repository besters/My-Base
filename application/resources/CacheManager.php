<?php

class Resource_CacheManager extends Zend_Application_Resource_ResourceAbstract
{
   protected $_manager = null;

   private function setDatabase()
   {
      $dbCache = array(
          'frontend' => array(
              'name' => 'Core',
              'options' => array(
                  'automatic_serialization' => true
              )
          ),
          'backend' => array(
              'name' => 'File',
              'options' => array(
                  'cache_dir' => './cache/db'
              )
          )
      );
      return $dbCache;
   }

   private function setTranslate()
   {
      $dbTranslate = array(
          'frontend' => array(
              'name' => 'Core',
              'options' => array(
                  'automatic_serialization' => true
              )
          ),
          'backend' => array(
              'name' => 'File',
              'options' => array(
                  'cache_dir' => './cache/translate'
              )
          )
      );
      return $dbTranslate;
   }

   public function getCacheManager()
   {
      if(null === $this->_manager){
         $this->_manager = new Unodor_Cache_Manager;

         $this->_manager->setCacheTemplate('database', $this->setDatabase());
         $this->_manager->setCacheTemplate('translate', $this->setTranslate());
      }      

      return $this->_manager;
   }

   public function getCacheTemplates()
   {
      return 'templates';
   }

   public function init()
   {
      $cache = $this->getCacheManager();
      Zend_Registry::set('cache', $cache);
      
      return $cache;
   }

}

