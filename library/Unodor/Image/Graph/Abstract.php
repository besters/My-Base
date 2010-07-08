<?php

/**
 * Trida ktera obstarava tvorbu obrazku podle typu grafu
 * @todo nahradit exception tridy
 *
 */
abstract class Unodor_Image_Graph_Abstract
{
   protected $_width;
   protected $_height;
   protected $_newImage;
   protected $_oldImage;
   protected $_bgColor;
   protected $_bgColorAllocate;
   protected $_borderColor;
   protected $_borderColorAllocate;
   protected $_completeColor;
   protected $_incompleteColor;
   protected $_completeColorAllocate;
   protected $_incompleteColorAllocate;

   /*
    * Abstraktni metody
    */
   abstract public function setData();
   abstract protected function generate($img_o,$img_n);
   /*
    * Metoda na prevod z hexa do RGB pro dalsi pouziti
    * @return Array
    */
   protected function parseRGB($color)
   {
      $rgb_color = sscanf($color, '%2x%2x%2x');
      return $rgb_color;
   }

   /*
    * Metoda na vytvoreni platna pro dalsi akce
    *
    * @return
    */
   protected function _createCanvas()
   {
      $this->_oldImage = ImageCreateTrueColor($this->_width*2,$this->_height*2);
      $this->_newImage = ImageCreateTrueColor($this->_width, $this->_height);//$this->_width, $this->_height);

      //imageantialias($this->_oldImage, true);
      
      return $this;
   }

   /*
    * Metoda na nastaveni rozmeru
    * @return Size
    */
   public function setSize($width, $height = null)
   {

      $this->_width = $width;

      if(isset($height)){
	 $this->_height = $height;
      }else{
	 $this->_height = $width;
      }

      return $this;
   }

   /*
    * Metoda na nastaveni barvy pozadi
    * @return Color
    */
   public function setBackground($color = 'ffffff')
   {

      $this->_bgColor = $this->parseRGB($color);

      return $this;
   }

   protected function _setBackground()
   {
      $percent = $this->_percentage * 3.6 ;
      $this->_bgColorAllocate = ImageColorAllocate($this->_oldImage, $this->_bgColor[0], $this->_bgColor[1], $this->_bgColor[2]);
      imagefilledrectangle($this->_oldImage, 0, 0, $this->_width*2, $this->_height*2, $this->_bgColorAllocate);
     
      return $this;
   }


   public function setBorder($color = 'ffffff')
   {

      $this->_borderColor = $this->parseRGB($color);

      return $this;
   }

   protected function _setBorder()
   {

      $this->_borderColorAllocate = ImageColorAllocate($this->_oldImage, $this->_borderColor[0], $this->_borderColor[1], $this->_borderColor[2]);
      imagearc($this->_oldImage,$this->_width, $this->_height,
          $this->_width*2,  $this->_height*2, 0, 360,  $this->_borderColorAllocate);

      return $this;
   }


   public function setColors()
   {
      $colors = func_get_args();
      if(is_array($colors[0])){
	 $this->_completeColor = $this->parseRGB($colors[0][0]);
	 $this->_incompleteColor = $this->parseRGB($colors[0][1]);
      }elseif(is_array($colors)){
	 $this->_completeColor = $this->parseRGB($colors[0]);
	 $this->_incompleteColor = $this->parseRGB($colors[1]);
      }else{
	 throw new Unodor_Image_Exception('Colors cannot been set ! ');
      }

      return $this;
   }

   protected function _setColors()
   {
      $this->_completeColorAllocate = ImageColorAllocate($this->_oldImage, $this->_completeColor[0], $this->_completeColor[1], $this->_completeColor[2]);
      $this->_incompleteColorAllocate = ImageColorAllocate($this->_oldImage, $this->_incompleteColor[0], $this->_incompleteColor[1], $this->_incompleteColor[2]);

      return $this;
   }

   public function display()
   {
      $this->_createCanvas();
      $this->_setColors();
      $this->_setBackground();
      $this->generate($this->_oldImage,$this->_newImage);
      $this->_setBorder();
      
      header ("Content-type: image/png");

      imagepng($this->_newImage);

     

	  imagedestroy($this->_newImage);
	  //imagedestroy($this->_newImage);
    
   }

}

