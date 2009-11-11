<?php

/**
 * Translate Controller plugin
 * 
 */
class Unodor_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{	 
   	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{    	
    	$language = 'de';
    	
    	$translate = new Zend_Translate(
	    					'gettext', 
	    					LANGUAGES_PATH.'/'.$language.'.mo' ,
	    					$language
    					); 
    					   
    	$translate->setLocale($language);
    	
		Zend_Registry::set('Zend_Translate' , $translate);		
  
         return $translate ; 
    }
}
