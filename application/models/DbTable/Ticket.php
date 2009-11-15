<?php

class Model_DbTable_Ticket extends Unodor_Db_Table {
	
	protected $_name = 'ticket';
	
	protected $_primary = 'idticket';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array('TicketUser');
	
	protected $_referenceMap = array(
		'Project' => array(
			'columns' => array('idproject'), 
			'refTableClass' => 'Project', 
			'refColumns' => array('idproject') 
		), 
		'User' => array(
			'columns' => array('iduser'),
			'refTableClass' => 'User',
			'refColumns' => array('iduser')
		),
		'Milestone' => array(
			'columns' => array('idmilestone'),
			'refTableClass' => 'Milestone',
			'refColumns' => array('idmilestone')
		),
		'Typ' => array(
			'columns' => array('idtyp'),
			'refTableClass' => 'Typ',
			'refColumns' => array('idtyp')
		),
		'Category' => array(
			'columns' => array('idcategory'),
			'refTableClass' => 'Category',
			'refColumns' => array('idcategory')
		),
		'Priority' => array(
			'columns' => array('idpriority'),
			'refTableClass' => 'Priority',
			'refColumns' => array('idpriority')
		)
	);
}