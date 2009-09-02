<?php
class IndexController extends Zend_Controller_Action
{
	public function init()
	{
		
		$writer = new Zend_Log_Writer_Firebug();
		$logger = new Zend_Log($writer);
		
		$logger->addPriority('LOGD', 8);
		$writer->setPriorityStyle(8, 'LOG');
		
		$logger->addPriority('ERROR', 9);
		$writer->setPriorityStyle(9, 'ERROR');
		
		$logger->addPriority('TRACE', 10);
		$writer->setPriorityStyle(10, 'TRACE');
			
		$logger->addPriority('EXCEPTION', 11);
		$writer->setPriorityStyle(11, 'EXCEPTION');
		
		$logger->addPriority('TABLE', 12);
		$writer->setPriorityStyle(12, 'TABLE');		
					
		$logger->logd($_SERVER);
		$logger->info($_SERVER);
		$logger->warn($_SERVER);
		$logger->error($_SERVER);
		$logger->trace($_SERVER);
		
		try  { 
		 throw new Exception ( 'Test Exception' ); 
		 } catch ( Exception $e ) { 
		     $logger->exception($e); 
		 }
		
		$logger->table(	array ( '2 SQL queries took 0.06 seconds' , // table title 
						 array ( 
						 array ( 'SQL Statement' , 'Time' , 'Result' ), // table header 
						 array ( 'SELECT * FROM Foo' , '0.02' , array ( 'row1' , 'row2' )), // 1. row 
						 array ( 'SELECT * FROM Bar' , '0.04' , array ( 'row1' , 'row2' )) // 2. row 
						     ) 
						 ));

	}
	
	public function indexAction()
	{
		echo 'Index Action of Index Controller of Default Module';
	}	
}
