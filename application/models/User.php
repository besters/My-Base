<?php
class Model_User
{
	/**
	 * Ukazatel na DbTable layer
	 * @var object
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_User();
	}
	
	/**
	 * Zjišťuje ID uživatele
	 * 
	 * @param string $user Uživatelské jméno
	 * @return string ID uživatele
	 */
	public function getUserId($user)
	{
		$where = array('email' => $user);
		$id = $this->_dbTable->getRow($where, array('iduser'));		
		return $id['iduser'];
	}
}