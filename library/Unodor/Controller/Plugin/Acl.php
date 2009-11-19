<?php

/**
 * Access Control List controller plugin
 *
 */
class Unodor_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	const DENIED = 0;
	const READ = 1;
	const CREATE = 2;
	const MANAGE = 4;
	
	/**
	 * Vychozi modul, controller a action pri zamitnutem pristupu
	 * 
	 * @var array
	 */
	private $_noacl = array('module'=>'mybase', 'controller'=>'auth', 'action'=>'acl');
	
	/**
	 * Resources - controllery
	 * 
	 * @var array
	 */
	private $_resources = array();
	
    /**
     * Hlavni logika ACL 
     * 
     * @param $request
     */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{		
		$controller = $request->controller;
        $action = $request->action;
        $module = $request->module;	
		
		$auth = Zend_Auth::getInstance();
		
		if($auth->hasIdentity())
		{			
			$acl = new Zend_Acl();
			
			$identity = $auth->getIdentity();

			$acl->addRole(new Zend_Acl_Role($identity->email));
			
			$aclModel = new Model_Acl();
			
			$projekt = $request->getParam('projekt');			
				
			$perms = $aclModel->getUserPerms($identity->email, $projekt);
			
			if($projekt > 0)
				$this->_projectAcl($acl, $identity, $perms, $projekt);
						
			$this->_globalAcl($acl, $identity, $perms);
				
			Zend_Registry::set('acl', $acl);
					
			if (in_array($projekt.'|'.$request->getControllerName(), $this->_resources)) {		
				$isAllowed = $acl->isAllowed($identity->email, $projekt.'|'.$request->getControllerName(), $request->getActionName());								
			}elseif(in_array($request->getControllerName(), $this->_resources)){
				$isAllowed = $acl->isAllowed($identity->email, $request->getControllerName(), $request->getActionName());
			}else{
				$isAllowed = false;
			}
			
			if (!$isAllowed) {
				$module = $this->_noacl['module'];
				$controller = $this->_noacl['controller'];
				$action = $this->_noacl['action'];
			}
									
			$request->setModuleName($module);
			$request->setControllerName($controller);
			$request->setActionName($action);		
		}
	}
	
	/**
	 * Nastavuje globalni opravneni
	 * 
	 * @param Zend_Acl $acl ACL objekt
	 * @param Zend_Auth_Storage_Session $identity Objekt s identitou
	 * @param array $perms Opravneni
	 */
	private function _globalAcl($acl, $identity, $perms)
	{			
		foreach($perms['global'] as $val => $key){
			$acl->add(new Zend_Acl_Resource($val));
			$this->_resources[] = $val;
		}	
							
		foreach($perms['global'] as $val => $key){
			if($key & self::READ){
				$acl->allow($identity->email, $val, 'index');
				$acl->allow($identity->email, $val, 'detail');
			}
			if($key & self::CREATE){
				$acl->allow($identity->email, $val, 'new');
			}
			if($key & self::MANAGE){
				$acl->allow($identity->email, $val, 'edit');
				$acl->allow($identity->email, $val, 'delete');
			}			
		}
	}
	
	/**
	 * Nastavuje opravneni pro podsekci projektu
	 * 
	 * @param Zend_Acl $acl ACL objekt
	 * @param Zend_Auth_Storage_Session $identity Objekt s identitou
	 * @param array $perms Opravneni
	 * @param int $projekt ID projektu
	 */
	private function _projectAcl($acl, $identity, $perms, $projekt)
	{			
		foreach($perms['project'] as $val => $key){
			$acl->add(new Zend_Acl_Resource($projekt.'|'.$val));
			$this->_resources[] = $projekt.'|'.$val;
		}	
							
		foreach($perms['project'] as $val => $key){
			if($key & self::READ){
				$acl->allow($identity->email, $projekt.'|'.$val, 'index');
				$acl->allow($identity->email, $projekt.'|'.$val, 'overview');
			}
			if($key & self::CREATE){
				$acl->allow($identity->email, $projekt.'|'.$val, 'new');
			}
			if($key & self::MANAGE){
				$acl->allow($identity->email, $projekt.'|'.$val, 'edit');
				$acl->allow($identity->email, $projekt.'|'.$val, 'delete');
			}			
		}		
	}
}
