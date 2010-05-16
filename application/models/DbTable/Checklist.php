<?php

class Model_DbTable_Checklist extends Unodor_Db_Table
{
   protected $_name = 'checklist';
   protected $_primary = 'idchecklist';
   protected $_sequence = true;
   protected $_referenceMap = array(
       'User' => array(
           'columns' => array('iduser'),
           'refTableClass' => 'User',
           'refColumns' => array('iduser')
       ),
       'Project' => array(
           'columns' => array('idproject'),
           'refTableClass' => 'Project',
           'refColumns' => array('idproject')
       ),
       'Milestone' => array(
           'columns' => array('idmilestone'),
           'refTableClass' => 'Milestone',
           'refColumns' => array('idmilestone')
       )
   );
}

