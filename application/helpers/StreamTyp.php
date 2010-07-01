<?php

class Unodor_View_Helper_StreamTyp extends Zend_View_Helper_Abstract
{

   public function streamTyp($typ)
   {
      switch($typ){
	 case Model_Stream::TYP_PROJECT :
	    $text1 = '<img src="/public/design/ico-folder.png" title="Project" style="float: left" />';
	    $text = 'Project';
	    break;
	 case Model_Stream::TYP_MILESTONE :
	    $text1 = '<img src="/public/design/ico-calendar.png" title="Milestone"  style="float: left" />';
	    $text = 'Milestone';
	    break;
	 case Model_Stream::TYP_TICKET :
	    $text1 = '<img src="/public/design/ico-ticket.png" title="Ticket" style="float: left" />';
	    $text = 'Ticket';
      }

      return $text1;
   }
}

