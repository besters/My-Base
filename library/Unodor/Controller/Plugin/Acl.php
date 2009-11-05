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

			$acl->addRole(new Zend_Acl_Role($identity->email));
			
			$aclModel = new Model_Acl();
	
			$perms = $aclModel->getUserPerms($identity->email, 7);
			
			//$access = self::VIEW + self::ADD + self::EDIT + self::DELETE;
			
			//$perms = array('index' => $access, 'project' => $access, 'people' => 0);
			
			foreach($perms as $val => $key){
				$acl->add(new Zend_Acl_Resource($val));
				$this->_resources[] = $val;
			}					
				
			foreach($perms as $val => $key){
				if($key & self::VIEW){
					$acl->allow($identity->email, $val, 'index');
				}
				if($key & self::ADD){
					$acl->allow($identity->email, $val, 'add');
				}
				if($key & self::EDIT){
					$acl->allow($identity->email, $val, 'edit');
				}
				if($key & self::DELETE){
					$acl->allow($identity->email, $val, 'delete');
				}			
			}
				
			Zend_Registry::set('acl', $acl);
			
			if (in_array($request->getControllerName(), $this->_resources)) {
				             
				$isAllowed = $acl->isAllowed($identity->email, $request->getControllerName(), $request->getActionName());
								
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
