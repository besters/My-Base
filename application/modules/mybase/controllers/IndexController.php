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
      $user = new Model_UserMeta();

      $users = $user->getProjectUsersBeta($this->_project);

      $this->view->users = $users;

      $project = new Model_Project();

      $info = $project->getProjectInfo($this->_project);

      $this->view->info = $info;
   }

   public function imgAction()
   {
      /*
      $this->disableMvc();

      $img = Unodor_Image_Graph::setType(Unodor_Image_Graph::PIE);

      $pie = $img ->setSize(175)
		  ->setColors(array('c5c5c5', 'f9f9f9'))
		  ->setBackground('f1f1f1')
		  ->setBorder('c5c5c5')
		  ->setData($_GET['data'])
		  ->display();
*/
   }
}

