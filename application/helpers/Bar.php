<?php

/**
 * Zobrazuje progress bar
 * 
 */
class Unodor_View_Helper_Bar extends Zend_View_Helper_Abstract {

	/**
	 * Vypisuje progress bar
	 * 
	 * @param int $fill Procento vyplne
	 * @return string
	 */
	public function Bar($fill)
	{
		return '<div style="width: '.$fill.'%; background-color: #'.$this->Hsb2Hex($fill).'"></div>';
	}	
	
	/**
	 * Prepocitava HSB hodnotu na Hexa kod
	 * 
	 * @param int $fill Cislo 0-100
	 * @return string Hexa kod barvy
	 */
	public function Hsb2Hex($fill) 
	{	
		$hsb = array($fill, 100, 75);
		
		$max = round($hsb[2] * 51 / 20);
		$min = round($max * (1 - $hsb[1] / 100));
		
		if ($min == $max)
			return($max . '+' . $max . '+' . $max);
			
		$d = $max - $min;
		$h6 = $hsb[0] / 60;
		
		if ($h6 <= 1){
			$rgb = array($max, round ($min + $h6 * $d), $min);
		}elseif ($h6 <= 2){
			$rgb = array(round ($min - ($h6 - 2) * $d), $max, $min);
		}elseif ($h6 <= 3){
			$rgb = array($min, $max, round($min + ($h6 - 2) * $d));
		}elseif ($h6 <= 4){
			$rgb = array($min, round($min - ($h6 - 4) * $d), $max);
		}elseif ($h6 <= 5){
			$rgb = array(round($min + ($h6 - 4) * $d), $min, $max);
		}else{
			$rgb = array ($max, $min, round($min - ($h6 - 6) * $d));
		}	
		
		$c = array();
		$c[0] = sprintf("%02s", dechex ($rgb[0]));
		$c[1] = sprintf("%02s", dechex ($rgb[1]));
		$c[2] = sprintf("%02s", dechex ($rgb[2]));
		
		return strtoupper($c[0] . $c[1] . $c[2]);
	}
}