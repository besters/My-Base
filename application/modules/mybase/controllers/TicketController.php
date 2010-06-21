<?php

class Mybase_TicketController extends Unodor_Controller_Action
{
   public $_model;

   public function init()
   {
      parent::init();
      $this->_model = new Model_Ticket();
   }

   public function indexAction()
   {
      $idproject = $this->_request->getParam('projekt');
      $data = $this->_model->getAll($idproject);

      $data->setItemCountPerPage(20);
      $data->setPageRange(5);

      Zend_Paginator::setDefaultScrollingStyle('Sliding');
      Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination/pagination.phtml');

      $page = $this->_getParam('page', 1);
      $data->setCurrentPageNumber($page);

      $ids = array();
      foreach($data as $id){
         $ids[] = $id['iduser'];
         if(!is_null($id['assignee']))
            $ids[] = $id['assignee'];
      }

      $user = new Model_UserMeta();
      $users = $user->getUsers($ids);

      $this->view->users = $users;
      $this->view->data = $data;
   }

   public function newAction()
   {
      $acl = Zend_Registry::get('acl');
      $auth = new Zend_Session_Namespace('Zend_Auth');

      if($auth->storage->administrator == 1 || $acl->isAllowed($auth->storage->email, $this->_request->getParam('projekt') . '|ticket', 'edit') == 1){
         $this->_form = new Mybase_Form_TicketAdmin();
      }else{
         $this->_form = new Mybase_Form_TicketUser();
      }

      $this->view->form = $this->_form;

      $formData = $this->getRequest()->getPost();

      if($this->_request->isPost()){
         if($this->_form->isValid($formData)){
            $idticket = $this->_model->save($formData);

            $this->_flash('New ticket has been successfully created', 'done', true);
            return $this->_redirect($this->_project . '/ticket');
         }else{
            //$this->_flash('There is an errors in the form', 'error', false);
            $this->_form->populate($formData);
         }
      }
   }

   public function validateAction()
   {
      $acl = Zend_Registry::get('acl');
      $auth = new Zend_Session_Namespace('Zend_Auth');

      if($auth->storage->administrator == 1 || $acl->isAllowed($auth->storage->email, $this->_request->getParam('projekt') . '|ticket', 'edit') == 1){
         $form = new Mybase_Form_TicketAdmin();
      }else{
         $form = new Mybase_Form_TicketUser();
      }

      $form->isValid($this->_getAllParams());
      $this->_helper->json($form->getMessages());
   }

}

