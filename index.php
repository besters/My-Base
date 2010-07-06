<?php

define('ROOT_PATH', realpath(dirname(__FILE__)));

define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'production'));

define('APP_PATH', ROOT_PATH . '/application');

define('LIB_PATH', ROOT_PATH . '/library');

define('MODULE_PATH', APP_PATH . '/modules');

define('CONFIG_PATH', APP_PATH . '/configs');

define('LANGUAGES_PATH', ROOT_PATH . '/languages');

set_include_path(implode(PATH_SEPARATOR, array(
            LIB_PATH,
            get_include_path(),
        )));

require_once 'Zend/Loader/Autoloader.php';

$loader = Zend_Loader_Autoloader::getInstance();

$loader = new Zend_Loader_Autoloader_Resource(array(
            'namespace' => '',
            'basePath' => APP_PATH,
        ));

$loader->addResourceType('model', 'models/', 'Model');
$loader->addResourceType('mybaseForm', 'modules/mybase/forms/', 'Mybase_Form');
//$loader->addResourceType('Form', 'modules/frontend/forms/', 'Form');

$sessName = "PHPSESSID";
$sessOptions = array('name' => $sessName);

if((stripos($_SERVER['REQUEST_URI'], '__tkn') !== false) && preg_match('#__tkn=([a-z\d]{25,30})#si', $_SERVER['REQUEST_URI'], $matches)
        && ( stripos($_SERVER["HTTP_COOKIE"], $matches[1]) === false)){
   $sid = $matches[1];

   $prefix = '';
   if(!empty($_SERVER["HTTP_COOKIE"])){
      $prefix = '; ';
   }

   $_SERVER["HTTP_COOKIE"] .= $prefix . $sessName . '=' . $sid;
   $_COOKIE[$sessName] = $sid;

   Zend_Session::setId($sid);
}

Zend_Session::setOptions($sessOptions);

$application = new Zend_Application(
                APP_ENV,
                CONFIG_PATH . '/application.ini'
);

function d($data, $label = null)
{
   Zend_Debug::dump($data, $label);
}

$application->bootstrap()->run();