<?php

class Unodor_View_Helper_StreamAkce extends Zend_View_Helper_Abstract
{
   public function streamAkce($typ)
   {
      switch($typ){
	 case Model_Stream::AKCE_CREATED :
	    $text = 'Created by';
	    break;
	 case Model_Stream::AKCE_CHANGED :
	    $text = 'Edited by';
      }

      return $text;
   }
}

