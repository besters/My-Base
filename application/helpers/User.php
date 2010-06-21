<?php

class Unodor_View_Helper_User extends Zend_View_Helper_Abstract
{

   public function User($id, $nameFirst = false)
   {
      foreach($this->view->users as $user){
         if($user['iduser'] == $id){
            if($nameFirst == true){
               return $user['name'] . ' ' . $user['surname'];
            }
            return $user['surname'] . ' ' . $user['name'];
         }
      }
      return $id;
   }

}

