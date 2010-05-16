<?php

class Mybase_PeopleController extends Unodor_Controller_Action
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
      $users = $this->_modelUserMeta->getAccountUsers();

      $this->view->userList = $users;
   }

   public function detailAction()
   {
      $user = $this->_modelUserMeta->getUserInfo($this->_request->getParam('id'));

      $this->view->name = $user->name;
      $this->view->surname = $user->surname;
      $this->view->mail = $user->email;
      $this->view->company = $user->company;
   }

   public function newAction()
   {
      $this->_form = new Mybase_Form_People();

      $this->view->form = $this->_form;

      $formData = $this->getRequest()->getPost();


      if($this->_request->isPost()){
         if($this->_form->isValid($formData)){
            $company = new Model_Company();

            empty($formData['idcompany']) ? $formData['idcompany'] = $company->save($formData) : $formData['idcompany'];

            $unodorId = new Model_Login();

            $idlogin = $unodorId->save($formData);
            $formData['idlogin'] = $idlogin;

            $this->_modelUser->save($formData);

            $mail = new Model_Mail();
            $mail->prepare($formData)->generate(Model_Mail::INVITE)->send($formData['email']);

            $salt = 'ofsdmší&;516#@ešěýp-§)údjs861fds';
            $hash = md5($this->$formData['idcompany'] . $this->$formData['name'] . $this->$formData['surname'] . $this->$formData['email'] . $salt);

            $this->_flash('New User has been successfully created and E-mailed ***TODO*** - ' . $hash, 'done', true);
            return $this->_redirect('/people');
         }else{
            //$this->_flash('There is an errors in the form', 'error', false);
            $this->_form->populate($formData);
         }
      }
   }

   public function editAction()
   {
      $iduser = (int)$this->_request->getParam('id');
      $user = $this->_modelUser->getUserInfo($iduser);
      $this->view->user = $user;
      $this->_form = new Mybase_Form_PeopleEdit();
      $this->_form->populate((array)$user);

      $this->view->form = $this->_form;

      $formData = $this->getRequest()->getPost();

      if($this->_request->isPost()){
         if($this->_form->isValid($formData)){
	    $this->_modelUser->save($formData, $iduser);
	    $this->_flash('User has been successfully edited ***TODO*** - ', 'done', true);
	    return $this->_redirect('/people');
	 }else{
	    $this->_form->populate($formData);
	 }
      }
   }

   /**
    * @todo Udelat to ajaxove
    * @todo Pridat kontrolu jestli delete probehl v poradku, jinak vyhodit chybovou flash hlasku
    */
   public function deleteAction()
   {
      $this->_modelUser->delete((int)$this->_request->getParam('id'));
      $this->_flash('User has been successfully removed', 'done');
      return $this->_redirect('/' . $projekt . '/people');
   }

}

