<?php

/**
 * isEditable view helper
 *
 */
class Unodor_View_Helper_isEditable extends Zend_View_Helper_Abstract
{

   /**
    * Zjistuje jestli lze editovat daneho uzivatele
    *
    * @param array $data pole obsahujici data o uzivateli a id vedouciho
    * @param string $mode Edit nebo Delete
    * @return bool
    */
   public function isEditable($data, $mode)
   {
      $userModel = new Model_UserMeta();
      $user = $userModel->getUserId();

      switch($mode){
         case 'edit':

            // jsem to ja
            if($data[0]['iduser'] == $user)
               return false;

            // je to admin
            if($data[0]['administrator'] == '1')
               return false;

            // je to leader
            if($data[1] == $data[0]['iduser'])
               return false;

            break;
         case 'delete':

            //jsem to ja
            if($data[0]['iduser'] == $user)
               return false;

            // je to leader
            if($data[1] == $data[0]['iduser'])
               return false;

            break;
      }

      return true;
   }

}

