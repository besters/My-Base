<?php

/**
 * Materska trida vsech Controlleru
 *
 */
abstract class Unodor_Controller_Action extends Zend_Controller_Action
{
   //protected $_model;
   //protected $_form;

   const ERROR = 'error';
   const DONE = 'done';

   private $_noauth = array('module' => 'mybase', 'controller' => 'auth', 'action' => 'login');
   
   /**
    * Instance FlashMessenger action helperu
    *
    * @var Zend_Controller_Action_Helper_FlashMessenger
    */
   protected $_flashMessenger;
   protected $_project;

   public function init()
   {
      $this->_project = $this->_request->getParam('projekt');

      $validate = $this->_request->getParam('validate');
      if(!is_null($validate))
         $this->_forward('validate');
   }

   public function memory()
   {
      $zfDebug = Zend_Controller_Front::getInstance()->getPlugin('ZFDebug_Controller_Plugin_Debug');
      $zfMemory = $zfDebug->getPlugin('Log');

      $zfMemory->mark('Memory usage');

      $zfMemory->mark('Memory usage');
   }

   public function validateAction()
   {
      $controller = $this->_request->getControllerName();
      $class = 'Mybase_Form_' . $controller;
      $form = new $class;
      $form->isValid($this->_getAllParams());
      $this->_helper->json($form->getMessages());
   }

   protected function getProjectId($project = null)
   {
      $projekt = new Model_Project();
      return $projekt->getId($project);
   }

   /**
    * Uklada stavove zpravy
    *
    * @param string $message Zprava
    * @param const $status Status
    * @param bool $nextRequest Zobrazit hned, nebo az pri dalsim requestu
    */
   protected function _flash($message, $status, $nextRequest = true)
   {
      if($nextRequest == false){
         $this->view->flash = array(
             'message' => $message,
             'status' => $status
         );
      }else{
         $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
         $this->_flashMessenger->addMessage(array(
             'message' => $message,
             'status' => $status
         ));
      }
   }

   /**
    * Zakazuje a povoluje renderovani layoutu a view
    *
    * @param bool $layout Ovlada layout
    * @param bool $view Ovlada view
    */
   protected function disableMvc($layout = true, $view = true)
   {
      if($view)
         $this->_helper->viewRenderer->setNoRender();
      if($layout)
         $this->_helper->layout->disableLayout();
   }

}

