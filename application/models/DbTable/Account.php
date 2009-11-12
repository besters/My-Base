<?php

class Model_DbTable_Account extends Unodor_Db_Table
{

	protected $_name = 'account';

	protected $_primary = 'idaccount';

	protected $_sequence = true;
/**
 * @todo Dokončit 13.11.2009 !
public function fetchAllEntry($where = false){
		
		if($where){
			$fetch = $this->fetchAll($where , 'idaccount DESC');
		}else{
			$fetch = $this->fetchAll( null , 'idaccount DESC' );
		}
		
		return $fetch->toArray();
		
}
*/


}