<?php
class Mybase_ProjectController extends Unodor_Controller_Action
{
	public function indexAction()
	{
		$model = new Model_Project();
		
		$result = $model->getProjectsList();
		
		$this->view->project = $result;
	}

	public function newAction()
	{
		$this->_form = new Mybase_Form_Project();
		$this->view->form = $this->_form;
	}
}