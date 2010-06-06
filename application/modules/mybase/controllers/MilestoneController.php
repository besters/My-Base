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
      //$milestones = $this->_model->getMilestones();

      $active = $this->_model->getActive();
      $paused = $this->_model->getPaused();
      $complete = $this->_model->getComplete();
      $canceled = $this->_model->getCanceled();
      
      $this->view->active = $active;
      $this->view->complete = $complete;
      $this->view->paused = $paused;
      $this->view->canceled = $canceled;
   }

   public function detailAction()
   {
      $id = $this->_request->getParam('id');
      $detail = $this->_model->getDetail((int)$id);

      $this->view->name = $detail->name;
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
            return $this->_redirect($this->_project . '/milestone');
         }else{
            //$this->_flash('There is an errors in the form', 'error', false);
            $this->_form->populate($formData);
         }
      }
   }

}

