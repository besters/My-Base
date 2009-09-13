<?php
class Mybase_AccountController extends Unodor_Controller_Action
{
	public function indexAction()
	{
		$this->disableMvc(false, true);
	}	
}