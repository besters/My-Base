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
	 */
	public function setLanguage()
	{		
		$options = $this->getOptions();
		
		$locale = new Zend_Locale();
		
		//$locale->setLocale('sk_SK'); // Nastaveni locale - nejspis se to nastavi nekde v pluginu podle preferenci uzivatele a ulozi do registru nebo session
		
		switch ($locale) {
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
				$this->_lang->locale = $locale;
				$this->_lang->name = 'German';
				break;			
			default:
				$this->_lang->code = 'en';
				$this->_lang->locale = 'en_US';
				$this->_lang->name = 'English';
				break;
		}

		$frontendOptions = array(
			'automatic_serialization' => true
		);
		
		$backendOptions = array(
			'cache_dir' => './cache'
		);
		
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		
		Zend_Translate::setCache($cache);	

		if(isset($options['log']) AND $options['log']== true){
			$writer = new Unodor_Log_Writer_Translate(LANGUAGES_PATH . '/source/stringtable.php');
			
			$log = new Zend_Log();
			$log->addWriter($writer);		
			
			$options = array(				
				'log' => $log,
				'logUntranslated' => true,
				'logMessage' => '$this->_("%message%");'
			);
		}
		
		$translate = new Zend_Translate('gettext', LANGUAGES_PATH . '/' . $this->_lang->name . '.mo', $this->_lang->code, $options);
		
		Zend_Registry::set('Zend_Translate', $translate);
	}	
}
