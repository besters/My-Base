<?php

/**
 * Formatuje timestamp do pozadovane podoby
 * 
 */
class Unodor_View_Helper_DateTime extends Zend_View_Helper_Abstract  
{
	/**
	 * Formatuje TimeStamp
	 *
	 * @param string $timestamp Timestamp
	 * @param string $format Format data
	 * @return string
	 */	
    public function DateTime($timestamp, $format = 'dd. MMMM YYYY')
    {  
        $date = new Zend_Date($timestamp);
        return $date->toString($format);
    }  
}