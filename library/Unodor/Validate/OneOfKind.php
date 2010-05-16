<?php

/**
 * Alespon jeden ze dvou elementu musi byt vyplnen
 */
class Unodor_Validate_OneOfKind extends Zend_Validate_Abstract
{
   const IS_EMPTY = 'isEmpty';
   
   protected $_messageTemplates = array(
       self::IS_EMPTY => 'Value is required and can\'t be empty'
   );

   public function isValid($value, $context = null)
   {
      if($context['idcompany'] == '' AND $context['company'] == ''){
         $this->_error(self::IS_EMPTY);
         return false;
      }
      return true;
   }

}
