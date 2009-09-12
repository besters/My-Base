<?php

class Unodor_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	const VIEW = 1;
	const ADD = 2;
	const EDIT = 4;
	const DELETE = 8;
	
	private $_noacl = array('module'=>'mybase', 'controller'=>'auth', 'action'=>'acl');
    private $_resources = array();
	
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
			
			$acl->addRole(new Zend_Acl_Role($identity));
			
			$aclModel = new Model_Acl();
	
			$perms = $aclModel->getUserPerms($identity, 7);
					
			foreach($perms as $val => $key){
				$acl->add(new Zend_Acl_Resource($val));
				$this->_resources[] = $val;
			}					
				
			foreach($perms as $val => $key){
				if($key & self::VIEW){
					$acl->allow($identity, $val, 'index');
				}
				if($key & self::ADD){
					$acl->allow($identity, $val, 'add');
				}
				if($key & self::EDIT){
					$acl->allow($identity, $val, 'edit');
				}
				if($key & self::DELETE){
					$acl->allow($identity, $val, 'delete');
				}			
			}
				
			Zend_Registry::set('acl', $acl);
			
			if (in_array($request->getControllerName(), $this->_resources)) {
				             
				$isAllowed = $acl->isAllowed($auth->getIdentity(), $request->getControllerName(), $request->getActionName());
								
				if (!$isAllowed) {
					$module = $this->_noacl['module'];
					$controller = $this->_noacl['controller'];
					$action = $this->_noacl['action'];
				}
			}
									
			$request->setModuleName($module);
			$request->setControllerName($controller);
			$request->setActionName($action);		
		}
	}
}
