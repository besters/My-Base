<?php
class Model_Project
{
	/**
	 * Ukazatel na DbTable layer
	 * @var Model_DbTable_Account
	 */
	private $_dbTable;

	public function __construct()
	{
		$this->_dbTable = new Model_DbTable_Project();
	}
	
	/**
	 * Zjistuje ID projektu
	 * 
	 * @param string $project Nazev projektu
	 * @return int Id projektu
	 * 
	 * @todo Zjistovat id projektu podle jeho nazvu
	 */
	public function getId($project = null)
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();
		return $request->getParam('projekt');
	}

	/**
	 * Vraci z db seznam projektu pro aktivni ucet
	 * 
	 * @return object Vysledek dotazu
	 * @todo upload obrazku a pripadny resize
	 */
	public function getProjectsList()
	{		
		$result = $this->_dbTable->getFullProjectList($this->_dbTable->getAccountId());		
		
		return $result;
	}
	
	/**
	 * Uklada novy/editovany projekt do DB a presmerovava na nastaveni prav
	 * 
	 * @param array $formData Data z formulare
	 * @param int $id ID editovaneho zaznamu
	 * @return int ID ukladaneho zaznamu
	 */
	public function save($formData, $id = null)
	{
		$data = array(
			'name' 			=> 	$formData['name'],
			'description' 	=>	empty($formData['description']) ? null : $formData['description'],
			'iduser'		=> 	$formData['iduser'],
			'idcompany'		=>	empty($formData['idcompany']) ? null : $formData['idcompany'],
			'img'			=>	$formData['img'],
			'idaccount'		=>	$this->_dbTable->getAccountId(),
			'status'		=> 'active'
		);

		$lastInsertId = $this->_dbTable->save($data, $id);
		return $lastInsertId;
	}
}