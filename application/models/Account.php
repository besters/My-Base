<?php
class Model_Account
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Account
	 */
	private $_dbTable;

	/**
	 * Konstruktor
	 * 
	 */
	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Account();
	}
	
	/**
	 * Zjistuje ID uctu
	 * 
	 * @param string $user Ucet
	 * @return string
	 */
	public function getId($account)
	{
		$where = array('url' => $account);
		$id = $this->_dbTable->getRow($where, array('idaccount'));		
		return $id['idaccount'];
	}
	
	/**
	 * Zjistuje jestli je subdomena v DB
	 * 
	 * @param string $url Subdomena
	 * @return bool
	 */
	public function isValidUrl($url){
		$where = array('url' => $url);
		$id = $this->_dbTable->getRow($where, array('idaccount'));		
		if(empty($id)){
			return false;
		}else{
			return true;
		}	
	}
}