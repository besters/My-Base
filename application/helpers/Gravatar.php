<?php

class Unodor_View_Helper_Gravatar extends Zend_View_Helper_Abstract
{
	public function Gravatar($email, $size = 30, $default = 'identicon')
	{
		return '<img src="http://www.gravatar.com/avatar/'.md5($email).'?s='.$size.'&d='.$default.'" />';
	}
}
