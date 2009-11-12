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
		 * @author Filip Procházka
		 */
	
	private  $language ; 
		
   	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{    	
	
		
    	$language = 'de';
    	
    	/**
    	 * @desc Základní třída pro použití překladu.
    	 * @param string $language  parametr(lang)
    	 * @todo upgrade Cache (později)
    	 */
    	
    	$translate = new Zend_Translate(
	    					'gettext', 
	    					LANGUAGES_PATH.'/'.$language.'.mo' ,
	    					$language
    					); 

    	/**
    	 * @desc Cesta k logu
    	 */
    									
    	$writer = new Zend_Log_Writer_Stream(LANGUAGES_PATH.'/log/log.phtml');
    	
    	/**
    	 * @desc Nastavení vlastního formátoru "logu"
    	 */
    	
		$formatter = new Zend_Log_Formatter_Simple('%message%' . PHP_EOL);
		$writer->setFormatter($formatter);
		
		/**
		 * @desc identifikace předem nadefinovaných :
		 * @param formatter 
		 *        writer 
		 */
		$logger = new Zend_Log();
		$logger->addWriter($writer);
		
		/**
		 * @desc Nastavení Výstupu do logu
		 */
		
		$translate->setOptions(array(
		    'log'             => $logger,
		    'logMessage'      => 
		    "$"."this->translate('%message%');".
		    "$"."this->language('%locale%');",
		    'logUntranslated' => true));

		
		/**
		  * 
		  * @desc Nastavení jazyků
		  * @param string $language parametr(en,cz,de...)
		  * 
		  */
    	$translate->setLocale($language);
    
    	/**
    	 * 
    	 * @desc Registrace Zendovské třídy : Zend_Translate
    	 * @param class $translate parametr ( class Zend_Translate )
    	 */
		Zend_Registry::set('Zend_Translate' , $translate);		
  		
		
		/**
		 * 
		 * @desc Vrací překlad 
		 * @param string $translate  param přeložený text
		 * 
		 */
         return $translate ; 
    }
}
