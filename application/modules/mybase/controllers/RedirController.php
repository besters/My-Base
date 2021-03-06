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

      switch($typ){
         case Model_Stream::TYP_PROJECT :
            $url = $id.'/index/overview/';
            break;
         case Model_Stream::TYP_MILESTONE :
            $url = $this->_project.'/milestone/detail/'.$id;
            break;
         case Model_Stream::TYP_TICKET :
            $url = $this->_project.'/ticket/detail/'.$id;
      }

      $this->_redirect($url);
   }

}

