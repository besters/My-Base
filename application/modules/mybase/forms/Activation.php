<?php

class Mybase_Form_Activation extends Unodor_Form
{
	public function init()
	{
		$this->addElement('text','username', array(
			'label' => "Username:",
			'class'	=> 'input-text-big',
			'required' => true,
			'validators' => array(
				array('EmailAddress')
			),
			'decorators' => $this->setInputDecorators()
		));

		$this->addElement('text','password', array(
			'label' => "Password:",
			'class'	=> 'input-text',
			'required' => true,
			'decorators' => $this->setInputDecorators('half left')
		));

		$this->addElement('text','password_check', array(
			'label' => "Password again:",
			'class'	=> 'input-text',
			'required' => true,
			'decorators' => $this->setInputDecorators('half right')
		));

		$this->addElement('submit', 'save', array(
			'value' => "Activate Account",
			'class'	=> 'input-submit',
			'decorators' => $this->setSubmitDecorators()
		));
	}
}
