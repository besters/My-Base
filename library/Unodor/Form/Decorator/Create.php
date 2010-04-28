<?php

/**
 * Create dekorator
 *
 */
class Unodor_Form_Decorator_Create extends Zend_Form_Decorator_Abstract
{
	/**
	 * Vytvari AJAXovy odkaz za elementem
	 *
	 * @return string
	 */
	public function buildCreateLink()
	{
		$desc = $this->getOption('desc');
		$class = $this->getOption('class');

		$element = $this->getElement();
		$translator = $element->getTranslator();

		return '<a href="#" class="create-link '.$class.'">'.$translator->translate($desc).'</a>';

	}

	/**
	 * Renderuje formular
	 *
	 * @param $content
	 */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

		  $createLink = $this->buildCreateLink();

			return $content .  $createLink;
    }
}