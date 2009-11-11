<?php

/**
 * Třída pro nastavení jazykového rozhraní
 *
 */
class Unodor_Translate extends Zend_Translate
{  
	/**
	 * Aktivuje Zendovskou třídu
	 * @param string $string Prekladana fraze
	 */
	public function Translate($string){    	
		$translate = self::_translate($string) ;
    	
		return $translate ; 
    }
}	