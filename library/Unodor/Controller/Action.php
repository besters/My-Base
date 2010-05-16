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

   /*
    * ublic function preDispatch(){
    * witch($this->_request->module){
    * ase 'admin' :
    * menu = new Model_adminMenu();
    * reak;
    * efault :
    * menu = new Model_Menu();
    }
    * menu->build();
    } */

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

   /*
    * ublic function save($id = null, $redirect = null)
    {
    * f($redirect == null) $redirect = $this->_getRedirect();
    * f($id) $id = $this->_request->getParam('id');
    * formData = $this->getRequest()->getPost();
    * f($this->getRequest()->isPost()){
    * f($this->_form->isValid($formData)){
    * this->_model->save($this->_form->getValues(), $id);
    * f($this->getRequest()->isXmlHttpRequest()){
    * this->_refreshTable();
    * else{
    * this->_flash('Formulář byl úspěšně odeslán', 'done');
    * eturn $this->_redirect($redirect);
    }
    * else{
    * f($this->getRequest()->isXmlHttpRequest()){
    * this->disableMvc();
    * rint 'error';
    * else{
    * this->_flash('Formulář není vyplněn správně', 'error', false);
    * this->_form->populate($formData);
    }
    }
    * else{
    * f($id){
    * this->_form->populate($this->_model->populateForm($id));
    * this->_helper->viewRenderer->setRender('index');
    }
    }
    } */
   /*
    * ublic function delete($redirect = null)
    {
    * f($redirect == null) $redirect = $this->_getRedirect();
    * id = $this->_request->getParam('id');
    * ry{
    * this->_model->delete($id);
    * catch (Exception $e){
    * f($this->getRequest()->isXmlHttpRequest()){
    * rint 'error';
    * ie();
    * else{
    * this->_flash($e->getMessage(), 'error');
    * eturn $this->_redirect($redirect);
    }
    }
    * f($this->getRequest()->isXmlHttpRequest()){
    * this->_refreshTable();
    * else{
    * this->_flash('Záznam s ID ' . $id . ' byl úspěšně smazán!', 'done');
    * eturn $this->_redirect($redirect);
    }
    } */
   /*
    * rivate function _getRedirect()
    {
    * eturn $redirect = $this->_request->module . '/' . $this->_request->controller;
    }
    */
   /* public function ajaxValid()
    {
    * formData = $this->getRequest()->getPost();
    * this->disableMvc();
    * f($this->_form->isValid($formData)){
    * valid = Zend_Json::encode('valid');
    * rint $valid;
    * else{
    * data = $this->_form->processAjax($formData);
    * rint $data;
    }
    } */
   /*
    * rivate function _refreshTable()
    {
    * this->disableMvc(true, false);
    * this->view->data = $this->_model->getTableData();
    * this->_helper->viewRenderer->setRender('table');
    } */

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

