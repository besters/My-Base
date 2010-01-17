<?php

class Model_MilestoneUser
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
		$this->_dbTable = new Model_DbTable_MilestoneUser();
	}	
	
	/**
	 * Uklada vsechny uzivatele prirazene k milniku
	 * 
	 * @param array $formData
	 * @param int $idmilestone
	 * @return void
	 */
	public function saveUsers($formData, $idmilestone)
	{
		foreach($formData as $user){
			$this->saveUser($user, $idmilestone);
		}		
	}
	
	/**
	 * Uklada uzivatele prirazeneho k milniku
	 * 
	 * @param int $iduser
	 * @param int $idmilestone
	 * @return void
	 */
	private function saveUser($iduser, $idmilestone)
	{
		$data = array(
			'idmilestone' => $idmilestone,
			'iduser' => $iduser
		);
		
		$this->_dbTable->save($data);	
	}
}