<?php

class Mybase_Form_Project extends Zend_Form
{
	public function __construct()
	{
		$this->addElementPrefixPath('Unodor_Form_Decorator', 'Unodor/Form/Decorator/', 'decorator');
		$this->setMethod('post')->setLegend('Stránka');
		
		$this->addElement('text','name', array(
				'order' => 0,
			    'label' => "Název projektu:",
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
			    'label' => "Stručný popis:",
			    'class'	=> 'input-textarea',
				'rows'	=> 6,
			    'required' => true,
			));	
			
			$this->addElement('select', 'iduser', array(
				'order' => 2,
			    'label' => "Pamatovat přihlášení",
				'class' => 'input-select'
			));	
			
			$this->addElement('select', 'idcompany', array(
				'order' => 3,
			    'label' => "Pamatovat přihlášení",
				'class' => 'input-select'
			));	
										
			$this->addElement('file', 'img', array(
				'order' => 4,
			    'label' => "Přihlásit",
			    'class'	=> 'input-file',

			));	   
										
			$this->addElement('submit', 'save', array(
				'order' => 5,
			    'label' => "Přihlásit",
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
