<?php
class Mybase_ProjectController extends Unodor_Controller_Action
{
	public function indexAction()
	{
		$model = new Model_Project();
		
		$result = $model->getProjectsList();
		
		$this->view->project = $result;
	}	
}