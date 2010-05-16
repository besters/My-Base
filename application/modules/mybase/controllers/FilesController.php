<?php

class Mybase_FilesController extends Unodor_Controller_Action
{

   public function init()
   {
      parent::init();
   }

   public function indexAction()
   {
      $s3 = new Zend_Service_Amazon_S3('AKIAJ5HTOSBB7ITPA6VQ', 'n8ZjV8xz/k/FxBGhrVduYlSXVFFmep7aZJ/NOsoj');

      $this->view->buckets = $s3->getBuckets();

      $bucketName = 'vaultman';

      $ret = $s3->getObjectsByBucket($bucketName);

      $this->view->objects = $ret;

      $this->view->form = new Mybase_Form_Files();

      $formData = $this->getRequest()->getPost();

      if($this->_request->isPost()){


         $s3->registerStreamWrapper("s3");

         //file_put_contents("s3://".$bucketName."/".$_FILES['img']['name'], fopen($_FILES['img']['tmp_name'], 'r'));

         $adapter = new Zend_File_Transfer_Adapter_Http();
         $adapter->setDestination("s3://" . $bucketName . "/");

         //$adapter->receive();
      }
   }

}

