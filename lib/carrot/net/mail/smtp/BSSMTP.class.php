<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mail.smtp
 */

/**
 * SMTPプロトコル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSSMTP.class.php 1812 2010-02-03 15:15:09Z pooza $
 */
class BSSMTP extends BSSocket {
	private $mail;
	private $keywords;
	const TEST = 1;

	/**
	 * @access public
	 * @param mixed $host ホスト
	 * @param integer $port ポート
	 * @param string $protocol プロトコル
	 *   BSNetworkService::TCP
	 *   BSNetworkService::UDP
	 */
	public function __construct ($host = null, $port = null, $protocol = BSNetworkService::TCP) {
		if (BSString::isBlank($host)) {
			$host = new BSHost(BS_SMTP_HOST);
		}
		parent::__construct($host, $port, $protocol);
		$this->setMail(new BSMail);
	}

	/**
	 * ストリームを開く
	 *
	 * @access public
	 */
	public function open () {
		parent::open();
		$command = 'EHLO ' . BSController::getInstance()->getHost()->getName();
		if (!in_array($this->execute($command), array(220, 250))) {
			throw new BSMailException('%sに接続できません。 (%s)', $this, $this->getPrevLine());
		}
		$this->keywords = new BSArray($this->getLines());
	}

	/**
	 * ストリームを閉じる
	 *
	 * @access public
	 */
	public function close () {
		if ($this->execute('QUIT') != 221) {
			throw new BSMailException('%sから切断できません。(%s)',$this, $this->getPrevLine());
		}
		parent::close();
	}

	/**
	 * メールを返す
	 *
	 * @access public
	 * @return BSMail メール
	 */
	public function getMail () {
		return $this->mail;
	}

	/**
	 * メールを設定
	 *
	 * @access public
	 * @param BSMail $mail メール
	 */
	public function setMail (BSMail $mail) {
		$this->mail = $mail;
	}

	/**
	 * 送信
	 *
	 * @access public
	 * @param integer $flags フラグのビット列
	 *   self::TEST テスト送信
	 * @return string 送信完了時は最終のレスポンス
	 */
	public function send ($flags = null) {
		if ($this->getMail()->validate()) {
			$this->getMail()->updateMessageID();
			for ($i = 0 ; $i < self::RETRY_LIMIT ; $i ++) {
				try {
					$this->execute('MAIL FROM:' . $this->getFrom()->getContents());
					foreach ($this->getRecipients($flags) as $email) {
						$this->execute('RCPT TO:' . $email->getContents());
					}
					$this->execute('DATA');
					$this->putLine($this->getMail()->getContents());
					if ($this->execute('.') != 250) {
						throw new BSMailException($this->getPrevLine());
					}
					BSLogManager::getInstance()->put($this->getSentMessage(), $this);
					return $this->getPrevLine();
				} catch (BSMailException $e) {
					sleep(1);
				}
			}
		}
		throw new BSMailException($this->getMail() . 'を送信できません。');
	}

	/**
	 * 送信者を返す
	 *
	 * @access protected
	 * @return BSMailAddress 送信者
	 */
	protected function getFrom () {
		return $this->getMail()->getHeader('From')->getEntity();
	}

	/**
	 * 受信者を返す
	 *
	 * @access protected
	 * @param integer $flags フラグのビット列
	 *   self::TEST テスト送信
	 * @return BSArray 受信者の配列
	 */
	protected function getRecipients ($flags = null) {
		if (BS_DEBUG || ($flags & self::TEST)) {
			$recipients = new BSArray;
			$recipients[] = BSAdministratorRole::getInstance()->getMailAddress();
			return $recipients;
		} else {
			return clone $this->getMail()->getRecipients();
		}
	}

	/**
	 * 送信成功時のメッセージを返す
	 *
	 * @access protected
	 * @return BSStringFormat メッセージ
	 */
	protected function getSentMessage () {
		$recipients = new BSArray;
		foreach ($this->getRecipients() as $email) {
			$recipients[] = $email->getContents();
		}

		$message = new BSStringFormat('%sから%s宛に、%sを送信しました。 (%s)');
		$message[] = $this->getFrom()->getContents();
		$message[] = $recipients->join(',');
		$message[] = $this->getMail();
		$message[] = $this->getPrevLine();
		return $message;
	}

	/**
	 * キーワードを返す
	 *
	 * @access public
	 * @return BSArray キーワード一式
	 */
	public function getKeywords () {
		if (!$this->keywords) {
			$this->keywords = new BSArray;
		}
		return $this->keywords;
	}

	/**
	 * Subjectを設定
	 *
	 * @access public
	 * @param string $subject Subject
	 */
	public function setSubject ($subject) {
		$this->getMail()->setHeader('Subject', $subject);
	}

	/**
	 * X-Priorityヘッダを設定
	 *
	 * @access public
	 * @param integer $priority X-Priorityヘッダ
	 */
	public function setPriority ($priority) {
		$this->getMail()->setHeader('X-Priority', $priority);
	}

	/**
	 * 送信者を設定
	 *
	 * @access public
	 * @param BSMailAddress $email 送信者
	 */
	public function setFrom (BSMailAddress $email) {
		$this->getMail()->setHeader('From', $email);
	}

	/**
	 * 宛先を設定
	 *
	 * @access public
	 * @param BSMailAddress $email 宛先
	 */
	public function setTo (BSMailAddress $email) {
		$this->getMail()->setHeader('To', $email);
	}

	/**
	 * BCCを加える
	 *
	 * @access public
	 * @param BSMailAddress $bcc 宛先
	 */
	public function addBCC (BSMailAddress $bcc) {
		$this->getMail()->getHeader('BCC')->appendContents($bcc);
	}

	/**
	 * 本文を返す
	 *
	 * @access public
	 * @param string $body 本文
	 */
	public function getBody () {
		return $this->getMail()->getBody();
	}

	/**
	 * 本文を設定
	 *
	 * @access public
	 * @param string $body 本文
	 */
	public function setBody ($body) {
		return $this->getMail()->setBody($body);
	}

	/**
	 * コマンドを実行し、結果を返す。
	 *
	 * @access public
	 * @param string $command コマンド
	 * @return boolean 成功ならばTrue
	 */
	public function execute ($command) {
		$this->putLine($command);

		if (!mb_ereg('^([[:digit:]]+)', $this->getLine(), $matches)) {
			throw new BSMailException('不正なレスポンスです。 (%s)', $this->getPrevLine());
		}
		$result = $matches[1];

		if (400 <= $result) {
			throw new BSMailException('%s (%s)', $this->getPrevLine(), $command);
		}
		return $result;
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('SMTPソケット "%s"', $this->getName());
	}

	/**
	 * 規定のポート番号を返す
	 *
	 * @access public
	 * @return integer port
	 */
	public function getDefaultPort () {
		return BSNetworkService::getPort('smtp');
	}
}

/* vim:set tabstop=4: */
