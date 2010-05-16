<?php

class Model_DbTable_UserMeta extends Unodor_Db_Table
{
   protected $_name = 'user_meta';
   protected $_primary = 'iduser';
   protected $_sequence = true;

   /**
    * Ziskava z DB seznam uzivatelu kteri nejsou prirazeni k danemu projektu
    *
    * @param int $idproject ID projektu
    * @return Zend_Db_Statement Vysledek
    */
   public function getFreeUsers($idproject)
   {
      $idaccount = $this->getAccountId();

      $query = $this->select()
              ->from('user_meta', array('iduser', 'CONCAT(user_meta.name, " ", user_meta.surname) as user'))
              ->join('company', 'user_meta.idcompany = company.idcompany', array('name AS company'))
              ->where('user_meta.iduser NOT IN (?)', new Zend_Db_Expr('SELECT DISTINCT iduser FROM acl WHERE idproject = ' . $idproject . ''))
              ->where('user_meta.idaccount = ?', $idaccount)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

      return $result;
   }

   /**
    * Ziskava z DB seznam uzivatelu kteri jsou prirazeni k danemu projektu
    *
    * @param int $idproject ID projektu
    * @return Zend_Db_Statement Vysledek
    */
   public function getProjectUsers($idproject)
   {
      $idaccount = $this->getAccountId();

      $query = $this->select()
              ->from('user_meta', array('iduser', 'CONCAT(user_meta.name, " ", user_meta.surname) as user'))
              ->joinLeft('company', 'user_meta.idcompany = company.idcompany', array('name AS company', 'idcompany'))
              ->where('user_meta.iduser IN (?)', new Zend_Db_Expr('SELECT DISTINCT iduser FROM acl WHERE idproject = ' . $idproject . ''))
              ->where('user_meta.idaccount = ?', $idaccount)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

      return $result;
   }

   /**
    * Ziskava z DB seznam uzivatelu podle accountu
    *
    * @return Zend_Db_Statement Vysledek
    */
   public function getAccountUsers()
   {
      $account = $this->getAccountId();

      $query = $this->select()
              ->from('user_meta', array('user_meta.name', 'user_meta.surname', 'user_meta.email', 'user_meta.iduser', 'user_meta.username', 'user_meta.status'))
              ->join('company', 'user_meta.idcompany = company.idcompany', array('company.name AS company', 'idcompany'))
              ->where('user_meta.idaccount = ?', $account)
              ->where('company.idaccount = ?', $account)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);



      return $result;
   }

   /**
    * Ziskava informace o jednom uzivateli
    *
    * @param int $iduser ID uzivatele
    * @return Zend_Db_Statement
    */
   public function getUserInfo($iduser)
   {
      $query = $this->select()
              ->from('user_meta', array('iduser', 'user_meta.name', 'user_meta.surname', 'user_meta.email'))
              ->joinLeft('company', 'user_meta.idcompany = company.idcompany', array('name AS company'))
              ->where('user_meta.iduser = ?', $iduser)
	      ->limit(1)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchObject();

      return $result;
   }

}

