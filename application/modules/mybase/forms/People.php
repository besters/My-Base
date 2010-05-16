<?php

class Mybase_Form_People extends Unodor_Form
{

   public function init()
   {
      $this->addElement('text', 'email', array(
          'label' => "E-mail:",
          'class' => 'input-text-big',
          'required' => true,
          'validators' => array(
              array('EmailAddress')
          ),
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('text', 'name', array(
          'label' => "Name:",
          'class' => 'input-text',
          'required' => true,
          'decorators' => $this->setInputDecorators('half left')
      ));

      $this->addElement('text', 'surname', array(
          'label' => "Surname:",
          'class' => 'input-text',
          'required' => true,
          'decorators' => $this->setInputDecorators('half right')
      ));

      $company = new Model_Company();
      $companyData = $company->getFormSelect(null, '--- Select ---');

      $this->addElement('select', 'idcompany', array(
          'label' => "Company:",
          'multiOptions' => $companyData,
          'class' => 'input-select',
          'required' => false,
          'allowEmpty' => false,
          'validators' => array(
              'OneOfKind'
          ),
          'decorators' => $this->setInputDecorators('clear idcompany', array('Create', array('desc' => 'Create', 'class' => 'company-select')))
      ));

      $this->addElement('text', 'company', array(
          'label' => "Company:",
          'class' => 'input-text',
          'required' => false,
          'allowEmpty' => false,
          'validators' => array(
              'OneOfKind'
          ),
          'decorators' => $this->setInputDecorators('clear company hide', array('Create', array('desc' => 'Select', 'class' => 'company-create')))
      ));

      $this->addElement('textarea', 'note', array(
          'label' => "Personal Note:",
          'class' => 'input-textarea',
          'rows' => 6,
          'decorators' => $this->setInputDecorators()
      ));

      $this->addElement('submit', 'save', array(
          'value' => "Create User",
          'class' => 'input-submit',
          'decorators' => $this->setSubmitDecorators('people')
      ));
   }

}
