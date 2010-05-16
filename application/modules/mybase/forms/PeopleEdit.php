<?php

class Mybase_Form_PeopleEdit extends Unodor_Form
{

   public function init()
   {
      $this->addElement('text', 'mail', array(
          'label' => "E-mail:",
          'class' => 'input-text',
          'required' => true,
          'validators' => array(
              array('EmailAddress')
          ),
          'decorators' => $this->setInputDecorators()
      ));

      $company = new Model_Company();
      $companyData = $company->getFormSelect(null);

      $this->addElement('select', 'idcompany', array(
          'label' => "Company:",
          'multiOptions' => $companyData,
          'class' => 'input-select',
          'required' => true,
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('text', 'mobile', array(
          'label' => "Mobile:",
          'class' => 'input-text',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('text', 'work', array(
          'label' => "Office:",
          'class' => 'input-text',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('text', 'home', array(
          'label' => "Home:",
          'class' => 'input-text',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('text', 'im', array(
          'label' => "IM:",
          'class' => 'input-text',
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('select', 'imservice', array(
          'label' => "",
          'multiOptions' => array('msn' => 'MSN', 'icq' => 'ICQ', 'aol' => 'AOL'),
          'class' => 'input-select',
          'decorators' => $this->setInputDecorators('left')
      ));

      $this->addElement('submit', 'save', array(
          'value' => "Edit",
          'class' => 'input-submit',
          'decorators' => $this->setSubmitDecorators('people')
      ));
   }

}
