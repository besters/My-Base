<?php

class Mybase_RedirController extends Unodor_Controller_Action
{

   public function init()
   {
      //$this->_model = new Model_Project();
      parent::init();
   }

   public function __call($method, $params)
   {
      $this->disableMvc();
      $ex = explode('x', $method);
      $typ = (int)$ex[0];
      $id = (int)$ex[1];

      $project = $this->_request->getParam('projekt');

      switch($typ){
         case Model_Stream::PROJECT :
            $url = $id.'/index/overview/';
            break;
         case Model_Stream::MILESTONE :
            $url = $project.'/milestone/detail/'.$id;
      }

      $this->_redirect($url);
   }

}

