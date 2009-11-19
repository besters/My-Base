<?php

/**
 * Menu Controller plugin
 *
 */
class Unodor_Controller_Plugin_Menu extends Zend_Controller_Plugin_Abstract
{
	/**
	 * Aktivni projekt
	 * 
	 * @var int
	 */
	protected $_project;
	
	/**
	 * Aktivni ucet
	 * 
	 * @var int
	 */
	protected $_account;
	
	/**
	 * Nastavuje ktere menu zobrazit a uklada do registru
	 * 
	 * @param Zend_Controller_Request_Abstract $request
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
		
		$acl = Zend_Registry::get('acl');
		
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole($identity->email);
		
		if($request->getParam('projekt') > 0)
			$this->_project = $request->getParam('projekt');
			
		$this->_account = $request->getParam('account');

		switch($request->module){
			case 'mybase' :		
				Zend_Registry::set('Zend_Navigation', $this->_mybaseDefaultMenu());
				break;
			default :
				Zend_Registry::set('Zend_Navigation', $this->_DefaultMenu());
				break;
		}
	}
	
	/**
	 * Hlavni menu aplikace
	 * 
	 * @return Zend_Navigation Menu Container 
	 */
	private function _mybaseDefaultMenu()
	{
		$container = new Zend_Navigation(array(
			array(                
				'label' => 'Dashboard',    
				'module' => 'mybase',            
				'controller' => 'index',
				'action' => 'index',	
				'route' => 'mybase-default',	
				'resource'   => 'index',	
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Projects',                
				'controller' => 'project',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'resource'   => 'project',
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
				),
				
				 'pages' => $this->_projectMenu()
			),
			array(                
				'label' => 'Assignmets',                
				'controller' => 'assignment',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'resource'   => 'assignment',
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Calendar',                
				'controller' => 'calendar',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'resource'   => 'calendar',
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'People',                
				'controller' => 'people',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'resource'   => 'people',
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Account',                
				'controller' => 'account',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
				'resource'   => 'account',
				'privilege' => 'index',	
				'params' => array(
					'account' => $this->_account
					)
			)															
		));		
		return $container;
	}
	
	private function _projectMenu()
	{
		$return = array();
		
		$container = array(
			array(                
				'label' => 'Přehled',    
				'module' => 'mybase',            
				'controller' => 'index',
				'action' => 'overview',	
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|index',	
				'privilege' => 'overview',				
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Milestones',                
				'controller' => 'milestone',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|milestone',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Tickets',                
				'controller' => 'ticket',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|ticket',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Checklists',                
				'controller' => 'checklist',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|checklist',	
				'privilege' => 'index',
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
				//'resource'   => $this->_project.'|wiki',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Discuss',                
				'controller' => 'discussion',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				//'resource'   => $this->_project.'|discussion',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Files',                
				'controller' => 'files',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				//'resource'   => $this->_project.'|files',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),	
			array(                
				'label' => 'Time',                
				'controller' => 'time',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				//'resource'   => $this->_project.'|time',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'Calendar',                
				'controller' => 'calendar',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|calendar',	
				'privilege' => 'index',
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
				'resource'   => $this->_project.'|people',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),	
			array(                
				'label' => 'Settings',                
				'controller' => 'settings',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-projekt',
				'resource'   => $this->_project.'|settings',	
				'privilege' => 'index',
				'params' => array(
					'account' => $this->_account,
					'projekt' => $this->_project
				)
			),
			array(                
				'label' => 'New',    
				'module' => 'mybase',            
				'controller' => 'project',
				'action' => 'new',	
				'route' => 'mybase-default',	
				'resource'   => $this->_project.'|project',	
				'privilege' => 'new',
				'visible' => false,		
				'params' => array(
					'account' => $this->_account
				)
			)
		);
		
		if(isset($this->_project))
			$return = $container;
		
		return $return;
	}
}
