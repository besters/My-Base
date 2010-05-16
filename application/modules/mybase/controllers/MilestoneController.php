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
		$milestones = $this->_model->getMilestones();	
		
		$acive = $milestones->getActive();
		$complete = $milestones->getComplete();
		$paused = $milestones->getPaused();
		$canceled = $milestones->getCanceled();
		
		$this->view->active = $acive;			
		$this->view->complete = $complete;			
		$this->view->paused = $paused;			
		$this->view->canceled = $canceled;			
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
				//$this->_flash('There is an errors in the form', 'error', false);
				$this->_form->populate($formData);
			}
		}
	}
}