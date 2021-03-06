<?php

class Model_Login
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Login
    */
   private $_dbTable;

   /**
    * Konstruktor
    *
    */
   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Login();
   }

   /**
    * Uklada/edituje uzivatelsky login do db
    *
    * @param array $formData formularova data
    * @param int|false $id idlogin
    * @return int id prave ulozeneho loginu
    */
   public function save($formData, $id = null)
   {
      $salt = 'ofsdmší&;516#@ešěýp-§)údjs861fds';

      $data = array(
          'name' => $formData['name'],
          'surname' => $formData['surname'],
          'email' => $formData['email'],
          'password' => md5($formData['idcompany'] . $formData['name'] . $formData['surname'] . $formData['email'] . $salt)
      );

      $lastInsertId = $this->_dbTable->save($data, $id);
      return $lastInsertId;
   }

   /**
    * Vrazi zakladni iformace o uzivatelove loginu
    *
    * @param int $id idlogin
    * @return array
    */
   public function getUserInfo($id)
   {
      return $this->_dbTable->getRow($id, array('name', 'surname', 'email', 'username'));
   }

}

