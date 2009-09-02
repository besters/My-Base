<?php

class Resource_View extends Zend_Application_Resource_ResourceAbstract
{

	public function init()
	{
		return $this->getView();
	}

	public function getView()
	{
		$view = new Zend_View();
		$view->doctype('XHTML1_STRICT');
		$view->headTitle()->setSeparator(' | ')->append('MyBase');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
						 //->appendHttpEquiv('X-UA-Compatible', 'IE=EmulateIE7');
		$request = new Zend_Controller_Request_Http();
		$basePath = $request->getBaseUrl();
        

			
		$view->addHelperPath(APP_PATH."/helpers", "Unodor_View_Helper");
		// Add it to the ViewRenderer
		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view);
		// Return it, so that it can be stored by the bootstrap
		return $view;
	}
}
