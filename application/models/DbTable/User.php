<?php

class Model_DbTable_User extends Unodor_Db_Table {
	
	protected $_name = 'user';
	
	protected $_primary = 'iduser';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array ('Activity', 'Acl', 'Milestone', 'Checklist', 'MilestoneUser', 'Ticket', 'TicketUser', 'Task', 'Project');
	
	protected $_referenceMap = array (
		'Account' => array (
			'columns' => array('idaccount'), 
			'refTableClass' => 'Model_DbTable_Account', 
			'refColumns' => array('idaccount') 
		), 
		'Company' => array (
			'columns' => array('idcompany'),
			'refTableClass' => 'Model_DbTable_Company',
			'refColumns' => array('idcompany')
		)
	);
	
	/**
	 * Ziskava z DB seznam uzivatelu kteri nejsou prirazeni k danemu projektu
	 * 
	 * @param int $idproject ID projektu
	 * @return Zend_Db_Statement Vysledek
	 */
	public function getFreeUsers($idproject)
	{
		$idaccount = $this->getAccountId();
				  
		$query = $this->select()             			                   
					  ->from('user', array('iduser', 'CONCAT(user.name, " ", user.surname) as user'))
					  ->join('company', 'user.idcompany = company.idcompany', array('name AS company')) 
					  ->where('user.iduser NOT IN (?)',new Zend_Db_Expr('SELECT DISTINCT iduser FROM acl WHERE idproject = '.$idproject.''))
					  ->where('user.idaccount = ?', $idaccount)           
					  ->setIntegrityCheck(false); 
					   			
		$stmt = $query->query();

		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

		return $result;
	}
	
	/**
	 * Ziskava z DB seznam uzivatelu kteri jsou prirazeni k danemu projektu
	 * 
	 * @param int $idproject ID projektu
	 * @return Zend_Db_Statement Vysledek
	 */	
	public function getProjectUsers($idproject)
	{
		$idaccount = $this->getAccountId();
				  
		$query = $this->select()             			                   
					  ->from('user', array('iduser', 'CONCAT(user.name, " ", user.surname) as user'))
					  ->joinLeft('company', 'user.idcompany = company.idcompany', array('name AS company', 'idcompany'))
					  ->where('user.iduser IN (?)',new Zend_Db_Expr('SELECT DISTINCT iduser FROM acl WHERE idproject = '.$idproject.''))
					  ->where('user.idaccount = ?', $idaccount)           
					  ->setIntegrityCheck(false); 
					   			
		$stmt = $query->query();

		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

		return $result;		
	}

	/**
	 * Ziskava z DB seznam uzivatelu podle accountu
	 *
	 * @return Zend_Db_Statement Vysledek
	 */
	public function getAccountUsers()
	{
		$account = $this->getAccountId();

		$query = $this->select()
					  ->from('user', array('user.name', 'user.surname', 'user.email', 'user.iduser'))
					  ->join('company', 'user.idcompany = company.idcompany', array('company.name AS company'))
					  ->where('user.idaccount = ?', $account)
					  ->where('company.idaccount = ?', $account)
					  ->setIntegrityCheck(false);

		$stmt = $query->query();

		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

		return $result;
	}
}