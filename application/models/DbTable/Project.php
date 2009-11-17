<?php

class Model_DbTable_Project extends Unodor_Db_Table {
	
	protected $_name = 'project';
	
	protected $_primary = 'idproject';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array('Acl', 'Milestone', 'Checklist', 'Ticket','Task');
	
	protected $_referenceMap = array(
		'Account' => array(
			'columns' => array('idaccount'), 
			'refTableClass' => 'Model_DbTable_Account', 
			'refColumns' => array('idaccount') 
		), 
		'Company' => array(
			'columns' => array('idcompany'),
			'refTableClass' => 'Model_DbTable_Company',
			'refColumns' => array('idcompany')
		),
		'User' => array(
			'columns' => array('iduser'),
			'refTableClass' => 'Model_DbTable_User',
			'refColumns' => array('iduser')
		)
	);
	
	/**
	 * Ziskava z DB seznam projektu podle uctu vcetne klienta a vedouciho
	 * 
	 * @param int $idaccount ID uctu
	 * @return Zend_Db_Statement Vysledek
	 */
	public function getFullProjectList($idaccount)
	{
		$query = $this->select()
					  ->from('project', array('idproject', 'idaccount', 'iduser', 'idcompany', 'name', 'description', 'img', 'status'))					   
					  ->joinLeft('user', 'project.iduser = user.iduser', array('CONCAT(user.name, " ", user.surname) as jmeno'))       
					  ->joinLeft('company', 'project.idcompany = company.idcompany', array('companyName' => 'name'))  
					  ->where('project.idaccount = ?', $idaccount)					  
					  ->setIntegrityCheck(false);		
					   			
		$stmt = $query->query();

		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

		return $result;
	}
}