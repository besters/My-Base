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
	private $_resources = array('index', 'project', 'assignment', 'calendar', 'people', 'account', 'auth');
	
	/**
	 * Pole s povolenymy action pro cteni
	 * 
	 * @var array
	 */
	private $_read = array('index', 'overview');
	
	/**
	 * Pole s povolenymy action pro vytvareni novych zaznamu
	 * 
	 * @var array
	 */	
	private $_create = array('new');
	
	/**
	 * Pole s povolenymy action pro editaci a mazani
	 * 
	 * @var array
	 */	
	private $_manage = array('edit', 'delete');
	
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

			$acl->addRole(new Zend_Acl_Role('user'))
				->addRole(new Zend_Acl_Role('owner'))
				->addRole(new Zend_Acl_Role('admin'), 'owner');

			if($identity->owner == true)
				$inherit = 'owner';
			elseif($identity->administrator == true)
				$inherit = 'admin';
			else
				$inherit = 'user';			
			
			$acl->addRole(new Zend_Acl_Role($identity->email), $inherit);	
					
			$projekt = $request->getParam('projekt');			
			
			// Zakladni resource
			foreach($this->_resources as $val => $key){
				$acl->add(new Zend_Acl_Resource($key));
			}
			
			// Prava pro zakladni resource
			$acl->allow('owner');			
			$acl->deny('admin', 'account');			
			
			$acl->allow('user', array('index', 'project', 'assignment', 'calendar', 'people', 'auth'));
			$acl->deny('user', 'account');	
			$acl->deny('user', 'project', $this->_create);
			$acl->deny('user', 'people', $this->_create);
			$acl->deny('user', 'project', $this->_manage);
			$acl->deny('user', 'people', $this->_manage);
			
			// Resource pro projektovou podsekci		
			$this->_projectAcl($acl, $identity);				

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
	 * Nastavuje opravneni pro podsekci projektu
	 * 
	 * @param Zend_Acl $acl ACL objekt
	 * @param Zend_Auth_Storage_Session $identity Objekt s identitou
	 */
	private function _projectAcl($acl, $identity)
	{	
		$aclModel = new Model_Acl();
			
		$dbData = $aclModel->getAllPerms($identity->email);		
		
		foreach($dbData as $aclData)
		{
			$perms = unserialize($aclData->permission);
			foreach($perms as $resource => $perm)
			{	
				$acl->add(new Zend_Acl_Resource($aclData->idproject.'|'.$resource));
							
				if($perm & self::READ){
					$acl->allow($identity->email, $aclData->idproject.'|'.$resource, $this->_read);
				}
				if($perm & self::CREATE){
					$acl->allow($identity->email, $aclData->idproject.'|'.$resource, $this->_create);
				}
				if($perm & self::MANAGE){
					$acl->allow($identity->email, $aclData->idproject.'|'.$resource, $this->_manage);
				}
								
				$this->_resources[] = $aclData->idproject.'|'.$resource;
			}
		}			
	}	
}
