<?php

class Model_User
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_User
    */
   private $_dbTable;

   /**
    * Konstruktor
    *
    */
   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_User();
   }

   /**
    * Uklada noveho/editovaneho uzivatele do DB
    *
    * @param array $formData Data z formulare
    * @param int $id ID editovaneho zaznamu
    * @return int ID ukladaneho zaznamu
    *
    * @todo Dodelat sloupce pro editaci
    */
   public function save($formData, $id = null)
   {

      if(is_null($id)){
         $data = array(
             'idaccount' => $this->_dbTable->getAccountId(),
             'idcompany' => $formData['idcompany'],
             'idlogin' => $formData['idlogin'],
             'email' => $formData['email'],
             'owner' => 0,
             'administrator' => 0,
             'status' => 0,
             'registered' => new Zend_Db_Expr('NOW()')
         );
      }else{
         $data = array(
             'idcompany' => $formData['idcompany'],
             'mobile' => $formData['mobile'],
             'home' => $formData['home'],
             'work' => $formData['work'],
             'im' => $formData['im'],
             'imservice' => $formData['imservice'],
             'email' => $formData['mail']
         );
      }

      $lastInsertId = $this->_dbTable->save($data, $id);
      return $lastInsertId;
   }

   public function delete($id)
   {
      $this->_dbTable->deleteEntry($id);
   }

   public function getUserInfo($id)
   {
      return $this->_dbTable->getUserInfo($id);
   }

   public function isOwner($idacl)
   {
      $owner = $this->_dbTable->isOwner($idacl);
      return $owner->owner;
   }

   public function getOwnerId($idaccount)
   {
      $idowner = $this->_dbTable->getRow(array('idaccount' => $idaccount, 'owner' => 1), array('iduser'));
      return $idowner;
   }

}

