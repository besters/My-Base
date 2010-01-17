<?php
class Unodor_Form_Decorator_Description extends Zend_Form_Decorator_Abstract
{
    /**
     * Render a description
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $description = $element->getDescription();
        $description = trim($description);

        if (!empty($description) && (null !== ($translator = $element->getTranslator()))) {
            $description = $translator->translate($description);
        }

        if (empty($description)) {
            return $content;
        }

			$description = '<img src="/public/design/ico-question.png" title="'.$description.'" class="description" />';
         
			return $content .  $description;
    }
}
