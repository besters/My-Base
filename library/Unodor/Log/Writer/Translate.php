<?php

class Unodor_Log_Writer_Translate extends Zend_Log_Writer_Abstract
{
   /**
    * Obsah souboru
    *
    * @var null|string
    */
   protected $_stream = null;

   /**
    * Konstruktor
    *
    * @param string $stream Logovaci soubor
    */
   public function __construct($stream)
   {
      $this->_formatter = new Zend_Log_Formatter_Simple('%message%' . PHP_EOL);

      $this->_stream = $stream;

      $file = file_get_contents($stream);
      if(strstr($file, '<?php') == false)
         file_put_contents($stream, '<?php' . PHP_EOL);
   }

   /**
    * Zapisuje retezec do souboru
    *
    * @param array $event event data
    * @return void
    */
   protected function _write($event)
   {
      $line = $this->_formatter->format($event);

      $file = file_get_contents($this->_stream);
      if(strstr($file, $line) == false)
         file_put_contents($this->_stream, $line, FILE_APPEND);
   }

   public static function factory($config)
   {
      parent::factory($config);
   }

}
