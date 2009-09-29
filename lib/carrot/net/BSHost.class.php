<?php
/**
 * @package org.carrot-framework
 * @subpackage net
 */

/**
 * ホストコンピュータ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSHost.class.php 1522 2009-09-22 06:38:56Z pooza $
 */
class BSHost implements BSAssignable {
	protected $address;
	protected $name;

	/**
	 * @access public
	 * @param string $address ホスト名又はIPアドレス
	 */
	public function __construct ($address) {
		require_once('Net/IPv4.php');
		$this->address = new Net_IPv4;

		if (mb_ereg('^[.[:digit:]]+$', $address)) {
			$this->setAddress($address);
		} else {
			$this->setName($address);
		}
	}

	/**
	 * IPアドレスを返す
	 *
	 * @access public
	 * @return string IPアドレス
	 */
	public function getAddress () {
		return $this->getAttribute('ip');
	}

	/**
	 * IPアドレスを設定
	 *
	 * @access public
	 * @param string $address IPアドレス
	 */
	public function setAddress ($address) {
		$this->setAttribute('ip', $address);
		if (!$this->address->validateIP($address)) {
			throw new BSNetException($this . 'を名前解決できません。');
		}
	}

	/**
	 * ホスト名を返す
	 *
	 * @access public
	 * @return string FQDNホスト名
	 */
	public function getName () {
		if (!$this->name) {
			if (BS_NET_RESOLVABLE) {
				$this->name = gethostbyaddr($this->getAddress());
			} else {
				$this->name = $this->getAddress();
			}
		}
		return $this->name;
	}

	/**
	 * ホスト名を設定
	 *
	 * @access public
	 * @param string $name FQDNホスト名
	 */
	public function setName ($name) {
		if (BSString::isBlank($address = gethostbyname($name))) {
			throw new BSNetException($name . 'は正しくないFQDN名です。');
		}
		$this->name = $name;
		$this->setAddress($address);
	}

	/**
	 * 名前解決が可能か？
	 *
	 * @access public
	 * @return boolean 可能ならばTrue
	 */
	public function isExists () {
		try {
			return !BSString::isBlank($this->getName());
		} catch (BSNetException $e) {
			return false;
		}
	}

	/**
	 * 属性を返す
	 *
	 * @access public
	 * @param string $name 属性の名前
	 * @param mixed 属性
	 */
	public function getAttribute ($name) {
		return $this->address->$name;
	}

	/**
	 * 属性を設定
	 *
	 * @access public
	 * @param string $name 属性の名前
	 * @param mixed $value 値
	 */
	public function setAttribute ($name, $value) {
		$this->address->$name = $value;
	}

	/**
	 * 全ての属性を返す
	 *
	 * @access public
	 * @return mixed[] 全ての属性
	 */
	public function getAttributes () {
		$values = get_object_vars($this->address);
		$values['name'] = $this->getName();
		return $values;
	}

	/**
	 * インスタンスはネットワーク内のノードか？
	 *
	 * @access public
	 * @param BSNetwork $network 評価対象ネットワーク
	 * @return boolean ネットワーク内ならTrue
	 */
	public function isInNetwork (BSNetwork $network) {
		return $this->address->ipInNetwork($this->getAddress(), $network->getCIDR());
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignValue () {
		return $this->getAttributes();
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return $this->getAddress();
	}
}

/* vim:set tabstop=4: */
