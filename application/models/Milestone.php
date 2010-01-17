<?php
class Model_Milestone
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Account
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Milestone();
	}

	/**
	 * Vraci z db seznam milniku
	 * 
	 * @return object Vysledek dotazu
	 */
	public function getMilestonesList()
	{	
		// TODO	
		//$result = $this->_dbTable->getFullProjectList($this->_dbTable->getAccountId());		
		
		return $result;
	}
	
	/**
	 * Uklada novy/editovany milnik do DB
	 * 
	 * @param array $formData Data z formulare
	 * @param int $id ID editovaneho zaznamu
	 * @return int ID ukladaneho zaznamu
	 */
	public function save($formData, $id = null)
	{
		/*
		$data = array(
			'name' 			=> 	$formData['name'],
			'description' 	=>	empty($formData['description']) ? null : $formData['description'],
			'iduser'		=> 	$formData['iduser'],
			'idcompany'		=>	empty($formData['idcompany']) ? null : $formData['idcompany'],
			'img'			=>	$formData['img'],
			'idaccount'		=>	$this->_dbTable->getAccountId(),
			'status'		=> 'active'
		);*/

		$lastInsertId = $this->_dbTable->save($data, $id);
		return $lastInsertId;
	}
}
