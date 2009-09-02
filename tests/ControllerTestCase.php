<?php
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase {

	protected $application;
	
	public function setUp(){
		$this->application = new Zend_Application(APP_ENV, CONFIG_PATH . '/application.ini');
		$this->bootstrap = array($this, 'appBootstrap');
		parent::setUp();
	}
	
	public function appBootstrap(){
		$this->application->bootstrap();
	}
}
