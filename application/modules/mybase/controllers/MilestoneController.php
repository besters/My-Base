<?php
class Mybase_MilestoneController extends Unodor_Controller_Action
{	
	public function init()
	{
		parent::init();
		$this->_model = new Model_Milestone();
	}
	
	public function indexAction()
	{
			
	}
	
	public function newAction()
	{
		$this->_form = new Mybase_Form_Milestone();
		
		$this->view->form = $this->_form;
		
		$formData = $this->getRequest()->getPost();

		if($this->_request->isPost()){
			if($this->_form->isValid($formData)){
				$idmilestone = $this->_model->save($formData);

				$mu = new Model_MilestoneUser();
				$mu->saveUsers($formData['users'], $idmilestone);				
				
				$this->_flash('New milestone has been successfully created', 'done', true);
				return $this->_redirect($this->_project.'/milestone');
			}else{
				$this->_flash('Formulář není vyplněn správně', 'error', false);
				$this->_form->populate($formData);
			}
		}
	}
}