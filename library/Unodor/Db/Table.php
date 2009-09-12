<?php

class Unodor_Db_Table extends Zend_Db_Table_Abstract
{
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

	public function deleteEntry($id)
	{
		$stav = $this->delete($this->_primary[1] . ' =' . (int)$id);
		if($stav == 0){
			throw new Exception("Nelze smazat záznam s ID $id");
		}
	}

	public function fetchAllEntry($where = false)
	{
		if($where){
			$fetch = $this->fetchAll($where);
		}else{
			$fetch = $this->fetchAll();
		}
		return $fetch->toArray();
	}

	public function getRow($id, array $columns = array('*'))
	{
		if(is_array($id)){
			$key = key($id);
			$where = $key . ' = "' . $id[$key].'"';
		}else{
			$where = $this->_primary[1] . ' = ' . $id;
		}
		$row = $this->fetchRow($this->select()->from($this, $columns)->where($where));
		return $row->toArray();
	}
}
