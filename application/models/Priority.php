<?php
class Model_Priority
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
		$this->_dbTable = new Model_DbTable_Priority();
	}
	
	/**
	 * Vraci pole ve tvaru "id => priority"
	 * 
	 * @param int $idaccount ID uctu
	 * @param string $nullVal Prvni prvek selectu
	 * @return array
	 */
	public function getFormSelect($idaccount = null, $nullVal = null)
	{		
		if(is_null($idaccount)){
			$account = new Model_Account();
			$idaccount = $account->getId();
		}
		
		$priority = $this->_dbTable->fetchAllEntry('idaccount = '.$idaccount.'', array('idpriority', 'name'));
		
		foreach ($priority as $row) {
			if(!is_null($nullVal))
				$return[null] = $nullVal;
			$return[$row->idpriority] = $row->name;
		}
		
		return $return;	
	}
}