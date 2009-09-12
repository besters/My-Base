<?php
class Unodor_View_Helper_FlashMessages extends Zend_View_Helper_Abstract
{
    public function flashMessages ($translator = NULL)
    {
        $messages = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();
        $statMessages = array();
        $output = '';
        if (count($messages) > 0) {
            foreach ($messages as $message) {
                if (! array_key_exists($message['status'], $statMessages))
                    $statMessages[$message['status']] = array();
                //if ($translator != NULL && $translator instanceof Zend_Translate)
                    //array_push($statMessages[$message['status']], $translator->_($message['message']));
                //else
                    array_push($statMessages[$message['status']], $message['message']);
            }
            foreach ($statMessages as $status => $messages) {
                $output .= '<p class="msg ' . $status . '">';
                if (count($messages) == 1)
                    $output .= $messages[0];
                else {
                    $output .= '<ul>';
                    foreach ($messages as $message)
                        $output .= '<li>' . $message . '</li>';
                    $output .= '</ul>';
                }
                $output .= '</p>';
            }
            return $output;
        } elseif (isset($this->view->flash)) {
            $output .= '<p class="msg ' . $this->view->flash['status'] . '">';
            $output .= $this->view->flash['message'];
            $output .= '</p>';
            print $output;
        }
    }
}
