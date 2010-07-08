<?php

class Unodor_Image_Graph
{
   const PIE = 'Pie' ;
   
   public static function setType($type)
   {
      $classname = 'Unodor_Image_Graph_' . $type;

      if(!class_exists($classname)){
	 throw new Unodor_Image_Graph_Exception('Class : ' . $classname . ' not exist.');
      }
      
      return new $classname;
   }



}
