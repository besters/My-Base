<?php
class Model_Acl
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Acl
	 */
	private $_dbTable;

	/**
	 * Konstruktor
	 * 
	 */
	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Acl();
	}
	
	/**
	 * Zjistuje opravneni uzivatele
	 * 
	 * @TODO Dopsat podminku pro selekci podle projektu
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @param string $project ID projektu
	 * @return array Opravneni
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