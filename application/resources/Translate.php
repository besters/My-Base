<?php

/**
 * Application Resource ktera nastavuje preklady
 */
class Resource_Translate extends Zend_Application_Resource_ResourceAbstract
{
   /**
    * @var object Objekt s informacemi o aktualnim jazyku
    */
   private $_lang;

   /**
    * Defined by Zend_Application_Resource_Resource
    *
    */
   public function init()
   {
      return $this->setLanguage();
   }

   /**
    * Nastavuje funkcionalitu prekladani
    *
    * @return void
    * @todo nastavit cache pro Zend_Locale + otestovat vykon
    * @todo nastaveni Zend_Locale podle nastaveni v db
    * @todo pouziti $locale->getLanguage nebo neco podobneho - mohlo by to zkratit switch, pripadne by se nove jazyky mohly pridavat pres admin rozhrani
    */
   public function setLanguage()
   {
      $options = $this->getOptions();

      $locale = new Zend_Locale();

      switch($locale){
         case 'cs_CZ':
            $this->_lang->code = 'cs';
            $this->_lang->locale = $locale;
            $this->_lang->name = 'Czech';
            break;
         case 'de_AT':
         case 'de_BE':
         case 'de_CH':
         case 'de_DE':
         case 'de_LI':
         case 'de_LU':
         case 'de':
            $this->_lang->code = 'de';
            $this->_lang->locale = 'de';
            $this->_lang->name = 'German';
            break;
         default:
            $this->_lang->code = 'en';
            $this->_lang->locale = 'en_US';
            $this->_lang->name = 'English';
            break;
      }

      $locale->setLocale($this->_lang->locale); // Nastaveni locale - nejspis se to nastavi nekde v pluginu podle preferenci uzivatele a ulozi do registru nebo session
      Zend_Registry::set('Zend_Locale', $locale);

      $manager = $this->getBootstrap()->getResource('CacheManager');
      $cache = $manager->getCache('translate');

      Zend_Translate::setCache($cache);

      if(isset($options['logUntranslated']) AND $options['logUntranslated']== true){
         $writer = new Unodor_Log_Writer_Translate(LANGUAGES_PATH . '/source/stringtable.php');

         $log = new Zend_Log();
         $log->addWriter($writer);

         $options = array(
             'log' => $log,
             'logUntranslated' => true,
             'logMessage' => 'gettext(%message%);'
         );
      }

      $translate = new Zend_Translate('Unodor_Translate_Adapter_Gettext', LANGUAGES_PATH . '/' . $this->_lang->name . '.mo', $this->_lang->code, $options);

      Zend_Registry::set('Zend_Translate', $translate);
   }

}
