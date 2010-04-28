<?php
class Mybase_PeopleController extends Unodor_Controller_Action
{
	public function init()
	{
		$this->_modelAcl = new Model_Acl();
		$this->_modelUser = new Model_User();
		parent::init();
	}
	
	public function indexAction()
	{
		$users = $this->_modelUser->getAccountUsers();

		$this->view->userList = $users;
	}	
	
	public function overviewAction()
	{
		$users = $this->_modelAcl->getUsers($this->_project);
		
		$this->view->userList = $users;
	}
	
	public function newAction()
	{
		if(isset($this->_project)){
			$this->_helper->viewRenderer('new-team');
			return $this->_newTeam($this->_project);
		}else{
			$this->_helper->viewRenderer('new-people');
			return $this->_newPeople();
		}
	}
	
	public function editAction()
	{
		if(isset($this->_project)){
			return $this->_editTeam();
		}else{
			return $this->_editPeople();
		}		
	}
	
	public function deleteAction()
	{	
		if(isset($this->_project)){
			return $this->_deleteTeam($this->_project);
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
				foreach($_POST['user'] as $iduser){
					$this->_modelAcl->addUserToProject($_POST['acl'], $iduser, $projekt);
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
		$this->_form = new Mybase_Form_People();

		$this->view->form = $this->_form;

		$formData = $this->getRequest()->getPost();


		if($this->_request->isPost()){
			if($this->_form->isValid($formData)){
				$company = new Model_Company();

				empty($formData['idcompany']) ? $formData['idcompany'] = $company->save($formData) : $formData['idcompany'];

				Zend_Debug::dump($formData['idcompany']);

				$this->_modelUser->save($formData);

				$mail = new Model_Mail();
				$mail->prepare($formData)->generate(Model_Mail::INVITE)->send($formData['email']);

				$this->_flash('New User has been successfully created and E-mailed ***TODO***', 'done', true);
				return $this->_redirect('/people');
			}else{
				//$this->_flash('There is an errors in the form', 'error', false);
				$this->_form->populate($formData);
			}
		}
	}
	
	private function _editTeam()
	{
		
		$idacl = $this->_request->getParam('id');
		$this->view->acl = $this->_modelAcl->getPerms($idacl);

		$this->disableMvc(true, false);
		
		if($this->_request->isPost()){

			$this->disableMvc(true, true);		
			
			$perms = $this->_modelAcl->getPerms($idacl);			
			$ex = explode('-', $this->_request->getParam('perm'));			
			$perms[$ex[1]] = (int)$ex[2];
			
			if($this->_modelAcl->updatePerms($idacl, $perms)){
				echo true;
			}else{
				echo false;
			}

		}
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