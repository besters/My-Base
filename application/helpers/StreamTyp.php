<?php

class Unodor_View_Helper_StreamTyp extends Zend_View_Helper_Abstract
{

   public function streamTyp($typ)
   {
      switch($typ){
	 case Model_Stream::TYP_PROJECT :
	    $class = 'project';
	    $text = 'Project';
	    break;
	 case Model_Stream::TYP_MILESTONE :
	    $class = 'milestone';
	    $text = 'Milestone';
	    break;
	 case Model_Stream::TYP_TICKET :
	    $class = 'ticket';
	    $text = 'Ticket';
      }

      return $text;
   }
}

