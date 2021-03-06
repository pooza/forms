<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage net.mime
 */

/**
 * MIMEユーティリティ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSMIMEUtility {
	const ATTACHMENT = 'attachment';
	const INLINE = 'inline';
	const ENCODE_PREFIX = '=?utf-8?B?';
	const ENCODE_SUFFIX = '?=';
	const WITH_SPLIT = 1;
	const WITHOUT_HEADER = 0;
	const WITH_HEADER = 1;
	const IGNORE_INVALID_TYPE = 1;

	/**
	 * @access private
	 */
	private function __construct () {
	}

	/**
	 * 文字列をエンコード
	 *
	 * @access public
	 * @param string $str 対象文字列
	 * @return string Bエンコードされた文字列
	 * @static
	 */
	static public function encode ($str) {
		if (BSString::getEncoding($str) == 'ascii') {
			return $str;
		}

		$str = BSString::convertKana($str, 'KV');
		foreach (BSString::eregMatchAll('[^[:ascii:]]+', $str) as $matches) {
			$word = BSString::convertEncoding($matches[0], 'utf-8');
			$encoded = self::ENCODE_PREFIX . self::encodeBase64($word) . self::ENCODE_SUFFIX;
			$str = str_replace($matches[0], $encoded, $str);
		}
		return $str;
	}

	/**
	 * 文字列をデコード
	 *
	 * @access public
	 * @param string $str 対象文字列
	 * @return string デコードされた文字列
	 * @static
	 */
	static public function decode ($str) {
		$pattern = '=\\?([^\\?]+)\\?([BbQq])\\?([^\\?]+)\\?=';
		foreach (BSString::eregMatchAll($pattern, $str) as $matches) {
			switch (BSString::toLower($matches[2])) {
				case 'b':
					$decoded = self::decodeBase64($matches[3]);
					break;
				case 'q':
					$decoded = self::decodeQuotedPrintable($matches[3]);
					break;
			}
			$decoded = BSString::convertEncoding($decoded, 'utf-8', $matches[1]);
			$str = str_replace($matches[0], $decoded, $str);
		}
		return $str;
	}

	/**
	 * Qエンコードされた文字列をデコード
	 *
	 * @access public
	 * @param string $str 対象文字列
	 * @return string デコードされた文字列
	 * @static
	 */
	static public function decodeQuotedPrintable ($str) {
		return quoted_printable_decode($str);
	}

	/**
	 * Bエンコードされた文字列をデコード
	 *
	 * @access public
	 * @param string $str 対象文字列
	 * @return string デコードされた文字列
	 * @static
	 */
	static public function decodeBase64 ($str) {
		return base64_decode($str);
	}

	/**
	 * 文字列をBエンコード
	 *
	 * @access public
	 * @param string $str 対象文字列
	 * @param integer $flags フラグのビット列
	 *   self::WITH_SPLIT
	 * @return string エンコードされた文字列
	 * @static
	 */
	static public function encodeBase64 ($str, $flags = 0) {
		$str = base64_encode($str);
		if ($flags & self::WITH_SPLIT) {
			$str = chunk_split($str);
		}
		return $str;
	}

	/**
	 * レンダラーのContent-Transfer-Encodingを返す
	 *
	 * BSContentTransferEncodingMIMEHeader::getContentTransferEncodingのエイリアス
	 *
	 * @access public
	 * @param BSRenderer $renderer レンダラー
	 * @return string Content-Transfer-Encoding
	 * @static
	 */
	static public function getContentTransferEncoding (BSRenderer $renderer) {
		return BSContentTransferEncodingMIMEHeader::getContentTransferEncoding($renderer);
	}

	/**
	 * レンダラーの完全なタイプを返す
	 *
	 * BSContentTypeMIMEHeader::getContentTypeのエイリアス
	 *
	 * @access public
	 * @param BSRenderer $renderer 対象レンダラー
	 * @return string メディアタイプ
	 * @static
	 */
	static public function getContentType (BSRenderer $renderer) {
		return BSContentTypeMIMEHeader::getContentType($renderer);
	}

	/**
	 * 規定のメディアタイプを返す
	 *
	 * BSMIMEType::getTypeのエイリアス
	 *
	 * @access public
	 * @param string $suffix サフィックス
	 * @return string メディアタイプ
	 * @static
	 */
	static public function getType ($suffix) {
		return BSMIMEType::getType($suffix);
	}

	/**
	 * メインタイプを返す
	 *
	 * @access public
	 * @param mixed $type タイプ名
	 * @return string メインタイプ
	 * @static
	 */
	static public function getMainType ($type) {
		$header = BSMIMEHeader::create('Content-Type');
		$header->setContents($type);
		return $header['main_type'];
	}

	/**
	 * サブタイプを返す
	 *
	 * @access public
	 * @param mixed $type タイプ名
	 * @return string メインタイプ
	 * @static
	 */
	static public function getSubType ($type) {
		$header = BSMIMEHeader::create('Content-Type');
		$header->setContents($type);
		return $header['sub_type'];
	}

	/**
	 * ファイル名から拡張子を返す
	 *
	 * 拡張子自体が引数になる場合は、ドットをつけて返す。
	 * BSFileの拡張子を調べる場合は、BSFile::getSuffixを使うべき。
	 *
	 * @access public
	 * @param string $filename 拡張子又はファイル名
	 * @return string 拡張子
	 * @static
	 */
	static public function getFileNameSuffix ($filename) {
		return '.' . BSString::explode('.', $filename)->pop();
	}
}

