<?php

/**
 * Gravatar View Helper
 *
 */
class Unodor_View_Helper_Gravatar extends Zend_View_Helper_Abstract
{
	/**
	 * Vytvari gravatar
	 * 
	 * @param string $email Emailova adresa
	 * @param int $size Rozmer gravataru
	 * @param string $type Druh gravataru 
	 * @return string Html kod gravataru
	 */
	public function Gravatar($email, $size = 30, $type = 'identicon')
	{
		return '<img src="http://www.gravatar.com/avatar/'.md5($email).'?s='.$size.'&amp;d='.$type.'" alt="gravatar"/>';
	}
}
