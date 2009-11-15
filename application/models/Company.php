<?php
class Model_Company
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
		$this->_dbTable = new Model_DbTable_Company();
	}
	
	/**
	 * Vraci pole ve tvaru "id => nazev spolecnosti"
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
		
		$company = $this->_dbTable->fetchAllEntry('idaccount = '.$idaccount.'', array('idcompany', 'name'));
		
		foreach ($company as $row) {
			$return[$row->idcompany] = $row->name;
		}
		
		return $return;	
	}
}