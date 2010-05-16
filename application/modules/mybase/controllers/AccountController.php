<?php

class Mybase_AccountController extends Unodor_Controller_Action
{

   public function init()
   {
      //$this->_model = new Model_Project();
      parent::init();
   }

   public function activationAction()
   {
      $this->disableMvc(true, false);

      $this->_form = new Mybase_Form_Activation();
      $this->view->form = $this->_form;

      $formData = $this->getRequest()->getPost();

      if($this->_request->isPost()){
         if($this->_form->isValid($formData)){

            $this->_flash('New project has been successfully created', 'done');
            //return $this->_redirect('/'.$lastInsertId.'/people/overview');
         }else{
            $this->_flash('Formulář není vyplněn správně', 'error', false);
            $this->_form->populate($formData);
         }
      }
   }

   public function validateAction()
   {
      $controller = $this->_request->getControllerName();
      $class = 'Mybase_Form_Activation';
      $form = new $class;
      $form->isValid($this->_getAllParams());
      $this->_helper->json($form->getMessages());
   }

}

