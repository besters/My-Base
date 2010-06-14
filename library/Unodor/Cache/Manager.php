<?php

class Unodor_Cache_Manager extends Zend_Cache_Manager
{
   public function getCaches()
   {
      $return = array();
      foreach($this->_caches as $key => $val){
	 $return[$key] = $val->getBackend();
      }

      return $return;
   }
}
