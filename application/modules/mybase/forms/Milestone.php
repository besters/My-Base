<?php

class Mybase_Form_Milestone extends Unodor_Form
{
	public function init()
	{					
		$this->addElement('text', 'name', array(
			'label' => "Milestone name:",
			'class'	=> 'input-text',
			'description' => 'Nějaký dlooouhatananananánský popisek formulářového pole',
			'required'	=> true,
			'decorators' => $this->setInputDecorators()		
		));	
				
		$this->addElement('datepicker', 'calendar', array(
			'decorators' => $this->setInputDecorators('calendar')	
		));

		$priority = new Model_Priority();
		$this->addElement('select', 'idpriority', array(
			'label' => "Priority:",
			'multiOptions' => $priority->getFormSelect($this->getAccountId(), '--- None ---'),
			'disableTranslator'	=> true,
			'class' => 'input-select',
			'decorators' => $this->setInputDecorators()	
		));	

		$this->addElement('select', 'idstatus', array(
			'label' => "Status:",
			'multiOptions' => array('Active', 3 => 'Paused'),
			'class' => 'input-select',
			'decorators' => $this->setInputDecorators()	
		));	

		$this->addElement('select', 'idmilestone', array(
			'label' => "Parent milestone:",
			'multiOptions' => array('1', '2'),
			'disableTranslator'	=> true,
			'class' => 'input-select',
			'decorators' => $this->setInputDecorators()	
		));	
		
		$this->addElement('text', 'datetime', array(
			'class' => 'milestone-datetime',
			'readonly' => 'readonly',
			'label' => "Due date:",
			'description' => 'Select a date from the calendar',
			'decorators' => $this->setInputDecorators()
		));  
			
		$this->addElement('textarea','description', array(
			'label' => "Description:",
			'class'	=> 'input-textarea',
			'rows'	=> 6,
			'decorators' => $this->setInputDecorators('description')	
		)); 
		
		$user = new Model_User();
		$this->addElement('multiCheckbox', 'users', array(
			'label' => 'Assignments: ',
			'required'	=> true,
			'disableTranslator' => true,
			'multiOptions'	=>	$user->getProjectUsers($this->getProjectId()),
			'decorators' => $this->setInputDecorators()
		));
		
		$this->addElement('submit', 'save', array(
			'value' => 'Create Milestone',
			'class'	=> 'input-submit',
			'decorators' => $this->setSubmitDecorators('milestone')
		));	 		
	}	
}
