<?php

class Mybase_Form_Login extends Unodor_Form
{
	public function init()
	{
		$this->addElement('text','username', array(
			'label' => "E-mail:",
			'class'	=> 'input-text',
			'required' => true,
			'filters' => array(
				'StringToLower'
			)
		));

		$this->addElement('password','password', array(
			'label' => "Heslo:",
			'class'	=> 'input-text',
			'required' => true,
		));
						
		$this->addElement('checkbox', 'remember', array(
			'label' => "Pamatovat přihlášení",
			'class' => 'input-checkbox',
			'decorators' => array(
				'Checkbox',
			)
		));

		$this->addElement('submit', 'save', array(
			'label' => "Přihlásit",
			'class'	=> 'input-submit'
		));
	}
}
