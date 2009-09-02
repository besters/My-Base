<?php 
class Unodor_Layout_Module extends Zend_Layout_Controller_Plugin_Layout 
{ 
    public function preDispatch (Zend_Controller_Request_Abstract $request) 
    { 
        $moduleName = $request->getModuleName(); 
        switch ($moduleName) { 
            case $moduleName: 
                $this->_moduleChange($moduleName); 
                break; 
        } 
    } 

    protected function _moduleChange ($moduleName) 
    { 
    	$this->getLayout()->setLayout($moduleName);
    } 
} 