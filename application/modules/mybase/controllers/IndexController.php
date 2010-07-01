<?php

class Mybase_IndexController extends Unodor_Controller_Action
{

   public function indexAction()
   {
      $stream = new Model_Stream();

      $data = $stream->getMain();

      $this->view->stream = $data;
   }

   public function overviewAction()
   {
      $stream = new Model_Stream();

      $idproject = $this->_request->getParam('projekt');

      $data = $stream->get($idproject);

      $this->view->stream = $data;

      $user = new Model_UserMeta();

      $users = $user->getProjectUsersBeta($idproject);

      $this->view->users = $users;
   }

}

