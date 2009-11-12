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
}