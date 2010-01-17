<?php

/**
 * Submit dekorator
 *
 */
class Unodor_Form_Decorator_Submit extends Zend_Form_Decorator_Abstract
{

	/**
	 * Odkaz na translate objekt
	 * 
	 * @var Zend_Translate
	 */
	private $_translator;

	/**
	 * Sklada Input
	 *
	 */
	public function buildInput()
	{
		$element = $this->getElement();

		if ($translator = $element->getTranslator()) {
			$value = $translator->translate($element->getValue());
			$this->_translator = $translator;
		}
		
		$helper  = $element->helper;
		
		return $element->getView()->$helper(
			$element->getName(),
			$value,
			$element->getAttribs(),
			$element->options
		);
	}

	/**
	 * Vytvari "or Cancel" odkaz za tlacitkem
	 * 
	 * @return string
	 */
	public function buildCancelLink()
	{
		$cancel = $this->getOption('cancel');

		if(!is_null($cancel)){
			$request = Zend_Controller_Front::getInstance()->getRequest();
			$projekt = $request->getParam('projekt');
			if(!is_null($projekt)) $projekt = '/'.$projekt;
			return ' ' . $this->_translator->translate('or') . ' <a href="'.$projekt.'/'.$cancel.'" class="cancel">'.$this->_translator->translate('Cancel').'</a>';
		}

	}

	/**
	 * Renderuje formular
	 *
	 * @param $content
	 */
	public function render($content)
	{
		$element = $this->getElement();

		if (!$element instanceof Zend_Form_Element) {
			return $content;
		}
		if (null === $element->getView()) {
			return $content;
		}

		$separator = $this->getSeparator();
		$placement = $this->getPlacement();
		$input     = $this->buildInput();
		$cancelLink = $this->buildCancelLink();

		$output =  $input . $cancelLink;

		switch ($placement) {
			case (self::PREPEND):
				return $output . $separator . $content;
			case (self::APPEND):
			default:
				return $content . $separator . $output;
		}
	}
}