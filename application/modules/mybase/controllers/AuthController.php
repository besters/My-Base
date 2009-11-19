<?php
class Mybase_AuthController extends Unodor_Controller_Action{
	
	protected $_flashMessenger;
	protected $_form;
	
	public function init(){
		$this->_redirector = $this->_helper->getHelper('Redirector');
	}
	
    public function loginAction(){
    	$this->_form = new Mybase_Form_Login();

        if (!$this->getRequest()->isPost()) {
        	$this->view->form = $this->_form;
        }else{        
	        $form = $this->_form;	        
	        if (!$form->isValid($_POST)) {
	            $this->view->form = $form;	   
				$this->_flash('Všechna pole musí být vyplněna', 'error', false);
	        }else{
	        	$values = $form->getValues();
		        $auth = Zend_Auth::getInstance();    
				$modelAccount = new Model_Account();
				$idaccount = $modelAccount->getId($this->_request->account);            
		        $authAdapter = new Zend_Auth_Adapter_DbTable(
		            Zend_Db_Table_Abstract::getDefaultAdapter(),
		            'user',
		            'email',
		            'password',
		            'MD5(?) AND idaccount = '.$idaccount
		        );
		        $authAdapter->setIdentity($values['email']);
		        $authAdapter->setCredential($values['password']);
		        $result = $auth->authenticate($authAdapter);
		        
		        switch ($result->getCode()) {

				    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
	            		$this->view->form = $form;	
						$this->_flash('Špatné uživatelské jméno', 'error', false);
				        break;
				
				    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
    					$this->view->form = $form;	
						$this->_flash('Špatné heslo', 'error', false);
				        break;
				
				    case Zend_Auth_Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(array('iduser', 'email', 'name', 'surname', 'owner', 'administrator')));
						if($form->getValue('remember') == 1) Zend_Session::rememberMe(60*60*24*14);
				        $this->_redirect('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
				        break;
										
				    case Zend_Auth_Result::FAILURE:
	            		$this->view->form = $form;	
						$this->_flash('Neznámá chyba (FAILURE)', 'error', false);
				        break;
				
				    case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
			            $this->view->form = $form;	
						$this->_flash('"Nejednoznačné"', 'error', false);
				        break;
				        
				    case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
        				$this->view->form = $form;	
						$this->_flash('Neznámá chyba(FAILURE_UNCATEGORIZED)', 'error', false);
				        break;
																
				    default:
	            		$this->view->form = $form;	
						$this->_flash('Neznámá chyba (default)', 'error', false);
				        break;
				}
			}
		} 
		$this->_helper->layout->disableLayout();
    }
    
	public function logoutAction(){
		Zend_Auth::getInstance()->clearIdentity();
		return $this->_redirect('index');
	}
        
	
	public function aclAction()
	{
		$this->view->errMsg = 'Přístup zamítnut - Nedostatečné oprávnění';
	}
}