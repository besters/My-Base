<?php
class Unodor_Controller_Plugin_Menu extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole('member');
		Zend_Registry::set('Zend_Navigation', $this->_mybaseDefaultMenu());
		$front = Zend_Controller_Front::getInstance();
		$router = $front->getRouter();
		
		//Zend_Debug::dump($router);
	}
	
	private function _mybaseDefaultMenu()
	{
		$container = new Zend_Navigation(array(
			array(                
				'label' => 'Nástěnka',    
				'module' => 'mybase',            
				'controller' => 'index',
				'action' => 'index',				
				'params' => array(
					'account' => 'unodor'
					)
			),
			array(                
				'label' => 'Projekty',                
				'controller' => 'project',
				'action' => 'index',
				'module' => 'mybase',
				'params' => array(
					'account' => 'unodor'
					)
			),
			array(                
				'label' => 'Přiřazení',                
				'controller' => 'assignment',
				'action' => 'index',
				'module' => 'mybase',
				'params' => array(
					'account' => 'unodor'
					)
			),
			array(                
				'label' => 'Kalendář',                
				'controller' => 'calendar',
				'action' => 'index',
				'module' => 'mybase',
				'params' => array(
					'account' => 'unodor'
					)
			),
			array(                
				'label' => 'Lidé',                
				'controller' => 'people',
				'action' => 'index',
				'module' => 'mybase',
				'params' => array(
					'account' => 'unodor'
					)
			),
			array(                
				'label' => 'Účet',                
				'controller' => 'account',
				'action' => 'index',
				'module' => 'mybase',
				'params' => array(
					'account' => 'unodor'
					)
			)															
		));
		
		return $container;
	}
}
