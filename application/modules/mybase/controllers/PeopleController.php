<?php
class Mybase_PeopleController extends Unodor_Controller_Action
{
	public function init()
	{
		$this->_modelAcl = new Model_Acl();
		$this->_modelUser = new Model_User();
	}
	
	public function indexAction()
	{

	}	
	
	public function overviewAction()
	{
		$users = $this->_modelAcl->getUsers($this->_request->getParam('projekt'));
		
		$this->view->userList = $users;
	}
	
	public function newAction()
	{
		$projekt = $this->_request->getParam('projekt');
		if(isset($projekt)){
			return $this->_newTeam($projekt);
		}else{
			return $this->_newPeople();
		}
	}
	
	public function editAction()
	{
		
	}
	
	public function deleteAction()
	{	
		$projekt = $this->_request->getParam('projekt');
		if(isset($projekt)){
			return $this->_deleteTeam($projekt);
		}else{
			return $this->_deletePeople();
		}		
	}
	
	private function _newTeam($projekt)
	{	
		$this->view->users = $this->_modelUser->getFreeUsers($projekt);
		$this->view->resources = $this->_modelAcl->getResources();
		
		if($this->_request->isPost()){
			if(isset($_POST['user'])){
				$acl = new Model_Acl;
				
				foreach($_POST['user'] as $iduser){
					$acl->addUserToProject($_POST['acl'], $iduser, $projekt);
				}
				
				$this->_flash('User has been successfully added to project', 'done');
				return $this->_redirect('/'.$projekt.'/people/new');
			}else{
				$this->_flash('Please select user from the left column', 'error', false);
			}
		}		
	}
	
	private function _newPeople()
	{
		
	}
	
	private function _editTeam()
	{
		
	}
	
	private function _editPeople()
	{
		
	}
	
	private function _deleteTeam($projekt)
	{
		$this->_modelAcl->removeFromProject((int)$this->_request->getParam('id'));
		$this->_flash('User has been successfully removed from project', 'done');
		return $this->_redirect('/'.$projekt.'/people/overview');
	}
	
	private function _deletePeople()
	{
		
	}
}