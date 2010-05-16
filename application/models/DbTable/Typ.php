<?php

class Model_DbTable_Typ extends Unodor_Db_Table
{
   protected $_name = 'typ';
   protected $_primary = 'idtyp';
   protected $_sequence = true;
   protected $_dependentTables = array('Ticket');
   protected $_referenceMap = array(
       'Account' => array(
           'columns' => array('idaccount'),
           'refTableClass' => 'Account',
           'refColumns' => array('idaccount')
       )
   );
}

