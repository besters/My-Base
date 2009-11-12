<?php

class Model_DbTable_Account extends Unodor_Db_Table {
	
	protected $_name = 'account';
	
	protected $_primary = 'idaccount';
	
	protected $_sequence = true;
	
	protected $_dependentTables = array ('User', 'Company', 'Project', 'Category', 'Priority', 'Typ');
}