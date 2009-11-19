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
		
		$acl = $this->_dbTable->fetchAllEntry('iduser = '.$idUser.' AND idproject = '.$project.'', array('permission', 'idproject'));		

		$return = unserialize($acl[0]->permission);
		
		return $return;
	}
	
	/**
	 * Seznam resources pro projektovou podsekci
	 * 
	 * @return array
	 */
	private function _getResources()
	{
		$resources = array(
			'index',
			'milestone',
			'ticket',
			'checklist',
			'calendar',
			'people',
			'settings'
		);
		
		return $resources;
	}
	
	/**
	 * Uklada ACL pro aktualniho uzivatele
	 * 
	 * @param int $project idproject
	 * @todo ukladat k uzivateli ktery byl nastaven jako vedouci, ne k tomu co projekt vytvari
	 */
	public function createDefault($project)
	{
		$userModel = new Model_User();
		$idUser = $userModel->getUserId();
		
		$resources = $this->_getResources();
		
		foreach($resources as $resource){
			$perm[$resource] = 7;
		}
		
		$data = array(
			'iduser'		=> 	$idUser,
			'idproject'		=>	$project,
			'permission'	=> 	serialize($perm)
		);

		$this->_dbTable->save($data);
	}
	
	public function getUsers($idproject)
	{
		$users = $this->_dbTable->getFullUserList($idproject);
		
		$return = array();
		
		foreach($users as $user){
			$return[$user->company][] = array(
				'iduser' => $user->iduser,
				'idacl' => $user->idacl,
				'user' => $user->user,
				'email' => $user->email
			);	
		}
		
		return $return;		
	}
}