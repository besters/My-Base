<?php

/**
 * Materska trida vsech Model_DbTable_* trid
 *
 */
class Unodor_Db_Table extends Zend_Db_Table_Abstract
{
	/**
	 * Provadi INSERT / UPDATE dotaz na DB
	 * 
	 * @param array $data Ukladane data
	 * @param int $id ID editovaneho zaznamu
	 */
	public function save($data, $id = null)
	{
		if(isset($id)){
			$this->update($data, array(
				$this->_primary[1] . ' = ?' => (int)$id
			));
		}else{
			$this->insert($data);
		}
	}

	/**
	 * Maze zaznam z DB
	 * 
	 * @param int $id ID mazaneho zaznamu
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
