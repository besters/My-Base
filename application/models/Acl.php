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
	 * Zjistuje opravneni uzivatele pro dany projekt
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @param string $project ID projektu
	 * @return array Opravneni
	 * 
	 * @todo Upravit fetch dotaz aby vracel jen jeden vysledek (ne fetchAll), jelikoz jeden user muze mit v jednom projektu jen jeden ACL
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
	 * Vraci opravneni podle zadaneho ID
	 * 
	 * @param int $idacl Primary key v tabulce ACL
	 * @return array Opravneni
	 */
	public function getPerms($idacl)
	{
		$acl = $this->_dbTable->getRow($idacl, array('permission'));
		
		return unserialize($acl['permission']);
	}
	
	/**
	 * Zjistuje vsechna opravneni uzivatele
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @return array Opravneni
	 */	
	public function getAllPerms($user)
	{
		$userModel = new Model_User();
		$idUser = $userModel->getUserId($user);
		
		$acl = $this->_dbTable->fetchAllEntry('iduser = '.$idUser.'', array('permission', 'idproject'));		
		
		return $acl;		
	}
	
	/**
	 * Seznam resources pro projektovou podsekci
	 * 
	 * @return array
	 */
	public function getResources()
	{
		$resources = array(
			'index' => 'Dashboard',
			'milestone' => 'Milestones',
			'ticket' => 'Tickets',
			'checklist' => 'Checklists',
			'calendar' => 'Calendar',
			'people' => 'Team',
			'settings' => 'Settings'
		);
		
		return $resources;
	}
	
	/**
	 * Ulozi novy ACL zaznam = priradi k projektu noveho uzivatele
	 * 
	 * @param array $formData $_POST data z formulare
	 * @param int $iduser ID uzivatele
	 * @param int $project ID projektu
	 */
	public function addUserToProject($formData, $iduser, $project)
	{		
		foreach($formData as $name => $perm){
			$formData[$name] = (int)$perm;
		}	

		$formData['index'] = 7;
		
		$data = array(
			'iduser' => $iduser,
			'idproject' => $project,
			'permission' => serialize($formData)
		);
		
		$this->_dbTable->save($data);				
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
		
		$resources = $this->getResources();
		
		foreach($resources as $resource => $name){
			$perm[$resource] = 7;
		}
		
		$data = array(
			'iduser'		=> 	$idUser,
			'idproject'		=>	$project,
			'permission'	=> 	serialize($perm)
		);

		$this->_dbTable->save($data);
	}
	
	/**
	 * Vraci asociativni pole se spolecnostmi a jejich uzivateli
	 * 
	 * @param int $idproject ID projektu
	 * @return array
	 */
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
	
	/**
	 * Smaze ACL zaznam
	 * 
	 * @param int $idacl
	 */
	public function removeFromProject($idacl)
	{
		$this->_dbTable->deleteEntry($idacl);
	}
	
	public function updatePerms($idacl, $perms)
	{
		$perms = serialize($perms);
		$data = array('permission' => $perms);
		
		if($this->_dbTable->update($data, $idacl)){
			return true;
		}else{
			return false;
		}
	}
}