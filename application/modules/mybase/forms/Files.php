<?php

class Mybase_Form_Files extends Unodor_Form
{
	public function init()
	{
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
