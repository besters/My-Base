<?php

class Mybase_Form_TicketUser extends Unodor_Form
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

      $this->addElement('textarea', 'description', array(
          'label' => "Description:",
          'class' => 'input-textarea',
          'rows' => 6,
          'decorators' => $this->setInputDecorators('clear')
      ));


      $this->addElement('submit', 'save', array(
          'value' => 'Create Ticket',
          'class' => 'input-submit',
          'decorators' => $this->setSubmitDecorators('ticket')
      ));
   }

}
