<?php

/**
 * Materska trida vsech Model_DbTable_* trid
 *
 */
class Unodor_Db_Table extends Zend_Db_Table_Abstract
{
	/**
	 * Uklada data do databaze
	 * 
	 * @param array $data Ukladane data
	 * @param int $id ID editovaneho zaznamu
	 */
	public function save($data, $id = null)
	{
		if(is_null($id)){
			self::_insert($data);
		}else{
			if(is_int($id)){
				self::_update($data, $id);
			}else{
				// TODO: použít vhodnou exception třídu
				throw new Exception('Hodnota $id musí být celé číslo');
			}
		}
	}
	
	private function _insert($data)
	{
		print 'saved';
	}
	
	private function _update($data, $id)
	{
			//$this->update($data, array(
				//$this->_primary[1] . ' = ?' => (int)$id
			//));		
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
		$stav = $this->delete($this->_primary[1] . ' =' . (int)$id);
		if($stav == 0){
			throw new Exception("Nelze smazat záznam s ID $id");
		}
	}

	/**
	 * Vybere z DB vsechny zaznamy
	 * 
	 * @param string $where
	 * @return array
	 * 
	 * @todo zjistit jestli je kod ok, pripadne udelat nejake optimalizace
	 */
	public function fetchAllEntry($where = false)
	{
		if($where){
			$fetch = $this->fetchAll($where);
		}else{
			$fetch = $this->fetchAll();
		}
		return $fetch;
	}

	/**
	 * Vybere jeden nebo vice zaznamu podle zadaneho ID
	 * 
	 * @param int|array $id parametr pro WHERE podminku
	 * @param array $columns Sloupce
	 * @return array|false
	 * 
	 * @todo zjistit jestli je kod ok, pripadne udelat nejake optimalizace
	 */
	public function getRow($id, array $columns = array('*'))
	{
		if(is_array($id)){
			$key = key($id);
			$where = $key . ' = "' . $id[$key].'"';
		}else{
			$where = $this->_primary[1] . ' = ' . $id;
		}
		$row = $this->fetchRow($this->select()->from($this, $columns)->where($where));
		if($row != null)
			return $row->toArray();
		else
			return false;	
	}
}
