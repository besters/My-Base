<?php

class Model_DbTable_Stream extends Unodor_Db_Table
{
   protected $_name = 'stream';
   protected $_primary = 'idstream';
   protected $_sequence = true;

   /**
    *
    * @todo

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
   */

   public function getStream($idaccount, $idproject)
   {
      $query = $this->select()
              ->from('stream', array('idstream', 'iduser', 'typ', 'akce', 'title', 'link', 'datetime', 'idproject'))
              ->joinLeft('user_meta', 'stream.iduser = user_meta.iduser', array('name', 'surname'))
              ->where('stream.idaccount = ?', $idaccount);

      if(!is_null($idproject)){
	 $query->where('stream.idproject = ?', $idproject);
      }

     $query ->order('datetime DESC')
	    ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

      return $result;
   }

   public function getMainStream($idaccount)
   {
      $query = $this->select()
              ->from('stream', array('idstream', 'iduser', 'typ', 'akce', 'title', 'link', 'datetime', 'idproject'))
              ->joinLeft('user_meta', 'stream.iduser = user_meta.iduser', array('name', 'surname'))
              ->joinLeft('project', 'stream.idproject = project.idproject', array('name AS project'))
              ->where('stream.idaccount = ?', $idaccount)
	      ->order('datetime DESC')
	      ->setIntegrityCheck(false);

      $stmt = $query->query();

      $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

      return $result;
   }
}

