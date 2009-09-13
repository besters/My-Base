<?php 
class Unodor_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract 
{
    private $_noauth = array('module'=>'mybase', 'controller'=>'auth', 'action'=>'login');
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{    
        $auth = Zend_Auth::getInstance();
        
        $controller = $request->controller;
        $action = $request->action;
        $module = $request->module;
        
		$account = new Model_Account();
		
		if($account->isValidUrl($request->getParam('account'))){
	        if (!$auth->hasIdentity()) {
	            $module = $this->_noauth['module'];
	            $controller = $this->_noauth['controller'];
	            $action = $this->_noauth['action'];
	        }			
		}else{
			throw new Zend_Controller_Dispatcher_Exception('Tohle musím ještě doladit, řádek 23 soubor Unodor_Controller_Plugin_Auth');
		}

        
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }
}