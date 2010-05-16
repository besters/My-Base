<?php

class Model_Account
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Account
    */
   private $_dbTable;

   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Account();
   }

   /**
    * Zjistuje ID aktivniho uctu
    *
    * @return int idaccount
    */
   public function getId()
   {
      $session = new Zend_Session_Namespace('Unodor_Account');
      return $session->idaccount;
   }

   /**
    * Zjistuje nazev aktivniho uctu
    * @return string Nazev uctu
    */
   public function getName()
   {
      $session = new Zend_Session_Namespace('Unodor_Account');
      return $session->name;
   }

   /**
    * Zjistuje ID a nazev uctu z DB
    *
    * @param string $account Ucet
    * @return int
    */
   private function getData($account)
   {
      $where = array('url' => $account);
      $data = $this->_dbTable->getRow($where, array('idaccount', 'name'));
      return $data;
   }

   /**
    * Uklada ID uctu do session
    *
    * @param int $id idaccount
    */
   private function setId($id)
   {
      $session = new Zend_Session_Namespace('Unodor_Account');
      $session->idaccount = $id;
   }

   /**
    * Uklada nazev uctu do session
    * @param string $name Nazev
    */
   private function setName($name)
   {
      $session = new Zend_Session_Namespace('Unodor_Account');
      $session->name = $name;
   }

   /**
    * Zjistuje jestli je subdomena v DB a do session uklada informace o uctu
    *
    * @param string $url Subdomena
    * @return bool
    */
   public function isValidUrl($url)
   {
      //$name = $this->getName($url);
      //$id = $this->getId($url);
      $data = $this->getData($url);
      if(empty($data['idaccount'])){
         return false;
      }else{
         $this->setId($data['idaccount']);
         $this->setName($data['name']);
         return true;
      }
   }

}

