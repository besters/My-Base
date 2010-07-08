<?php

/**
 * Trida generujici PIE Graph
 *
 */
class Unodor_Image_Graph_Pie extends Unodor_Image_Graph_Abstract
{
   protected $_completeColor;
   protected $_incompleteColor;
   protected $_completeColorAllocate;
   protected $_incompleteColorAllocate;
   protected $_newImage;
   protected $_oldImage;
   protected $_width;
   protected $_height;
   protected $_percentage;


   /*
    * Metoda pro vytvoreni PIE Grafu
    */
  public function generate($f_image,$n_image)
   {

ImageFilledArc($f_image,  $this->_width,  $this->_height, $this->_width*2,  $this->_height*2, 0 , 300 , $this->_completeColorAllocate, IMG_ARC_PIE);
ImageFilledArc($f_image, $this->_width,  $this->_height, $this->_width*2,  $this->_height*2, 300 , 360 , $this->_incompleteColorAllocate, IMG_ARC_PIE);




 imageantialias($n_image, true);

 imagecopyresampled($n_image,
              $f_image,
              0, 0, 0, 0,
               $this->_width,
	       $this->_height,
	       $this->_width*2,
	       $this->_height*2
      );

     return $this;
   }

   /*
    * Metoda pro vyuziti barev v PIE Grafu
    */
   

   public function setData($percentage = 0)
   {
      $this->_percentage = $percentage;

       
      return $this;
   }

   public function display(){

      parent::display();
      //$this->generate();
      
      
   }

}

