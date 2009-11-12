<?php
class Model_Account
{
	/**
	 * Ukazatel na DbTable layer
	 * @var object
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Account();
	}
	
	/**
	 * Zjistuje ID uctu
	 * 
	 * @param string $user Ucet
	 * @return string
	 */
	public function getId($account)
	{
		$where = array('url' => $account);
		$id = $this->_dbTable->getRow($where, array('idaccount'));		
		return $id['idaccount'];
	}
	
	public function isValidUrl($url){
		$where = array('url' => $url);
		$id = $this->_dbTable->getRow($where, array('idaccount'));		
		if(empty($id)){
			return false;
		}else{
			return true;
		}	
	}
	
	/**
	 * Příprava na Account - editace/zobrazeni inputu
	 * 
	 * @todo Dokončit model...
	 * @param array $tablevars Ucet
	 * @return array
	 
	public function getTableVars(){
		$tablevars = $this->_dbTable->fetchAllEntry() ;	

		return $tablevars ;
	}
	*/
	
	
}