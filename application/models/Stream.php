<?php

class Model_Stream
{
   /**
    * Ukazatel na DbTable layer
    * @var Model_DbTable_Account
    */
   private $_dbTable;

   const TYP_PROJECT     = 1;
   const TYP_MILESTONE   = 2;
   const TYP_TICKET	 = 3;

   const AKCE_CREATED     = 1;
   const AKCE_CHANGED     = 2;
   const AKCE_DELETED     = 3;
   const AKCE_COMPLETED   = 4;
   const AKCE_REPORTED    = 5;

   public function __construct()
   {
      $this->_dbTable = new Model_DbTable_Stream();
   }

   public function get($idproject = null)
   {
      $account = new Model_Account();
      $idaccount = $account->getId();

      $data = $this->_dbTable->getStream($idaccount, $idproject);

      $date = new Zend_Date();

      $return = array();
      foreach($data as $item){
	 $datum = $date->set($item->datetime);
	 $key = $datum->get(Zend_Date::DATE_FULL);
	 $return[$key][] = $item;
      }

      return $return;
   }

   public function getMain()
   {
      $account = new Model_Account();
      $idaccount = $account->getId();

      $data = $this->_dbTable->getMainStream($idaccount, null);

      $return = array();
      foreach($data as $item){ 
	 $return[$item->idproject]['data'][] = $item;
	 $return[$item->idproject]['project'] = $item->project;
      }

      return $return;
   }

   public function set($typ, $akce, $title, $link, $id=null)
   {
      $user = new Model_User();
      $project = new Model_Project();

      $idproject = is_null($project->getId()) ? $link : $project->getId();


     $data = array(
          'idaccount' => $this->_dbTable->getAccountId(),
          'idproject' => $idproject,
          'iduser' => $user->getUserId(),
          'typ' => $typ,
          'akce' => $akce,
          'title' => $title,
          'link' => (int)$link,
          'datetime' => new Zend_Db_Expr('NOW()')
      );

      $lastInsertId = $this->_dbTable->save($data, $id);
   }



}

