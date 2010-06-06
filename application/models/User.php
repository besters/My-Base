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
    * Zjistuje ID uzivatele
    *
    * @param string $user Uzivatelske jmeno
    * @return string ID uzivatele
    */
   public function getUserId($user = null)
   {
      $session = new Zend_Session_Namespace('Zend_Auth');

      if(is_null($user) OR $session->storage->email == $user){
         return $session->storage->iduser;
      }else{
         $where = array('email' => $user);
         $id = $this->_dbTable->getRow($where, array('iduser'));
         return $id['iduser'];
      }
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

   /**
    * Maze uzivatele z db
    *
    * @param int $id iduser
    */
   public function delete($id)
   {
      $this->_dbTable->deleteEntry($id);
   }

   /**
    * Zjistuje detaily o uzivateli
    *
    * @param int $id iduser
    * @return stdClass data
    */
   public function getUserInfo($id)
   {
      return $this->_dbTable->getUserInfo($id);
   }

   /**
    * Zjistuje jeslti je uzivatel vlastnik uctu
    *
    * @param int $idacl idacl
    * @return int je nebo neni (0 / 1)
    */
   public function isOwner($idacl)
   {
      $owner = $this->_dbTable->isOwner($idacl);
      return $owner->owner;
   }

   /**
    * Zjistuje ID vlastnika uctu
    *
    * @param int $idaccount id uctu
    * @return array
    */
   public function getOwnerId($idaccount)
   {
      $idowner = $this->_dbTable->getRow(array('idaccount' => $idaccount, 'owner' => 1), array('iduser'));
      Zend_Debug::dump($idowner);
      return $idowner;
   }

}

