<?php

class Model_DbTable_Company extends Unodor_Db_Table {
	
	protected $_name = 'company';
	
	protected $_primary = 'idcompany';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array('User', 'Project');
	
	protected $_referenceMap = array(
		'Account' => array(
			'columns' => array('idaccount'), 
			'refTableClass' => 'Account', 
			'refColumns' => array('idaccount') 
		)
	);
}