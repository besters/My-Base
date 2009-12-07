<?php

//TODO nahradit exception tridy
/**
 * Trida ktera obstarava zmensovani obrazku vcetne dynamickeho zmenseni s odstrizenim presahu a prevodu mezi formaty
 *
 */
class Unodor_Image_Resize
{	
	/**
	 * Cesta a nazev zdrojoveho souboru
	 * 
	 * @var string
	 */
	private $file;
	
	/**
	 * Format zdrojoveho obrazku
	 * 
	 * @var string
	 */
	private $format;
	
	/**
	 * GD ukazatel na zdrojovy obrazek 
	 * 
	 * @var resource
	 */
	private $oldImg;
	
	/**
	 * GD resource na zpracovavany thumbnail
	 * 
	 * @var resource
	 */
	private $newImg;
	
	/**
	 * Pole rozmeru zdrojoveho obrazku
	 * 
	 * @var array
	 */
	private $oldSize;
	
	/**
	 * Pole rozmeru zpracovavaneho obrazku
	 * 
	 * @var array
	 */
	private $newSize;
	
	/**
	 * Pole maximalnich moznych rozmeru nahledu
	 * 
	 * @var array
	 */
	private $maxSize;
	
	/**
	 * Konstruktor - Nacita soubor a vytvari z nej zakladni obrazek
	 * 
	 * @param $fileName Nazev souboru
	 * @return void
	 */
	public function __construct($fileName)
	{
		$this->_checkFile($fileName);
		$this->_fileFormat();
		
		switch($this->format){
			case 'JPG':
				$this->oldImg = imagecreatefromjpeg($this->file);
				break;
			case 'PNG':
				$this->oldImg = imagecreatefrompng($this->file);
				break;
			case 'GIF':
				$this->oldImg = imagecreatefromgif($this->file);
				break;
		}
		
		$this->oldSize = array(
			'width' => imagesx($this->oldImg),
			'height'=> imagesy($this->oldImg)
		);
	}
	
	/**
	 * Zmensuje podle zadane vysky, nebo sirky
	 * 
	 * @param $width Sirka
	 * @param $height Vyska
	 * @return Unodor_Image_Resize
	 */
	public function resize($width = 0, $height = 0)
	{		
		if(!is_numeric($width)){
			throw new Zend_Exception('$width must be numeric');
		}
		
		if(!is_numeric($height)){
			throw new Zend_Exception('$height must be numeric');
		}
		
		$this->maxSize = array(
			'width' => (intval($width) > $this->oldSize['width']) ? $this->oldSize['width'] : intval($width),
			'height' => (intval($height) > $this->oldSize['height']) ? $this->oldSize['height'] : intval($height)	
		);
		
		$this->_calcImageSize();
		
		$this->newImg = imagecreatetruecolor($this->newSize['width'], $this->newSize['height']);
		
		imagecopyresampled(	$this->newImg, 
									$this->oldImg, 
									0, 0, 0, 0, 
									$this->newSize['width'], 
									$this->newSize['height'], 
									$this->oldSize['width'], 
									$this->oldSize['height']
								);			
		return $this;
	}

	/**
	 * Zmensi co nejbliz k zadane vysce a sirce a zbytek odstrihne na presne rozmery
	 * 
	 * @param $width Sirka
	 * @param $height Vyska
	 * @return Unodor_Image_Resize
	 */
	public function adaptiveResize($width, $height)
	{	
		if(!is_numeric($width) OR $width == 0){
			throw new Zend_Exception('$width must be numeric bigger then 0');
		}
		
		if(!is_numeric($height) OR $height == 0){
			throw new Zend_Exception('$height must be numeric bigger then 0');
		}
		
		$this->maxSize = array(
			'width' => (intval($width) > $this->oldSize['width']) ? $this->oldSize['width'] : intval($width),
			'height' => (intval($height) > $this->oldSize['height']) ? $this->oldSize['height'] : intval($height)	
		);		
		
		$this->_calcImageStrictSize();	
		
		$this->newImg = imagecreatetruecolor($this->maxSize['width'], $this->maxSize['height']);
		
		$cropX = 0;
		$cropY = 0;
				
		if($this->newSize['width'] > $this->maxSize['width']){
			$cropX = intval(($this->newSize['width'] - $this->maxSize['width']) / 2);
		}elseif($this->newSize['height'] > $this->maxSize['height']){
			$cropY = intval(($this->newSize['height'] - $this->maxSize['height']) / 2);
		}

		imagecopyresampled(	$this->newImg, 
									$this->oldImg, 
									0, 0, $cropX, $cropY, 
									$this->newSize['width'], 
									$this->newSize['height'], 
									$this->oldSize['width'], 
									$this->oldSize['height']
								);		

		return $this;
	}
	
	/**
	 * Posle obrazek do prohlizece
	 * 
	 * @return void
	 */
	public function show()
	{	
		switch($this->format){
			case 'JPG':
				header("Content-type: ".image_type_to_mime_type(IMAGETYPE_JPEG));
				imagejpeg($this->newImg);
				break;
			case 'PNG':
				header("Content-type: ".image_type_to_mime_type(IMAGETYPE_PNG));
				imagepng($this->newImg);
				break;
			case 'GIF':
				header("Content-type: ".image_type_to_mime_type(IMAGETYPE_GIF));
				imagegif($this->newImg);
				break;
		}		
		
		imagedestroy($this->oldImg);	
		imagedestroy($this->newImg);	
	}
	
	/**
	 * Ulozi soubor
	 * 
	 * @var $file Nazev souboru
	 * @var $deleteSource Smazat zdrojovy obrazek
	 * @return void
	 */
	public function save($file, $deleteSource = false)
	{
		$ex = explode('.', $file);
		$format = strtoupper($ex[count($ex)-1]);
		
		switch($format){
			case 'JPG':
				imagejpeg($this->newImg, $file);
				break;
			case 'PNG':
				imagepng($this->newImg, $file);
				break;
			case 'GIF':
				imagegif($this->newImg, $file);
				break;
		}		
		
		imagedestroy($this->oldImg);	
		imagedestroy($this->newImg);		

		if($deleteSource === true){
			unlink($this->file);
		}
	}
	
	/**
	 * Zjistuje jeslti soubor existuje a je citelny
	 * 
	 * @param $fileName Nazev souboru
	 * @return void
	 */
	private function _checkFile($fileName)
	{
		if(!file_exists($fileName)){
			throw new Zend_Exception('File is not exist ' . $fileName);
			return;
		}elseif(!is_readable($fileName)){
			throw new Zend_Exception('File is not readable ' . $fileName);
			return;
		}else{
			$this->file = $fileName;
		}
	}	
	
	/**
	 * Zjistuje typ souboru
	 * 
	 * @return void
	 */
	private function _fileFormat()
	{
		$format = getimagesize($this->file);
		
		if($format === false){
			throw new Zend_Exception('File is not a valid image ' . $this->file);
			return;
		}
		
		$mimeType = isset($format['mime']) ? $format['mime'] : null;
		
		switch($mimeType){
			case 'image/jpeg':
				$this->format = 'JPG';
				break;
			case 'image/png':
				$this->format = 'PNG';
				break;
			case 'image/gif':
				$this->format = 'GIF';
				break;
			default:
				throw new Zend_Exception('Image format is not suported: ' . $mimeType);
		}
	}	
	
	/**
	 * Vypocitava vysku
	 * 
	 * @return array
	 */
	private function _calcHeight()
	{		
		$width = $this->maxSize['height'] / ($this->oldSize['height'] / $this->oldSize['width']);
		
		return array
		(
			'width'	=> ceil($width),
			'height'	=> ceil($this->maxSize['height'])
		);		
	}	
	
	/**
	 * Vypocitava sirku
	 * 
	 * @return array
	 */
	private function _calcWidth()
	{
		$height = $this->maxSize['width'] / ($this->oldSize['width'] / $this->oldSize['height']);

		return array
		(
			'width'	=> ceil($this->maxSize['width']),
			'height'	=> ceil($height)
		);		
	}	
	
	/**
	 * Zjistuje spravne zmensene rozmery souboru
	 * 
	 * @return void
	 */
	private function _calcImageSize()
	{		
		if($this->maxSize['width'] > 0){
			$newSize = $this->_calcWidth();
			if ($this->maxSize['height'] > 0 && $newSize['height'] > $this->maxSize['height']){
				$newSize = $this->_calcHeight();
			}
		}
		
		if($this->maxSize['height'] > 0){
			$newSize = $this->_calcHeight();
			if ($this->maxSize['width'] > 0 && $newSize['width'] > $this->maxSize['width']){
				$newSize = $this->_calcwidth();
			}
		}
		
		$this->newSize = $newSize;
	}
	
	/**
	 * Pocita velikosti pri striktnim zmensovani (s orezem)
	 * 
	 * @return void
	 */
	private function _calcImageStrictSize()
	{
		if($this->maxSize['width'] > $this->maxSize['height']){
			$newSize = $this->_calcWidth();			
		}elseif($this->maxSize['width'] <= $this->maxSize['height']){
			$newSize = $this->_calcHeight();
		}

		$this->newSize = $newSize;
	}
}