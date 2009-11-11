<?php
class Model_User
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
		$this->_dbTable = new Model_DbTable_User();
	}
	
	/**
	 * Zjistuje ID uzivatele
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @return string ID uzivatele
	 */
	public function getUserId($user)
	{
		$session = new Zend_Session_Namespace('Zend_Auth');
		
		if($session->storage->email == $user){
			return $session->storage->iduser;
		}else{
			$where = array('email' => $user);
			$id = $this->_dbTable->getRow($where, array('iduser'));		
			return $id['iduser'];
		}
	}
}