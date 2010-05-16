<?php

/**
 * Action Link View Helper
 *
 */
class Unodor_View_Helper_ActionLink extends Zend_View_Helper_Abstract
{
   public $view;

   /**
    * Vytvari Action Link
    *
    * @param string $href Cil
    * @param string $title Nadpis
    * @param bool $project Projektova podsekce
    * @param bool $delete Prida tridu delete kvuli js confrim
    * @return string Link
    */
   public function ActionLink($href, $title, $project = false, $delete = false)
   {
      $prefix = $project == true ? $this->view->Param('projekt') : '';
      $class = $delete == true ? 'class="delete"' : '';
      return '<a href="' . $this->view->baseUrl($prefix . $href) . '" ' . $class . '><span>' . $this->view->Translate($title) . '</span></a>';
   }

}
