<?php

/**
 * Zjistuje Request parametr
 * 
 * View helper pro zjisteni parametru URL, napr. controller, action, module, a jine.
 * 
 */
class Unodor_View_Helper_Param extends Zend_View_Helper_Abstract  
{
	/**
	 * Zjistuje parametr
	 *
	 * @param string $name parametr
	 * @return string
	 */	
    public function param($name)
    {  
        return Zend_Controller_Front::getInstance()->getRequest()->getParam($name);
    }  
}