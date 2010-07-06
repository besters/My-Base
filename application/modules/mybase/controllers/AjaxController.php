<?php

class Mybase_AjaxController extends Unodor_Controller_Action
{

   public function init()
   {
      parent::init();
   }

   public function streamAction()
   {
      $this->disableMvc(true, false);
      $stream = new Model_Stream();

      $idproject = $this->_request->getParam('id');

      $data = $stream->get($idproject);

      $this->view->stream = $data;
   }

   public function lateAction()
   {
      $this->disableMvc(true, false);

      $idproject = $this->_request->getParam('id');

      $milestone = new Model_Milestone();

      $data = $milestone->getLate($idproject);

      $this->view->late = $data;
   }

   public function upcomingAction()
   {
      $this->disableMvc(true, false);

      $idproject = $this->_request->getParam('id');

      $milestone = new Model_Milestone();

      $data = $milestone->getUpcoming($idproject);

      $this->view->upcoming = $data;
   }

}

