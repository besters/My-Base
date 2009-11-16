<?php

class Mybase_Form_Project extends Zend_Form
{
	public function __construct()
	{
		$account = new Model_Account();
		$idaccount = $account->getId();
		
		$this->addElementPrefixPath('Unodor_Form_Decorator', 'Unodor/Form/Decorator/', 'decorator');
		$this->setMethod('post')->setLegend('Stránka');
		
		$this->addElement('text','name', array(
				'order' => 0,
			    'label' => "Project name:",
			    'class'	=> 'input-text',
			    'required' => true,
				'validators' => array(
					//'alnum',
					array('regex', true, array('/^[a-z]+/', 'messages' => 'Musí začínat písmenem')),
					array('stringLength', false, array(6, 20))
				),
				'filters' => array(
					'StringToLower'
				)	
			));	
				
			$this->addElement('textarea','description', array(
				'order' => 1,
			    'label' => "Description:",
			    'class'	=> 'input-textarea',
				'rows'	=> 6,
			));	
						
			$user = new Model_User();	
			$company = new Model_Company();
			
			$companyData = $company->getFormSelect($idaccount, '--- None ---');
			
			// TODO: automaticky nastavit autora projektu jako selected
			$this->addElement('select', 'iduser', array(
				'order' => 2,
			    'label' => "Project leader:",
				'multiOptions' => $user->getFormSelect($idaccount, $companyData),
				'class' => 'input-select'
			));	

			$this->addElement('select', 'idcompany', array(
				'order' => 3,
			    'label' => "Client company:",
				'multiOptions' => $companyData,
				'class' => 'input-select'
			));	
										
			$this->addElement('file', 'img', array(
				'order' => 4,
			    'label' => "Image:",
			    'class'	=> 'input-file',

			));	   
										
			$this->addElement('submit', 'save', array(
				'order' => 5,
			    'label' => "Create project",
			    'class'	=> 'input-submit',

			));	   
	     		
	         $this->setDecorators(array(
			    'FormElements',
				//array('FormErrors', array('placement' => 'prepend')),
				//'Fieldset',
			    //array('HtmlTag', array('tag' => 'table', 'class' => 'nostyle')),
			    'Form'
			));
	}
}
