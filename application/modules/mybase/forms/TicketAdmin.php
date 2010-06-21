<?php

class Mybase_Form_TicketAdmin extends Unodor_Form
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

      $priority = new Model_Priority();
      $this->addElement('select', 'idpriority', array(
          'label' => "Priority:",
          'multiOptions' => $priority->getFormSelect(null, '--- None ---'),
          'disableTranslator' => true,
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $typ = new Model_Typ();
      $this->addElement('select', 'idtyp', array(
          'label' => "Typ:",
          'multiOptions' => $typ->getFormSelect(null, '--- None ---'),
          'disableTranslator' => true,
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('select', 'status', array(
          'label' => "Status:",
          'multiOptions' => array('open' => 'Open', 'in_progress' => 'In progress', 'reopened' => 'Reopened', 'resolved' => 'Resolved', 'closed' => 'Closed', 'postponed' => 'Postponed'),
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $milestone = new Model_Milestone();
      $this->addElement('select', 'idmilestone', array(
          'label' => "Milestone:",
          'multiOptions' => $milestone->getParentMilestonesList($projectId, '--- None ---'),
          'disableTranslator' => true,
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('half left')
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
          'value' => 'Create Ticket',
          'class' => 'input-submit',
          'decorators' => $this->setSubmitDecorators('ticket')
      ));
   }

}
