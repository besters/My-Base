<?php

class Unodor_Form_Element_MultiCheckbox extends Zend_Form_Element_Multi
{
   /**
    * View helper pouzity pro rendering
    * @var string
    */
   public $helper = 'multiCheckbox';
   /**
    * MultiCheckbox is an array of values by default
    * @var bool
    */
   protected $_isArray = true;
}

