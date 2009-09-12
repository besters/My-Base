<?php
class Unodor_Form_Decorator_CheckBox extends Zend_Form_Decorator_Abstract
{
    public function buildLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();    
        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }

        return $element->getView()->formLabel($element->getName(), $label);
    }

    public function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;
        return $element->getView()->$helper(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
    }

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
        $label     = $this->buildLabel();
        $input     = $this->buildInput();    


        $output = '<dt id="'.$element->getName().'-label">&nbsp;</dt>
					<dd id="'.$element->getName().'-element">'
                . $input 
                . $label				            
                . '</dd>';

        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
            case (self::APPEND):
            default:
                return $content . $separator . $output;
        }
    }
}