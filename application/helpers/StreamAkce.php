<?php

class Unodor_View_Helper_StreamAkce extends Zend_View_Helper_Abstract
{
   public function streamAkce($typ, $user)
   {
      switch($typ){
	 case Model_Stream::AKCE_CREATED :
	    $text = 'created by';
	    break;
	 case Model_Stream::AKCE_CHANGED :
	    $text = 'edited by';
	    break;
	 case Model_Stream::AKCE_REPORTED :
	    $text = 'reported by';
      }

      $return = $text . ' <a href="/people/detail/'.$user->iduser.'">'.$user->name . ' ' . $user->surname.'</a>';

      return $return;
   }
}

