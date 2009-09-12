<?php
class Mybase_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$acl = Zend_Registry::get('acl');
		//echo $acl->isAllowed('marchlik@unodor.cz', 'milestone', 'delete') ? 'allowed' : 'denied';	
		//echo 'Index Action of Index Controller of Mybase Module';
	}	
}