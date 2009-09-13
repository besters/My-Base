<?php
class Mybase_ProjectController extends Unodor_Controller_Action
{
	public function indexAction()
	{
		$this->disableMvc(false, true);
	}	
}