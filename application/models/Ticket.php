<?php

class Model_Ticket
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Account
    */
   private $_dbTable;

   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Ticket();
   }

   public function getAll($idproject)
   {
      $tickets = $this->_dbTable->getAll($idproject);

      $paginator = new Zend_Paginator($tickets);      
/*
      $user = new Model_UserMeta();

      $ids = array();
      foreach($paginator as $id){
         $ids[] = $id['iduser'];
         if(!is_null($id['assignee']))
            $ids[] = $id['assignee'];
      }

      $users = $user->getUsers($ids);
/*
      foreach($paginator as $key => $val){
         $return[$key] = $val;
         foreach($users as $usr){
            if($usr['iduser'] == $val['iduser']){
               $return[$key]['reporter'] = $usr['name'] . ' ' . $usr['surname'];
            }
            if($usr['iduser'] == $val['assignee']){
               $return[$key]['assigneed'] = $usr['name'] . ' ' . $usr['surname'];
            }
         }
      }
*/
      return $paginator;
   }

   /**
    * Uklada novy/editovany ticket do DB
    *
    * @param array $formData Data z formulare
    * @param int $id ID editovaneho zaznamu
    * @return int ID ukladaneho zaznamu
    */
   public function save($formData, $id = null)
   {
      $user = new Model_User();
      $project = new Model_Project();

      $data = array(
          'idproject' => $project->getId(),
          'iduser' => $user->getUserId(),
          'idpriority' => empty($formData['idpriority']) ? null : $formData['idpriority'],
          'idmilestone' => empty($formData['idmilestone']) ? null : $formData['idmilestone'],
          'idtyp' => empty($formData['idtyp']) ? null : $formData['idtyp'],
          'name' => $formData['name'],
          'datetime' => new Zend_Db_Expr('NOW()'),
          'description' => empty($formData['description']) ? null : $formData['description'],
          'status' => $formData['status']
      );

      $lastInsertId = $this->_dbTable->save($data, $id);

      $this->_dbTable->stream(Model_Stream::TYP_TICKET, Model_Stream::AKCE_REPORTED, $formData['name'], $lastInsertId);

      return $lastInsertId;
   }

}

