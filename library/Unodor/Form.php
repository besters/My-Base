<?php

class Unodor_Form extends Zend_Form
{

   public function __construct($options = null)
   {
      $spec = array(
          array('prefix' => 'Unodor_Form_Element', 'path' => 'Unodor/Form/Element', 'type' => Zend_Form::ELEMENT),
          array('prefix' => 'Unodor_Form_Decorator', 'path' => 'Unodor/Form/Decorator', 'type' => Zend_Form::DECORATOR)
      );

      $this->addPrefixPaths($spec);

      $this->addElementPrefixPath('Unodor_Validate', 'Unodor/Validate/', 'validate');

      $this->setMethod('post');

      parent::__construct($options);
   }

   /**
    * Ziskava ID projektu
    *
    * @return int
    */
   protected function getProjectId()
   {
      $projekt = new Model_Project();
      return $projekt->getId();
   }

   /**
    * Nacita vychozi decoratory pro formular
    */
   public function loadDefaultDecorators()
   {
      $this->setDecorators(array(
          'FormElements',
          //array('FormErrors', array('placement' => 'prepend')),
          'Form'
      ));
   }

   /**
    * Nastavuje vychozi dekoratory pro inputy
    * 
    * @param string $class css trida
    * @param array $decorators pridavne decoratory
    * @return array
    */
   protected function setInputDecorators($class = null, $decorators = array())
   {
      $defaultElementDecorators = array(
          'label',
          'ViewHelper',
          'Errors',
          //array('Description'),
          $decorators,
          array('HtmlTag', array('tag' => 'div', 'class' => 'input ' . $class)),
      );

      return $defaultElementDecorators;
   }

   /**
    * Nastavuje vychozi dekoratory pro file input
    *
    * @param string $class css trida
    * @return array
    */
   protected function setFileDecorators($class = null)
   {
      $defaultElementDecorators = array(
          'label',
          'File',
          'Errors',
          array('Description'),
          array('HtmlTag', array('tag' => 'div', 'class' => 'input ' . $class))
      );

      return $defaultElementDecorators;
   }

   /**
    * Nastavuje vychozi dekoratory pro submit button
    *
    * @param string $class css trida
    * @return array
    */
   protected function setSubmitDecorators($class = null)
   {
      $defaultSubmitDecorators = array(
          array('Submit', array('cancel' => $class)),
          array('HtmlTag', array('tag' => 'div', 'class' => 'input submit clear'))
      );

      return $defaultSubmitDecorators;
   }

}

