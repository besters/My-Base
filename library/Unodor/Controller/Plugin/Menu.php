<?php
class Unodor_Controller_Plugin_Menu extends Zend_Controller_Plugin_Abstract
{
	protected $_project;
	protected $_account;
	
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole('member');
		
		$this->_project = $request->getParam('projekt');
		$this->_account = $request->getParam('account');

		switch($request->module){
			case 'mybase' :
				if($this->_project == 0)				
					Zend_Registry::set('Zend_Navigation', $this->_mybaseDefaultMenu());
				else
					Zend_Registry::set('Zend_Navigation', $this->_mybaseProjectMenu());	
				break;
			default :
				Zend_Registry::set('Zend_Navigation', $this->_DefaultMenu());
				break;
		}
	}
	
	private function _mybaseDefaultMenu()
	{
		$container = new Zend_Navigation(array(
			array(                
				'label' => 'Nástěnka',    
				'module' => 'mybase',            
				'controller' => 'index',
				'action' => 'index',	
				'route' => 'mybase-default',			
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Projekty',                
				'controller' => 'project',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Přiřazení',                
				'controller' => 'assignment',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Kalendář',                
				'controller' => 'calendar',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Lidé',                
				'controller' => 'people',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Účet',                
				'controller' => 'account',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'params' => array(
					'account' => $this->_account
					)
			)															
		));
		
		return $container;
	}
	
	private function _mybaseProjectMenu()
	{
		
		$container = new Zend_Navigation(array(
			array(                
				'label' => 'Přehled',    
				'module' => 'mybase',            
				'controller' => 'index',
				'action' => 'index',	
				'route' => 'mybase-projekt',			
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Milníky',                
				'controller' => 'milestone',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Tickety',                
				'controller' => 'ticket',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Checklist',                
				'controller' => 'checklist',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Wiki',                
				'controller' => 'wiki',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Diskuze',                
				'controller' => 'discussion',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Soubory',                
				'controller' => 'files',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),	
			array(                
				'label' => 'Čas',                
				'controller' => 'time',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),
			array(                
				'label' => 'Kalendář',                
				'controller' => 'calendar',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),	
			array(                
				'label' => 'Team',                
				'controller' => 'people',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			),	
			array(                
				'label' => 'Nastavení',                
				'controller' => 'settings',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
					)
			)																								
		));
		
		return $container;
	}
}
