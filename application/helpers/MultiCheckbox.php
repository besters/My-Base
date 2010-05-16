<?php

/**
 * Helper generujici dvojrozmerny seznam checkboxu
 *
 */
class Unodor_View_Helper_MultiCheckbox extends Zend_View_Helper_FormRadio
{
   /**
    * Typ inputu
    * @var string
    */
   protected $_inputType = 'checkbox';
   /**
    * Jsou data ve formatu pole, nebo ne
    * @var bool
    */
   protected $_isArray = true;

   /**
    * Generuje skupinu checkboxu
    *
    * @param string|array $name If a string, the element name.  If an
    * array, all other parameters are ignored, and the array elements
    * are extracted in place of added parameters.
    *
    * @param mixed $value The checkbox value to mark as 'checked'.
    *
    * @param array $options An array of key-value pairs where the array
    * key is the checkbox value, and the array value is the radio text.
    *
    * @param array|string $attribs Attributes added to each radio.
    *
    * @return string The radio buttons XHTML.
    */
   public function MultiCheckbox($name, $value = null, $attribs = null, $options = null, $listsep = "\n")
   {
      $return = '';
      foreach($options as $key => $val){
         $attribs['listsep'] = "\n";
         $id = $attribs['id'];
         $ex = explode(';', $key);

         $attribs['id'] = 'company';

         $return .= '<fieldset><div class="user-assign-company">';
         $return .= $this->formRadio('company[]', $value, $attribs, array($ex[1] => $ex[0]), $listsep);
         $return .= '</div>';

         $attribs['id'] = $id;

         $return .= '<div class="user-assign">';
         $return .= $this->formRadio($name, $value, $attribs, $options[$key], $listsep);
         $return .= '</div></fieldset>';
      }

      return $return;
   }

}
