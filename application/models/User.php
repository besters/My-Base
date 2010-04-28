<?php
class Model_User
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_User
	 */
	private $_dbTable;

	/**
	 * Konstruktor
	 * 
	 */
	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_User();
	}
	
	/**
	 * Zjistuje ID uzivatele
	 * 
	 * @param string $user Uzivatelske jmeno
	 * @return string ID uzivatele
	 */
	public function getUserId($user = null)
	{
		$session = new Zend_Session_Namespace('Zend_Auth');
		
		if(is_null($user) OR $session->storage->email == $user){
			return $session->storage->iduser;
		}else{
			$where = array('email' => $user);
			$id = $this->_dbTable->getRow($where, array('iduser'));		
			return $id['iduser'];
		}
	}
	
	/**
	 * Vraci pole ve tvaru "id => jmeno uzivatele"
	 * 
	 * @param int $idaccount ID uctu
	 * @param bool|array $companyData 	Seznam spolecnosti. Prebira bud pole s daty 
	 * 									(napr vystup metody {@link Model_Company::getFormSelect()}), 
	 * 									anebo hodnotu true, kdy v tomto pripade provede dotaz do DB.
	 * @return array
	 */
	public function getFormSelect($idaccount = null, $companyData = null)
	{
		$return = array();
		
		if(is_null($idaccount)){
			$account = new Model_Account();
			$idaccount = $account->getId();
		}
				
		$users = $this->_dbTable->fetchAllEntry('idaccount = '.$idaccount.'', array('iduser', 'name', 'surname', 'idcompany'));

		if(is_null($companyData)){
			foreach ($users as $row) {
					$return[$row->iduser] = $row->surname .' '. $row->name;
			}			
		}else{	
			if(is_bool($companyData) AND $companyData == true){
				$companies = new Model_Company();
				$companyData = $companies->getFormSelect($idaccount);
			}
			foreach($companyData as $idcompany => $company){
				foreach ($users as $row) {
					if($idcompany == $row->idcompany)
						$return[$company][$row->iduser] = $row->surname .' '. $row->name;
				}
			}
		}
		
		return $return;	
	}	
	
	/**
	 * Vraci asociativni pole se spolecnostmi a jejich uzivateli kteri nejsou prirazeni k danemu projektu
	 * 
	 * @param int $idproject ID projektu
	 * @return array
	 */
	public function getFreeUsers($idproject)
	{
		$users = $this->_dbTable->getFreeUsers($idproject);
		
		$return = array();
		
		foreach($users as $user){
			$return[$user->company][] = array(
				'iduser' => $user->iduser,
				'user' => $user->user
			);	
		}
		
		return $return;		
	}
	
	/**
	 * Vraci asociativni pole se spolecnostmi a jejich uzivateli kteri jsou prirazeni k danemu projektu
	 * 
	 * @param int $idproject ID projektu
	 * @return array
	 */	
	public function getProjectUsers($idproject)
	{
		$users = $this->_dbTable->getProjectUsers($idproject);
		
		$return = array();
		
		foreach($users as $user){
			$return[$user->company.';'.$user->idcompany][$user->iduser] = $user->user;
		}	
		
		return $return;
	}

	/**
	 * Ziskava vsechny uzivatele prislusne k aktualnimu uctu
	 *
	 * @return array
	 */
	public function getAccountUsers()
	{
		$users = $this->_dbTable->getAccountUsers();

		$return = array();

		foreach($users as $user){
			$return[$user->company][] = array(
				'user' => $user->name.' '.$user->surname,
				'iduser' => $user->iduser,
				'email' => $user->email
			);
		}

		return $return;
	}

	/**
	 * Uklada noveho/editovaneho uzivatele do DB
	 *
	 * @param array $formData Data z formulare
	 * @param int $id ID editovaneho zaznamu
	 * @return int ID ukladaneho zaznamu
	 *
	 * @todo Dodelat sloupce pro editaci
	 */
	public function save($formData, $id = null)
	{
		$salt = 'ofsdmší&;516#@ešěýp-§)údjs861fds';

		$data = array(
			'idaccount'			=> $this->_dbTable->getAccountId(),
			'idcompany'			=> $formData['idcompany'],
			'name'				=>	$formData['name'],
			'surname'			=>	$formData['surname'],
			'email'				=>	$formData['email'],
			'password'			=>	md5($formData['idcompany'].$formData['name'].$formData['surname'].$formData['email'].$salt),
			'owner'				=>	0,
			'administrator'	=>	0,
			'status'				=> 0
		);

		$lastInsertId = $this->_dbTable->save($data, $id);
		return $lastInsertId;
	}
}