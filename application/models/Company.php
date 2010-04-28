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
	 * @param string $nullVal Prvni prvek selectu
	 * @return array
	 */
	public function getFormSelect($idaccount = null, $nullVal = null)
	{
		$return = array();

		if(is_null($idaccount)){
			$account = new Model_Account();
			$idaccount = $account->getId();
		}
		
		$company = $this->_dbTable->fetchAllEntry('idaccount = '.$idaccount.'', array('idcompany', 'name'));
		
		foreach ($company as $row) {
			if(!is_null($nullVal))
				$return[null] = $nullVal;
			$return[$row->idcompany] = $row->name;
		}
		
		return $return;	
	}

	/**
	 * Uklada novou/editovanou spolecnost do DB
	 *
	 * @param array $formData Data z formulare
	 * @param int $id ID editovaneho zaznamu
	 * @return int ID ukladaneho zaznamu
	 *
	 * @todo Dodelat sloupce pro editaci
	 */
	public function save($formData, $id = null)
	{
		$data = array(
			'idaccount' 	=> $this->_dbTable->getAccountId(),
			'name'		=>	$formData['company'],
			//'description'	=> empty($formData['description']) ? null : $formData['description'],
		);

		$lastInsertId = $this->_dbTable->save($data, $id);
		return $lastInsertId;
	}
}