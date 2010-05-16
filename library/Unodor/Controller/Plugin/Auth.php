<?php 

/**
 * Controller Plugin pro autentifikaci
 *
 */
class Unodor_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract 
{
	/**
	 * Vychozi modul, controller a action ktere se zobrazi kdyz uzivatel neni prihlasen
	 * 
	 * @var array
	 */
    private $_noauth = array('module'=>'mybase', 'controller'=>'auth', 'action'=>'login');
    
    /**
     * Zjistuje jestli je uzivatel prihlaseny a podle toho nastavuje parametry do routy
     * 
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{    
        $auth = Zend_Auth::getInstance();
        
        $controller = $request->controller;
        $action = $request->action;
        $module = $request->module;
        
		$account = new Model_Account();
		
		if($account->isValidUrl($request->getParam('account'))){
			if($controller != 'account' AND $action != 'activation'){
	        if (!$auth->hasIdentity()) {
	            $module = $this->_noauth['module'];
	            $controller = $this->_noauth['controller'];
	            $action = $this->_noauth['action'];
	        }
			}
		}else{
			//throw new Zend_Controller_Dispatcher_Exception('Tohle musím ještě doladit (neni nastaven zadny account, nebo neexistuje)');
		}
        
        $request->setModuleName($module);
        $request->setControllerName($controller);
        $request->setActionName($action);
    }
}