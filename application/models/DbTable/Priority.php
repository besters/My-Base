<?php

class Model_DbTable_Priority extends Unodor_Db_Table
{
   protected $_name = 'priority';
   protected $_primary = 'idpriority';
   protected $_sequence = true;
   protected $_dependentTables = array('Milestone', 'Ticket');
   protected $_referenceMap = array(
       'Account' => array(
           'columns' => array('idaccount'),
           'refTableClass' => 'Account',
           'refColumns' => array('idaccount')
       )
   );
}

