<?php

/**
 * Nastavuje layout podle modulu
 *
 */
class Unodor_Layout_Module extends Zend_Layout_Controller_Plugin_Layout
{

   /**
    * Mneni layout podle aktualniho modulu
    *
    * @param Zend_Controller_Request_Abstract $request
    */
   public function preDispatch(Zend_Controller_Request_Abstract $request)
   {
      $moduleName = $request->getModuleName();
      switch($moduleName){
         case $moduleName:
            $this->_moduleChange($moduleName);
            break;
      }
   }

   /**
    * Nastavuje layout
    *
    * @param string $moduleName Nazev modulu
    */
   protected function _moduleChange($moduleName)
   {
      $this->getLayout()->setLayout($moduleName);
   }

}

