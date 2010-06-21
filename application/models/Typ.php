<?php

class Model_Typ
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
      $this->_dbTable = new Model_DbTable_Typ();
   }

   /**
    * Vraci pole ve tvaru "id => typ"
    *
    * @param int $idaccount ID uctu
    * @param string $nullVal Prvni prvek selectu
    * @return array
    */
   public function getFormSelect($idaccount = null, $nullVal = null)
   {
      if(is_null($idaccount)){
         $idaccount = $this->_dbTable->getAccountId();
      }

      $priority = $this->_dbTable->fetchAllEntry('idaccount = ' . $idaccount . '', array('idtyp', 'name'));

      foreach($priority as $row){
         if(!is_null($nullVal))
            $return[null] = $nullVal;
         $return[$row->idtyp] = $row->name;
      }

      return $return;
   }

}

