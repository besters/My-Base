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
}