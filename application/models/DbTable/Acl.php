<?php

class Model_DbTable_Acl extends Unodor_Db_Table
{
   protected $_name = 'acl';
   protected $_primary = 'idacl';
   protected $_sequence = true;
   protected $_referenceMap = array(
       'User' => array(
           'columns' => array('iduser'),
           'refTableClass' => 'User',
           'refColumns' => array('iduser')
       ),
       'Project' => array(
           'columns' => array('idproject'),
           'refTableClass' => 'Project',
           'refColumns' => array('idproject')
       )
   );

   /**
    * Ziskava z DB seznam uzivatelu prirazenych k danemu projektu
    *
    * @param int $idproject ID projektu
    * @return Zend_Db_Statement Vysledek
    *
    */
   public function getFullUserList($idproject)
   {
      $query = $this->select()
              ->from('acl', array('idacl', 'iduser'))
              ->joinLeft('user_meta', 'acl.iduser = user_meta.iduser', array('CONCAT(user_meta.name, " ", user_meta.surname) as user', 'email', 'administrator'))
              ->joinLeft('company', 'user_meta.idcompany = company.idcompany', array('name AS company'))
              ->where('acl.idproject = ?', $idproject)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

      return $result;
   }

}

