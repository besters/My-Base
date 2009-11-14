<?php
class Model_Project
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Account
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Project();
	}

	/**
	 * Vraci z db seznam projektu pro aktivni ucet
	 * 
	 * @return object Vysledek dotazu
	 */
	public function getProjectsList()
	{		
		$modelAccount = new Model_Account();

		$idaccount = $modelAccount->getId();		
		
		$result = $this->_dbTable->getFullProjectList($idaccount);		
		
		return $result;
	}
	
	public function save($data, $id = null)
	{
		$this->_dbTable->save($data, $id);
	}


}