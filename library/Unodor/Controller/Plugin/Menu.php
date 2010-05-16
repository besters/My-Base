<?php

/**
 * Menu Controller plugin
 *
 */
class Unodor_Controller_Plugin_Menu extends Zend_Controller_Plugin_Abstract
{
   /**
    * Aktivni projekt
    *
    * @var int
    */
   protected $_project;
   /**
    * Aktivni ucet
    *
    * @var int
    */
   protected $_account;

   /**
    * Nastavuje ktere menu zobrazit a uklada do registru
    *
    * @param Zend_Controller_Request_Abstract $request
    * @todo Cachovat menu!!!
    */
   public function preDispatch(Zend_Controller_Request_Abstract $request)
   {
      $auth = Zend_Auth::getInstance();
      $identity = $auth->getIdentity();

      if($request->getParam('projekt') > 0)
         $this->_project = $request->getParam('projekt');

      $this->_account = $request->getParam('account');

      switch($request->module){
         case 'mybase' :
	    $env = isset($this->_project) ? 'sub' : 'main';
            $config = new Zend_Config_Xml(APP_PATH.'/configs/navigation.xml', $env, true);

	    foreach($config as $item){
	       $item->params->account = $this->_account;
	       if(isset($item->pages)){
		  foreach($item->pages as $page){
		     $page->params->account = $this->_account;
		     if(isset($page->params->projekt)){
			$page->params->projekt = $this->_project;
			$page->resource = $this->_project.'|'.$page->controller;
		     }
		     if(isset($page->pages)){
			foreach($page->pages as $sub){
			   $sub->params->account = $this->_account;
			   $sub->params->projekt = $this->_project;			   
			   $sub->resource = $this->_project.'|'.$sub->controller;
			}
		     }
		  }
	       }
            }

            $navigation = new Zend_Navigation($config);
            Zend_Registry::set('Zend_Navigation', $navigation);
            break;
         default :
            //Zend_Registry::set('Zend_Navigation', $this->_DefaultMenu());
            break;
      }
   }
}
