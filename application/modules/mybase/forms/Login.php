<?php

class Mybase_Form_Login extends Zend_Form
{
	public function __construct()
	{
		$this->addElementPrefixPath('Unodor_Form_Decorator', 'Unodor/Form/Decorator/', 'decorator');
		$this->setMethod('post')->setLegend('Stránka');
		
		$this->addElement('text','email', array(
				'order' => 0,
			    'label' => "E-mail:",
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
				
			$this->addElement('password','password', array(
				'order' => 1,
			    'label' => "Heslo:",
			    'class'	=> 'input-text',
			    'required' => true,
			));	
			
			$this->addElement('checkbox', 'remember', array(
				'order' => 2,
			    'label' => "Pamatovat přihlášení",
				'class' => 'input-checkbox',
				'decorators' => array(
					'Checkbox',
				)
			));	
										
			$this->addElement('submit', 'save', array(
				'order' => 3,
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
