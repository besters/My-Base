<?php
class Mybase_AccountController extends Unodor_Controller_Action
{
	public function indexAction()
	{
		/**
		 * @todo ./application/modules/mybase/controllers/AccountController.php
		 * 		 ./application/modules/mybase/forms/Account.php
		 * 		 ./application/models/Account.php
		 * 		 ./application/models/DbTable/Account.php
		 * 	
		 * 
		 * 
		 */
		$this->disableMvc(false, false);
		$this->_model = new Model_Account();
		$this->_form = new Mybase_Form_Account();
		$this->view->form = $this->_form;
		
		//$this->view->data = $this->_model->getTableVars();
		
	}
	

	
}