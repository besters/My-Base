<?php

/**
 * Materska trida vsech Model_DbTable_* trid
 *
 */
class Unodor_Db_Table extends Zend_Db_Table_Abstract
{

   /**
    * Ziskava idaccount
    *
    * @return int
    */
   public function getAccountId()
   {
      $model = new Model_Account();

      $idaccount = $model->getId();

      return $idaccount;
   }

   /**
    * Uklada data do databaze
    *
    * @param array $data Ukladane data
    * @param int $id ID editovaneho zaznamu
    * @return int|void ID aktualne ukladaneho zaznamu
    */
   public function save($data, $id = null)
   {
      if(is_null($id)){
         return self::_insert($data);
      }else{
         if(is_int($id)){
            return self::update($data, $id);
         }else{
            // TODO: použít vhodnou exception třídu
            throw new Exception('Hodnota $id musí být celé číslo');
         }
      }
   }

   /**
    * Pomocna metoda ktera provadi insert nad DB
    *
    * @param array $data ukladane data
    * @return int id aktualne vkladaneho zaznamu
    */
   private function _insert($data)
   {
      $lasInsertId = $this->insert($data);
      return $lasInsertId;
   }

   /**
    * Provadi update nad DB
    *
    * @param array $data Ukladane data
    * @param int $id Primarni klic
    * @return bool
    */
   public function update(array $data, $id)
   {
      $id = array($this->_primary[1] . ' = ?' => (int)$id);

      if(parent::update($data, $id)){
         return true;
      }else{
         return false;
      }
   }

   /**
    * Maze zaznam z DB
    *
    * @param int $id ID mazaneho zaznamu
    *
    * @todo zjistit jestli je kod ok, pripadne udelat nejake optimalizace
    */
   public function deleteEntry($id)
   {
      if(is_int($id)){
         $stav = $this->delete($this->_primary . ' =' . (int)$id);
      }else{
         $stav = $this->delete(key($id) . ' = ' . $id[key($id)]);
      }
      if($stav == 0){
         throw new Exception("Nelze smazat záznam s ID $id");
      }
   }

   /**
    * Vybere z DB vsechny zaznamy
    *
    * @param string $where WHERE podminka
    * @param array $columns Sloupce
    * @return Zend_Db_Statement
    */
   public function fetchAllEntry($where = null, array $columns = null)
   {
      if(is_array($columns)){
         if(is_null($where)){
            $fetch = $this->fetchAll($this->select()->from($this, $columns));
         }else{
            $fetch = $this->fetchAll($this->select()->from($this, $columns)->where($where));
         }
      }else{
         $fetch = $this->fetchAll($where);
      }
      return $fetch;
   }

   /**
    * Vybere jeden nebo vice zaznamu podle zadaneho ID
    *
    * @param int|array $id parametr pro WHERE podminku
    * @param array $columns Sloupce
    * @param bool $returnObject Vraci data jako objekt, nebo pole
    * @return array|object|false
    *
    * @todo zjistit jestli je kod ok, pripadne udelat nejake optimalizace
    */
   public function getRow($id, array $columns = array('*'), $returnObject = false)
   {
      if(is_array($id)){
         $where = '';
         foreach($id as $key => $val){
            $where .= $key . ' = "' . $val . '" AND ';
         }
         $where .= '1=1';
      }else{
         if(is_array($this->_primary)){
            $where = $this->_primary[1] . ' = ' . $id;
         }else{
            $where = $this->_primary . ' = ' . $id;
         }
      }
      $row = $this->fetchRow($this->select()->from($this, $columns)->where($where));
      if($row != null){
         if($returnObject == true){
            return $row;
         }else{
            return $row->toArray();
         }
      }else{
         return false;
      }
   }

}
