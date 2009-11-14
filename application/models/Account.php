<?php
class Model_Account
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Account
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Account();
	}
	
	/**
	 * Zjistuje aktualni ID uctu ze session a volitelne ID uctu z DB
	 * 
	 * @param string $account Ucet
	 * @return int idaccount
	 */
	public function getId($account = false)
	{
		if(!$account){
			$session = new Zend_Session_Namespace('Unodor_Account');
			return $session->idaccount;
		}else{
			return $this->_getId($account);
		}
	}
	
	/**
	 * Zjistuje ID uctu z DB
	 * 
	 * @param string $account Ucet
	 * @return int
	 */	
	private function _getId($account)
	{
		$where = array('url' => $account);
		$id = $this->_dbTable->getRow($where, array('idaccount'));		
		return $id['idaccount'];		
	}
	
	/**
	 * Uklada ID uctu do session
	 * 
	 * @param int $id idaccount
	 */
	private function _setId($id)
	{
		$session = new Zend_Session_Namespace('Unodor_Account');
		$session->idaccount = $id;
	}
	
	/**
	 * Zjistuje jestli je subdomena v DB
	 * 
	 * @param string $url Subdomena
	 * @return bool
	 */
	public function isValidUrl($url){
		$id = $this->_getId($url);		
		if(empty($id)){
			return false;
		}else{
			$this->_setId($id);
			return true;
		}	
	}	
}