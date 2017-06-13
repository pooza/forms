<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage net.mail
 */

/**
 * メール
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSMail extends BSMIMEDocument {
	protected $error;
	protected $file;

	/**
	 * @access public
	 */
	public function __construct () {
		$this->setRenderer($this->createRenderer());
		$this->setHeader('Subject', 'untitled');
		$this->setHeader('Content-Type', $this->getFullType());
		$this->setHeader('Date', BSDate::getNow());
		$this->setHeader('Mime-Version', '1.0');
		$this->setHeader('X-Mailer', $this->controller->getName('en'));
		$this->setHeader('X-Priority', 3);
		$this->setHeader('From', BSAuthorRole::getInstance()->getMailAddress());
		$this->setHeader('To', BSAdministratorRole::getInstance()->getMailAddress());
		if (BS_DEBUG) {
			$this->setHeader('X-Carrot-Debug-Mode', 'yes');
		}
	}

	/**
	 * @access public
	 */
	public function __destruct () {
		if ($file = $this->getFile()) {
			$file->delete();
		}
	}

	/**
	 * 完全なメディアタイプを返す
	 *
	 * @access public
	 * @return string メディアタイプ
	 */
	public function getFullType () {
		$type = new BSStringFormat('%s; charset=%s; format=flowed; delsp=yes;');
		$type[] = $this->getRenderer()->getType();
		$type[] = $this->getRenderer()->getEncoding();
		return $type->getContents();
	}

	/**
	 * メッセージIDを更新
	 *
	 * @access public
	 */
	public function clearMessageID () {
		$this->setHeader('Message-Id', null);
	}

	/**
	 * 既定レンダラーを生成して返す
	 *
	 * @access protected
	 * @return BSRenderer 既定レンダラー
	 */
	protected function createRenderer () {
		$renderer = new BSPlainTextRenderer;
		$renderer->setEncoding('utf-8');
		$renderer->setWidth(38);
		$renderer->setConvertKanaFlag('KV');
		$renderer->setLineSeparator(self::LINE_SEPARATOR);
		$renderer->setOptions(BSPlainTextRenderer::TAIL_LF);
		$renderer->setOptions(BSPlainTextRenderer::FLOWED);
		return $renderer;
	}

	/**
	 * 送信
	 *
	 * @access public
	 * @param string $name 名前
	 * @param string $value 値
	 */
	public function send () {
		self::createSender()->send($this);
	}

	/**
	 * ファイルを生成して返す
	 *
	 * @access public
	 * @return BSFile ファイル
	 */
	public function getFile () {
		if (!$this->file || !$this->file->isExists()) {
			$this->file = BSFileUtility::createTemporaryFile('.eml');
			$this->file->setContents($this->getContents());
			$this->file->setMode(0600);
		}
		return $this->file;
	}

	/**
	 * 全ての宛先を返す
	 *
	 * @access public
	 * @param BSMailAddress $email 送信者
	 */
	public function getRecipients () {
		$recipients = new BSArray;
		foreach (['To', 'Cc', 'Bcc'] as $key) {
			if ($header = $this->getHeader($key)) {
				foreach ($header->getEntity() as $email) {
					$recipients[$email->getContents()] = $email;
				}
			}
		}
		return $recipients;
	}

	/**
	 * 出力可能か？
	 *
	 * @access public
	 * @return boolean 出力可能ならTrue
	 */
	public function validate () {
		try {
			if (BSString::isBlank($this->getHeader('From')->getContents())) {
				throw new BSMailException('送信元アドレスが指定されていません。');
			}
			if (!$this->getRecipients()->count()) {
				throw new BSMailException('宛先アドレスが指定されていません。');
			}
			return true;
		} catch (BSMailException $e) {
			$this->error = $e->getMessage();
			return false;
		}
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @access public
	 * @return string エラーメッセージ
	 */
	public function getError () {
		return $this->error;
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('メール "%s"', $this->getMessageID());
	}

	/**
	 * 送信機能を返す
	 *
	 * @access public
	 * @return BSMailSender 送信機能
	 * @static
	 */
	static public function createSender () {
		$sender = BSLoader::getInstance()->createObject(BS_MAIL_SENDER, 'MailSender');
		if (!$sender || !$sender->initialize()) {
			throw new BSConfigException('BS_MAIL_SENDERが正しくありません。');
		}
		return $sender;
	}
}

