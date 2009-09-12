<?php
class Model_Acl
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Acl
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Acl();
	}
	
	/**
	 * Zjišťuje oprávnění uživatele
	 * 
	 * @TODO Dopsat podmínku pro selekci podle projektu
	 * 
	 * @param string $user Uživatelské jméno
	 * @param string $project ID projektu
	 * @return array Oprávnění
	 */
	public function getUserPerms($user, $project)
	{
		$userModel = new Model_User();
		$idUser = $userModel->getUserId($user);

		$acl = $this->_dbTable->getRow(array('iduser' => $idUser), array('permission'));
		
		$return = unserialize($acl['permission']);
		
		return $return;
	}
}