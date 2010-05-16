<?php

class Model_DbTable_Category extends Unodor_Db_Table
{
   protected $_name = 'category';
   protected $_primary = 'idcategory';
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

