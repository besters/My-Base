<?php

class Model_DbTable_Milestone extends Unodor_Db_Table {
	
	protected $_name = 'milestone';
	
	protected $_primary = 'idmilestone';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array('Checklist', 'MilestoneUser', 'Ticket', 'Task');
	
	protected $_referenceMap = array(
		'Project' => array(
			'columns' => array('iproject'), 
			'refTableClass' => 'Project', 
			'refColumns' => array('idproject') 
		), 
		'User' => array(
			'columns' => array('iduser'),
			'refTableClass' => 'User',
			'refColumns' => array('iduser')
		),
		'Priority' => array(
			'columns' => array('idpriority'),
			'refTableClass' => 'Priority',
			'refColumns' => array('idpriority')
		)
	);
	
	public function getMilestones($condition, $idproject)
	{					  
		$query = $this->select()             			                   
					  ->from('milestone', array('name', 'datetime', 'status'))
					  ->joinLeft('priority', 'milestone.idpriority = priority.idpriority', array('name AS priority', 'idpriority')) 
					  ->join('milestoneuser', 'milestoneuser.idmilestone = milestone.idmilestone')
					  ->join('user_meta', 'user_meta.iduser = milestoneuser.iduser', array('GROUP_CONCAT( CONCAT_WS(" ", user_meta.name, user_meta.surname) ) AS user', 'GROUP_CONCAT(user_meta.iduser) AS iduser'))
					  ->where('milestone.idproject = '.$idproject)
					  ->where('milestone.idmilestone IN (?)',new Zend_Db_Expr('SELECT idmilestone FROM milestoneuser WHERE '.$condition.''))   
					  ->order('datetime ASC')     
					  ->group('milestone.idmilestone')
					  ->setIntegrityCheck(false);   
		   			
		$stmt = $query->query();

		$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);

		return $result;	
	}
}