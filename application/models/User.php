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
	
	/**
	 * Vraci pole ve tvaru "id => jmeno uzivatele"
	 * 
	 * @param int $idaccount ID uctu
	 * @return array
	 */
	public function getFormSelect($idaccount = null)
	{
		if(is_null($idaccount)){
			$account = new Model_Account();
			$idaccount = $account->getId();
		}
		
		$users = $this->_dbTable->fetchAllEntry('idaccount = '.$idaccount.'', array('iduser', 'name', 'surname'));
		
		foreach ($users as $row) {
			$return[$row->iduser] = $row->surname .' '. $row->name;
		}
		
		return $return;	
	}
}