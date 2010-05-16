<?php

class Model_DbTable_User extends Unodor_Db_Table
{
   protected $_name = 'user';
   protected $_primary = 'iduser';
   protected $_sequence = true;
   protected $_dependentTables = array('Activity', 'Acl', 'Milestone', 'Checklist', 'MilestoneUser', 'Ticket', 'TicketUser', 'Task', 'Project');
   protected $_referenceMap = array(
       'Account' => array(
           'columns' => array('idaccount'),
           'refTableClass' => 'Model_DbTable_Account',
           'refColumns' => array('idaccount')
       ),
       'Company' => array(
           'columns' => array('idcompany'),
           'refTableClass' => 'Model_DbTable_Company',
           'refColumns' => array('idcompany')
       ),
       'Login' => array(
           'columns' => array('idlogin'),
           'refTableClass' => 'Model_DbTable_Login',
           'refColumns' => array('idlogin')
       )
   );

   public function getUserInfo($iduser)
   {
      $query = $this->select()
              ->from('user', array('iduser', 'idlogin', 'idcompany', 'email AS mail', 'mobile', 'home', 'work', 'im', 'imservice', 'administrator'))
              ->join('login', 'user.idlogin = login.idlogin', array('name', 'surname', 'email', 'username'))
              ->where('user.iduser = ?', $iduser)
              ->limit(1)
              ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchObject();

      return $result;
   }

   public function isOwner($idacl)
   {
      $query = $this->select()
	      ->from('user', array('owner'))
	      ->joinLeft('acl', 'user.iduser = acl.iduser')
	      ->where('acl.idacl = ?', $idacl)
	      ->limit(1)
	      ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchObject();

      return $result;
   }

}

