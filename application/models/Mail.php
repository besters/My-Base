<?php
/**
 * Trida na generovani a posilani emailu
 */
class Model_Mail
{
	/**
	 * View objekt
	 * @var Zend_View
	 */
	private $_view;

	/**
	 * Mail objekt
	 * @var Zend_Mail
	 */
	private $_mail;

	/**
	 * Vyrenderovana sablona
	 * @var string
	 */
	private $_bodyText;

	/**
	 * Data do sablony
	 * @var array
	 */
	private $_data;

	const INVITE = '1';

	/**
	 * Pripravi data a dalsi promenne
	 *
	 * @param array $data Data na vyplneni do sablony emailu
	 * @return Model_Mail
	 */
	public function prepare($data)
	{
		$this->_view = new Zend_View();
		$this->_view->setScriptPath(APP_PATH . '/modules/mybase/views/scripts/emails/');

		$this->_mail = new Zend_Mail('utf-8');
		
		$this->_data = $data;

		return $this;
	}

	/**
	 * Generuje email
	 *
	 * @param const $type Typ emailu
	 * @return Model_Mail
	 */
	public function generate($type)
	{
		switch($type)
		{
			case self::INVITE :
				$this->_invite();
				break;
		}

		return $this;
	}

	/**
	 * Odesle E-mail
	 *
	 * @param string $recipient E-mail prijemce
	 */
	public function send($recipient)
	{
		$this->_mail->setBodyHtml($this->_bodyText);
		$this->_mail->addTo($recipient);
		$this->_mail->send();
	}

	/**
	 * Nastavi odesilatele
	 *
	 * @param string $senderMail e-mail odesilatele
	 * @param string $senderName jmeno odesilatele
	 *
	 * @return Model_Mail
	 */
	public function from($senderMail, $senderName = 'MyBase.cz')
	{
		$this->_mail->setFrom($senderMail, $senderName);
		return $this;
	}

	/**
	 * Generuje uvitaci email
	 *
	 * @return Model_Mail
	 *
	 * @todo neni kompletni
	 */
	private function _invite()
	{
		$salt = 'ofsdmší&;516#@ešěýp-§)údjs861fds';
		$session = new Zend_Session_Namespace('Zend_Auth');

		$this->_view->assign('company', '***COMPANY***');
		$this->_view->assign('name', $this->_data['name']);
		$this->_view->assign('sender', $session->storage->name.' '.$session->storage->surname);
		$this->_view->assign('hash', md5($this->_data['idcompany'].$this->_data['name'].$this->_data['surname'].$this->_data['email'].$salt));
		$this->_view->assign('note', nl2br($this->_data['note']), true);
		$this->_view->assign('mail', $session->storage->email);

		$this->_mail->setSubject('[MyBase.cz] Your account has been created **ALPHA**');
		$this->from('invite@mybase.cz');
		$this->_bodyText = $this->_view->render('invite.phtml');
		return $this;
	}
}
