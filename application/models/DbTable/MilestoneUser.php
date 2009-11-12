<?php

class Model_DbTable_MilestoneUser extends Unodor_Db_Table {
	
	protected $_name = 'milestoneuser';
	
	protected $_primary = 'idmilestoneuser';
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
		'Milestone' => array(
			'columns' => array('idmilestone'), 
			'refTableClass' => 'Milestone', 
			'refColumns' => array('idmilestone') 
		), 
		'User' => array(
			'columns' => array('iduser'),
			'refTableClass' => 'User',
			'refColumns' => array('iduser')
		)
	);
}