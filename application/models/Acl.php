<?php
class Model_Acl
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Acl
	 */
	private $_dbTable;

	/**
	 * Konstruktor
	 * 
	 */
	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Acl();
	}
	
	/**
	 * Zjistuje opravneni uzivatele
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @param string $project ID projektu
	 * @return array Opravneni
	 */
	public function getUserPerms($user, $project)
	{
		$userModel = new Model_User();
		$idUser = $userModel->getUserId($user);
		
		$projectCond = '';
		if($project > 0)
			$projectCond = 'idproject = '.$project.' OR';
		
		$acl = $this->_dbTable->fetchAllEntry('iduser = '.$idUser.' AND '.$projectCond.' idproject IS NULL', array('permission', 'idproject'));
		
		foreach($acl as $perm){
			if(is_null($perm->idproject)){
				$return['global'] = unserialize($perm->permission);
			}else{
				$return['project'] = unserialize($perm->permission);
			}
		}
		
		return $return;
	}
}