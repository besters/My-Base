<?php

class Model_DbTable_Acl extends Unodor_Db_Table {
	
	protected $_name = 'acl';
	
	protected $_primary = 'idacl';
	
	protected $_sequence = true;
	
	protected $_referenceMap = array(
		'User' => array(
			'columns' => array('iduser'), 
			'refTableClass' => 'User', 
			'refColumns' => array('iduser') 
		), 
		'Project' => array(
			'columns' => array('idproject'),
			'refTableClass' => 'Project',
			'refColumns' => array('idproject')
		)
	);
}