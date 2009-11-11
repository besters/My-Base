<?php
class Unodor_Translate extends Zend_Translate
{  
    public function __contruct($string){
    	$translate =  new Zend_Translate('gettext', LANGUAGES_PATH.'/LC_MESSAGES/en/default.mo' , 'en'); 
    	$translate->setLocale('en');
    	Zend_Registry::set('Zend_Translate' , $translate);
    	$this->translate = $translate ;
    	$this->newTranslate($string) ;
    	
    }
    
    public function newTranslate($string){
    	$my_translate = $this->translate($string); 
    	
    	return $my_translate ;
    }
	
	
}
	