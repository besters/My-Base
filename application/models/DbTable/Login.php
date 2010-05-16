<?php

class Model_DbTable_Login extends Unodor_Db_Table
{
   protected $_name = 'login';
   protected $_primary = 'idlogin';
   protected $_sequence = true;
   protected $_dependentTables = array('User');
}

