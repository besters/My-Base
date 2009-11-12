<?php

/**
 * Translate Controller plugin
 * 
 */
class Unodor_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{	 
	/**
	 * @desc Nastavení jazyku 
	 * @todo $language(podle cookies)
	 */	
	private  $language ; 

   	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{    			
    	$language = 'de';
    	
    	/*
    	 * @todo upgrade Cache (později)
    	 */    	
    	$translate = new Zend_Translate(
	    					'gettext', 
	    					LANGUAGES_PATH.'/'.$language.'.mo' ,
	    					$language
    					); 
						
    	$writer = new Zend_Log_Writer_Stream(LANGUAGES_PATH.'/log/log.phtml');
    	
		$formatter = new Zend_Log_Formatter_Simple('%message%' . PHP_EOL);
		$writer->setFormatter($formatter);
		
		$logger = new Zend_Log();
		$logger->addWriter($writer);
		
		$translate->setOptions(array(
		    'log'             => $logger,
		    'logMessage'      => 
		    "$"."this->translate('%message%');".
		    "$"."this->language('%locale%');",
		    'logUntranslated' => true));

    	$translate->setLocale($language);
    
		Zend_Registry::set('Zend_Translate' , $translate);		
    }
}
