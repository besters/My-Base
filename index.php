<?php

define('ROOT_PATH', realpath(dirname(__FILE__))) ;

define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'production'));

define('APP_PATH', ROOT_PATH . '/application');

define('LIB_PATH', ROOT_PATH . '/library' ) ;

define('MODULE_PATH', APP_PATH . '/modules') ;

define('CONFIG_PATH', APP_PATH . '/configs') ;

set_include_path(implode(PATH_SEPARATOR, array(
    LIB_PATH,
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';

$loader = Zend_Loader_Autoloader::getInstance();

$loader = new Zend_Loader_Autoloader_Resource(array(
    'namespace' => '',
    'basePath'  => APP_PATH,
));

//$loader->addResourceType('model', 'models/', 'Model');
//$loader->addResourceType('adminForm', 'modules/backend/forms/', 'Admin_Form');
//$loader->addResourceType('Form', 'modules/frontend/forms/', 'Form');



$application = new Zend_Application(
    APP_ENV,
    CONFIG_PATH . '/application.ini'
);

$application->bootstrap()->run();