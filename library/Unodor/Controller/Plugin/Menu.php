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
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultAcl($acl);
		//Zend_View_Helper_Navigation_HelperAbstract::setDefaultRole('member');
		
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
				'pages' => array(
					array(                
						'label' => 'Přehled',    
						'module' => 'mybase',            
						'controller' => 'index',
						'action' => 'overview',	
						'route' => 'mybase-projekt',			
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
						'label' => 'Discuss',                
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
						'label' => 'Files',                
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
						'label' => 'Time',                
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
						'label' => 'Calendar',                
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
						'label' => 'Settings',                
						'controller' => 'settings',
						'action' => 'index',
						'module' => 'mybase',
						'route' => 'mybase-projekt',
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
						'visible' => false,		
						'params' => array(
							'account' => $this->_account
							)
					)
				),
				'params' => array(
					'account' => $this->_account
					)
			),
			array(                
				'label' => 'Assignmets',                
				'controller' => 'assignment',
				'action' => 'index',
				'module' => 'mybase',
				'route' => 'mybase-default',
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
				'params' => array(
					'account' => $this->_account
					)
			)															
		));		
		return $container;
	}
}
