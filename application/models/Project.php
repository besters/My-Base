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
	 * @return Zend_Db_Statement Vysledek dotazu
	 */
	public function getProjectsList()
	{		
		$modelAccount = new Model_Account();

		$idaccount = $modelAccount->getId();		
		
		$query = $this->_dbTable->select()
					   			->from('project', array('idproject', 'idaccount', 'iduser', 'idcompany', 'name', 'description', 'img', 'status'))  
					   			->join('user', 'project.iduser = user.iduser', array('userName' => 'name', 'userSurname' => 'surname'))       
					   			->join('company', 'project.idcompany = company.idcompany', array('companyName' => 'name'))  
					   			->where('project.idaccount = ?', $idaccount);					   			
					   			
		$query->setIntegrityCheck(false);   						   			
					   			
		$stmt = $query->query();
		
		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);
		
		return $result;
	}
	

}