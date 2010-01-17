<?php

class Unodor_Form extends Zend_Form
{	
	
	public function __construct($options = null)
	{		
		$spec = array(
			array('prefix' => 'Unodor_Form_Element', 'path' => 'Unodor/Form/Element', 'type' => Zend_Form::ELEMENT),
			array('prefix' => 'Unodor_Form_Decorator', 'path' => 'Unodor/Form/Decorator', 'type' => Zend_Form::DECORATOR)
		);
		
		$this->addPrefixPaths($spec);
		
		$this->setMethod('post');
		
		parent::__construct($options);
	}
	
	protected function getAccountId()
	{
		$account = new Model_Account();
		return $account->getId();
	}
	
	protected function getProjectId()
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();
		return $request->getParam('projekt');
	}
	
	public function loadDefaultDecorators()
	{
		$this->setDecorators(array(
			'FormElements',
			array('FormErrors', array('placement' => 'prepend')),
			'Form'
		));
	}	
	
	protected function setInputDecorators($class = null)
	{
		$defaultElementDecorators = array(
			'label', 
			'ViewHelper', 
			'Errors', 
			array('Description'),
			array('HtmlTag', array('tag' => 'div', 'class' => 'input '.$class))
		);
		
		return $defaultElementDecorators;
	}
	
	protected function setFileDecorators($class = null)
	{
		$defaultElementDecorators = array(
			'label', 
			'File', 
			'Errors', 
			array('Description'),
			array('HtmlTag', array('tag' => 'div', 'class' => 'input '.$class))
		);
		
		return $defaultElementDecorators;
	}
	
	protected function setSubmitDecorators($class = null)
	{
		$defaultSubmitDecorators = array(
			array('Submit', array('cancel' => $class)), 
			array('HtmlTag', array('tag' => 'div', 'class' => 'input submit'))
		);
		
		return $defaultSubmitDecorators;
	}
}