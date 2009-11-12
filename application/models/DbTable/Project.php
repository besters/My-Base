<?php

class Model_DbTable_Project extends Unodor_Db_Table {
	
	protected $_name = 'project';
	
	protected $_primary = 'idproject';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array('Acl', 'Milestone', 'Checklist', 'Ticket','Task');
	
	protected $_referenceMap = array(
		'Account' => array(
			'columns' => array('idaccount'), 
			'refTableClass' => 'Account', 
			'refColumns' => array('idaccount') 
		), 
		'Company' => array(
			'columns' => array('idcompany'),
			'refTableClass' => 'Company',
			'refColumns' => array('idcompany')
		),
		'User' => array(
			'columns' => array('iduser'),
			'refTableClass' => 'User',
			'refColumns' => array('iduser')
		)
	);
}