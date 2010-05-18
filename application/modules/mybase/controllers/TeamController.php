<?php

class Mybase_TeamController extends Unodor_Controller_Action
{

   public function init()
   {
      $this->_modelAcl = new Model_Acl();
      $this->_modelUserMeta = new Model_UserMeta();
      $this->_modelUser = new Model_User();
      parent::init();
   }

   public function indexAction()
   {
      $users = $this->_modelAcl->getUsers($this->_project);
      $this->view->userList = $users;
      
      $model = new Model_Project();
      $this->view->leader = $model->getLeader($this->_project);
   }

   public function newAction()
   {
      $projekt = $this->_request->getParam('projekt');
      $this->view->users = $this->_modelUserMeta->getFreeUsers($projekt);
      $this->view->resources = $this->_modelAcl->getResources();

      if($this->_request->isPost()){
         if(isset($_POST['userSelect'])){
            foreach($_POST['userSelect'] as $iduser){
               $this->_modelAcl->addUserToProject($_POST['acl'], $iduser, $projekt);
            }
            $this->_flash('User has been successfully added to project', 'done');
            return $this->_redirect('/' . $projekt . '/team/new');
         }else{
            Zend_Debug::dump($_POST);
            $this->_flash('Please select user from the left column', 'error', false);
         }
      }
   }

   public function editAction()
   {
      $idacl = $this->_request->getParam('id');
      $this->view->acl = $this->_modelAcl->generatePermTable($idacl);
      $this->view->owner = $this->_modelUser->isOwner($idacl);

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

   public function deleteAction()
   {
      $projekt = $this->_request->getParam('projekt');
      $this->_modelAcl->removeFromProject((int)$this->_request->getParam('id'));
      $this->_flash('User has been successfully removed from project', 'done');
      return $this->_redirect('/' . $projekt . '/team');
   }

}

