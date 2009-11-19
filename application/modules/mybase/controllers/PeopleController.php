<?php
class Mybase_PeopleController extends Unodor_Controller_Action
{
	public function init()
	{
		$this->_model = new Model_Acl();
	}
	
	public function indexAction()
	{

	}	
	
	public function overviewAction()
	{
		$users = $this->_model->getUsers($this->_request->getParam('projekt'));
		
		$this->view->userList = $users;
	}
}