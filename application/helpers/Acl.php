<?php

/**
 * Acl view helper
 * 
 */
class Unodor_View_Helper_Acl extends Zend_View_Helper_Abstract {

	/**
	 * Zjistuje opravneni pro provedeni dane akce
	 * 
	 * @param int $resource Controller
	 * @param int $action Akce
	 * @return bool
	 */
	public function Acl($resource, $action)
	{
		$acl = Zend_Registry::get('acl');
		$auth = new Zend_Session_Namespace('Zend_Auth');		
		
		$return = $acl->isAllowed($auth->storage->email, $resource, $action);
		return $return;
	}	
}