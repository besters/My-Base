<?php

class Mybase_Form_Milestone extends Unodor_Form
{

   public function init()
   {
      $projectId = $this->getProjectId();

      $this->addElement('text', 'name', array(
          'label' => "Milestone name:",
          'class' => 'input-text-big',
          'description' => 'Nějaký dlooouhatananananánský popisek formulářového pole',
          'required' => true,
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('datepicker', 'calendar', array(
          'decorators' => $this->setInputDecorators('calendar')
      ));

      $priority = new Model_Priority();
      $this->addElement('select', 'idpriority', array(
          'label' => "Priority:",
          'multiOptions' => $priority->getFormSelect(null, '--- None ---'),
          'disableTranslator' => true,
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('select', 'status', array(
          'label' => "Status:",
          'multiOptions' => array('active' => 'Active', 'paused' => 'Paused'),
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $milestone = new Model_Milestone();
      $this->addElement('select', 'parent', array(
          'label' => "Parent milestone:",
          'multiOptions' => $milestone->getParentMilestonesList($projectId, '--- None ---'),
          'disableTranslator' => true,
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      /*
       * this->addElement('text', 'check', array(
       * class' => 'milestone-datetime',
       * readonly' => 'readonly',
       * label' => "Due date:",
       * description' => 'Select a date from the calendar',
       * decorators' => $this->setInputDecorators('half left')
       * ); */

      $this->addElement('hidden', 'datetime', array(
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('textarea', 'description', array(
          'label' => "Description:",
          'class' => 'input-textarea',
          'rows' => 6,
          'decorators' => $this->setInputDecorators('clear')
      ));

      $user = new Model_UserMeta();
      $this->addElement('multiCheckbox', 'users', array(
          'label' => 'Assignments: ',
          'required' => true,
          'disableTranslator' => true,
          'multiOptions' => $user->getProjectUsers($projectId),
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('submit', 'save', array(
          'value' => 'Create Milestone',
          'class' => 'input-submit',
          'decorators' => $this->setSubmitDecorators('milestone')
      ));
   }

}
