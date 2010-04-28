<?php

define('ROOT_PATH', realpath(dirname(__FILE__))) ;

define('APP_ENV', 'testing');

define('APP_PATH', ROOT_PATH . '/../application');

define('LIB_PATH', ROOT_PATH . '/../library' ) ;

define('MODULE_PATH', APP_PATH . '/modules') ;

define('CONFIG_PATH', APP_PATH . '/configs') ;

define('LANGUAGES_PATH', ROOT_PATH . '/../languages') ;

set_include_path(implode(PATH_SEPARATOR, array(
    LIB_PATH,
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';

$loader = Zend_Loader_Autoloader::getInstance();

$loader->registerNamespace('Unodor_');

$loader = new Zend_Loader_Autoloader_Resource(array(
    'namespace' => '',
    'basePath'  => APP_PATH,
));

$loader->addResourceType('model', 'models/', 'Model');
$loader->addResourceType('mybaseForm', 'modules/mybase/forms/', 'Mybase_Form');

require_once 'ControllerTestCase.php';