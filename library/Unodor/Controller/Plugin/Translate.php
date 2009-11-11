<?php

/**
 * Translate Controller plugin
 *
 */
class Unodor_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{
		/**
		 * 
		 *  @file /library/Unodor/Translate.php
		 *  @param string
		 * 	@return string
		 * 
		 */	
	 public $string ;
	 public $load_class_translate ;
	 
   public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	
    	$language = 'de';
    	
    	$load_class =  
    	new Zend_Translate(
    						'gettext', 
    						LANGUAGES_PATH.'/'.$language.'.mo' ,
    						 $language
    					   ); 
    					   
    	$load_class->setLocale($language);
    	
		Zend_Registry::set('Zend_Translate' , $load_class);
		
  
         return $load_class ; 
    }
		
}
