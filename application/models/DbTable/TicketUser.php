<?php

class Model_DbTable_TicketUser extends Unodor_Db_Table
{
   protected $_name = 'ticketuser';
   protected $_primary = 'idticketuser';
   protected $_sequence = true;
   protected $_referenceMap = array(
       'Ticket' => array(
           'columns' => array('idticket'),
           'refTableClass' => 'Ticket',
           'refColumns' => array('idticket')
       ),
       'User' => array(
           'columns' => array('iduser'),
           'refTableClass' => 'User',
           'refColumns' => array('iduser')
       )
   );
}

