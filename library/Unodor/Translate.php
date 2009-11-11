<?php
  /** 
     * 
     * Třída pro nastavení jazykového rozhraní
     *
     */

class Unodor_Translate extends Zend_Translate
{  
  /**
     *
     * Aktivuje Zendovskou třídu
     *
     */


    public function Translate($string){
    	
		$load_translate = self::_translate($string) ;
    	
		return $load_translate ; 
    }
    
}
	