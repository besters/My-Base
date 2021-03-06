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

   public function stream($typ, $akce, $title, $link, $id = null)
   {
      $stream = new Model_Stream();

      $stream->set($typ, $akce, $title, $link, $id);
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
    * @param bool $returnObject Vraci data jako objekt, nebo pole
    * @return Zend_Db_Statement
    *
    * @todo smazat
    *
    * @deprecated
    */
   public function fetchAllEntry($where = null, array $columns = null, $returnObject = true)
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
      if($returnObject == true){
         return $fetch;
      }else{
         return $fetch->toArray();
      }
   }

   /**
    * Provadi dotazy do databaze
    *
    * @param int|string|array $where SQL WHERE podminka
    * @param array $columns SQL sloupce
    * @param string|array $order SQL ORDER BY klauzule
    * @param int $limit SQL LIMIT
    * @param bool $returnArray Vysledek je pole nebo objekt
    * @return Zend_Db_Table_Rowset_Abstract|array Vysledna data
    */
   public function get($where = null, $columns = null, $order = null, $group = null, $limit = null, $returnArray = false)
   {
      if(is_int($where)){	 
         $return = $this->find($where);
      }else{
         if($limit == 1){
            if(is_array($columns)){
               $select = $this->select();
               $select->from($this, $columns);

               if($where !== null){
                  $this->_where($select, $where);
               }

               if($order !== null){
                  $this->_order($select, $order);
               }

	       if($group !== null){
                  $select->group($group);
               }
               $return = $this->fetchRow($select);
            }else{
               $return = $this->fetchRow($where, $order);
            }
         }else{
            if(is_array($columns)){
               $select = $this->select();
               $select->from($this, $columns);

               if($where !== null){
                  $this->_where($select, $where);
               }

               if($order !== null){
                  $this->_order($select, $order);
               }

               if($limit !== null){
                  $select->limit($limit);
               }

               if($group !== null){
                  $select->group($group);
               }
               $return = $this->fetchAll($select);
            }else{
               $return = $this->fetchAll($where, $order, $limit);
            }
         }
      }

      if($returnArray == false){
         return $return;
      }else{
         return $return->toArray();
      }
   }

   /**
    * Vybere jeden nebo vice zaznamu podle zadaneho ID
    *
    * @param int|array $id parametr pro WHERE podminku
    * @param array $columns Sloupce
    * @param bool $returnObject Vraci data jako objekt, nebo pole
    * @return array|object|false
    *
    * @todo smazat
    *
    * @deprecated
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

