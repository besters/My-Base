<?php

class Mybase_Form_Project extends Unodor_Form
{
	public function init()
	{
		$this->addElement('text','name', array(
			'label' => "Project name:",
			'class'	=> 'input-text',
			'required' => true,
			'validators' => array(
				array('stringLength', false, array(3, 100))
			),
			'decorators' => $this->setInputDecorators()
		));

		$this->addElement('textarea','description', array(
			'label' => "Description:",
			'class'	=> 'input-textarea',
			'rows'	=> 6,
			'decorators' => $this->setInputDecorators()
		));

		$user = new Model_User();
		$company = new Model_Company();
			
		$companyData = $company->getFormSelect(null, '--- None ---');
			
		// TODO: automaticky nastavit autora projektu jako selected
		$this->addElement('select', 'iduser', array(
			'label' => "Project leader:",
			'multiOptions' => $user->getFormSelect(null, $companyData),
			'class' => 'input-select',
			'required' => true,
			'decorators' => $this->setInputDecorators()
		));

		$this->addElement('select', 'idcompany', array(
			'label' => "Client company:",
			'multiOptions' => $companyData,
			'class' => 'input-select',
			'decorators' => $this->setInputDecorators()
		));

		$this->addElement('file', 'img', array(
			'label' => "Image:",
			'class'	=> 'input-file',
			'decorators' => $this->setFileDecorators()
		));

		$this->addElement('submit', 'save', array(
			'value' => "Create project",
			'class'	=> 'input-submit',
			'decorators' => $this->setSubmitDecorators('project')
		));
	}
}
