<?php

/** 
 * Načítá Translate parametr
 * 
 * View helper pro nacteni parametru translate("string") 
 */
class Unodor_View_Helper_Translate extends Zend_View_Helper_Abstract  
{
	/**
	 * Nacte parametr
	 *
	 * @param string $word parametr
	 * @return string
	 */	
   public function translate($word)
   {   		
   	    $registry = Zend_Registry::get('Zend_Translate');   		 		
        return $registry->translate($word);
   }     
}