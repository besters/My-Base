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
    	
    	 $myOptions = array(
            'plugin_online' => true 
        );
    	
        
         $frontendOptions = array(
            'automatic_serialization' => true 
        );

        $backendOptions  = array(
            'cache_dir' =>  './cache'
        );
           	
    	$cache = Zend_Cache::factory('Core',
    	                             'File',                             
    								 $frontendOptions,                             
    								 $backendOptions);
    								 
    	Zend_Translate::setCache($cache);
    	   	
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
			    	
			    	self::removeDuplicatelines(LANGUAGES_PATH.'/log/log.phtml' , $myOptions);
			    	

	    	
   
		Zend_Registry::set('Zend_Translate' , $translate);		
    }
    
    private function removeDuplicatelines($file , $options){
    			if($options['plugin_online'] == true ){
						$text = array_unique(file($file));

						$repair = @fopen(
								$file,
								'w+'
								);
						
								if($repair){
									fputs($repair , join('' , $text));
									fclose($repair) ;
								}
    			}else{
    			 return false ;
    			}
    }
}
