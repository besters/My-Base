<?php

class Model_DbTable_Ticket extends Unodor_Db_Table
{
   protected $_name = 'ticket';
   protected $_primary = 'idticket';
   protected $_sequence = true;
   protected $_dependentTables = array('TicketUser');
   protected $_referenceMap = array(
       'Project' => array(
           'columns' => array('idproject'),
           'refTableClass' => 'Project',
           'refColumns' => array('idproject')
       ),
       'User' => array(
           'columns' => array('iduser'),
           'refTableClass' => 'User',
           'refColumns' => array('iduser')
       ),
       'Milestone' => array(
           'columns' => array('idmilestone'),
           'refTableClass' => 'Milestone',
           'refColumns' => array('idmilestone')
       ),
       'Typ' => array(
           'columns' => array('idtyp'),
           'refTableClass' => 'Typ',
           'refColumns' => array('idtyp')
       ),
       'Priority' => array(
           'columns' => array('idpriority'),
           'refTableClass' => 'Priority',
           'refColumns' => array('idpriority')
       )
   );

   public function getAll($idproject)
   {
      $query = $this->select()
              ->from('ticket', array('idticket', 'iduser', 'idmilestone', 'assignee', 'datetime', 'name', 'description', 'status'))
              //->joinLeftUsing('user_meta', 'iduser', array('name AS firstname', 'surname'))
              //->joinLeft('user_meta AS meta', 'meta.iduser = ticket.assignee', array('name AS assignee'))
              ->joinLeftUsing('milestone', 'idmilestone', array('name AS milestone'))
              ->joinLeftUsing('typ', 'idtyp', array('name AS typ'))
              ->joinLeftUsing('priority', 'idpriority', array('name AS priority', 'color', 'text', 'priority AS priority_num', 'description AS priority_desc'))
              ->where('ticket.idproject = ' . $idproject)
	      ->order('idticket DESC')
              ->setIntegrityCheck(false);

      $count = $this->select()
              ->from('ticket', array('idticket',
               Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 1
            ))
              ->where('ticket.idproject = ' . $idproject);

      //$stmt = $query->query();

      //$result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);


      $result = new Zend_Paginator_Adapter_DbSelect($query);

      //$result->setRowCount($this->select()->from('ticket', array(Zend_Paginator_Adapter_DbSelect::ROW_COUNT_COLUMN => 'idticket')));


      return $result;
   }
}

