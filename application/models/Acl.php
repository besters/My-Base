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
	 * @param string $user Uzivatelske jmeno
	 * @param string $project ID projektu
	 * @return array Opravneni
	 */
	public function getUserPerms($user, $project)
	{
		$userModel = new Model_User();
		$idUser = $userModel->getUserId($user);
		
		$acl = $this->_dbTable->fetchAllEntry('iduser = '.$idUser.' AND idproject = '.$project.'', array('permission', 'idproject'));		

		$return = unserialize($acl[0]->permission);
		
		return $return;
	}
}