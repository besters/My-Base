<?php
class Mybase_ProjectController extends Unodor_Controller_Action
{
	
	public function init()
	{
		$this->_model = new Model_Project();
	}
	
	public function indexAction()
	{	
		$result = $this->_model->getProjectsList();
		
		$this->view->project = $result;
	}

	public function newAction()
	{
		$this->_form = new Mybase_Form_Project();
		
		$this->view->form = $this->_form;

		$formData = $this->getRequest()->getPost();
		
		if($this->getRequest()->isPost()){
			if($this->_form->isValid($formData)){
				$lastInsertId = $this->_model->save($this->_form->getValues());
				$this->_flash('New project has been successfully created', 'done');
				return $this->_redirect('/'.$lastInsertId.'/people');
			}else{
				$this->_flash('Formulář není vyplněn správně', 'error', false);
				$this->_form->populate($formData);
			}
		}		
	}
}