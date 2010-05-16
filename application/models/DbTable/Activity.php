<?php

class Model_DbTable_Activity extends Unodor_Db_Table
{
   protected $_name = 'activity';
   protected $_primary = 'idactivity';
   protected $_sequence = true;
   protected $_referenceMap = array(
       'User' => array(
           'columns' => array('iduser'),
           'refTableClass' => 'User',
           'refColumns' => array('iduser')
       )
   );
}

