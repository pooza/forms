<?php
/**
 * @package org.carrot-framework
 * @subpackage action
 */

/**
 * アクション
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAction.class.php 2436 2010-11-28 10:47:20Z pooza $
 * @abstract
 */
abstract class BSAction implements BSHTTPRedirector, BSAssignable, BSValidatorContainer {
	protected $name;
	protected $title;
	protected $config;
	protected $module;
	protected $methods;

	/**
	 * @access public
	 * @param BSModule $module 呼び出し元モジュール
	 */
	public function __construct (BSModule $module) {
		$this->module = $module;
	}

	/**
	 * @access public
	 * @param string $name プロパティ名
	 * @return mixed 各種オブジェクト
	 */
	public function __get ($name) {
		switch ($name) {
			case 'controller':
			case 'request':
			case 'user':
				return BSUtility::executeMethod($name, 'getInstance');
			case 'database':
				if ($table = $this->getModule()->getTable()) {
					return $table->getDatabase();
				}
				return BSDatabase::getInstance();
		}
	}

	/**
	 * 実行
	 *
	 * getRequestMethodsで指定されたメソッドでリクエストされた場合に実行される。
	 *
	 * @access public
	 * @return string ビュー名
	 * @abstract
	 */
	abstract public function execute ();

	/**
	 * executeメソッドを実行可能か？
	 *
	 * getDefaultViewに遷移すべきかどうかの判定。
	 * HEAD又は未定義メソッドの場合、GETとしてふるまう。
	 *
	 * @access public
	 * @return boolean executeメソッドを実行可能ならTrue
	 */
	public function isExecutable () {
		if (BSString::isBlank($method = $this->request->getMethod()) || ($method == 'HEAD')) {
			$method = 'GET';
		}
		return $this->getRequestMethods()->isContain($method);
	}

	/**
	 * 初期化
	 *
	 * Falseを返すと、例外が発生。
	 *
	 * @access public
	 * @return boolean 正常終了ならTrue
	 */
	public function initialize () {
		return true;
	}

	/**
	 * デフォルト時ビュー
	 *
	 * getRequestMethodsに含まれていないメソッドから呼び出されたとき、
	 * executeではなくこちらが実行される。
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function getDefaultView () {
		return BSView::SUCCESS;
	}

	/**
	 * エラー時処理
	 *
	 * バリデート結果が妥当でなかったときに実行される。
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function handleError () {
		return BSView::ERROR;
	}

	/**
	 * バリデータ登録
	 *
	 * 動的に登録しなければならないバリデータを、ここで登録。
	 * 動的に登録する必要のないバリデータは、バリデーション定義ファイルに記述。
	 *
	 * @access public
	 */
	public function registerValidators () {
	}

	/**
	 * 論理バリデーション
	 *
	 * registerValidatorsで吸収できない、複雑なバリデーションをここに記述。
	 * registerValidatorsで実現できないか、まずは検討すべき。
	 *
	 * @access public
	 * @return boolean 妥当な入力ならTrue
	 */
	public function validate () {
		return !$this->request->hasErrors();
	}

	/**
	 * 設定を返す
	 *
	 * @access public
	 * @param string $name 設定名
	 * @return mixed 設定値
	 */
	public function getConfig ($name) {
		if (!$this->config) {
			$this->config = new BSArray(
				$this->getModule()->getConfig($this->getName(), 'actions')
			);
		}
		return $this->config[$name];
	}

	/**
	 * アクション名を返す
	 *
	 * @access public
	 * @return string アクション名
	 */
	public function getName () {
		if (BSString::isBlank($this->name)) {
			if (!mb_ereg('^(.+)Action$', get_class($this), $matches)) {
				$message = new BSStringFormat('アクション "%s" の名前が正しくありません。');
				$message[] = get_class($this);
				throw new BSModuleException($message);
			}
			$this->name = $matches[1];
		}
		return $this->name;
	}

	/**
	 * タイトルを返す
	 *
	 * @access public
	 * @return string タイトル
	 */
	public function getTitle () {
		if (BSString::isBlank($this->title)) {
			$this->title = $this->getConfig('title');
		}
		return $this->title;
	}

	/**
	 * 属性値を全て返す
	 *
	 * @access public
	 * @return BSArray 属性値
	 */
	public function getAttributes () {
		return new BSArray(array(
			'name' => $this->getName(),
			'title' => $this->getTitle(),
		));
	}

	/**
	 * モジュールを返す
	 *
	 * @access public
	 * @return BSModule モジュール
	 */
	public function getModule () {
		return $this->module;
	}

	/**
	 * ビューを返す
	 *
	 * @access public
	 * @param string $name ビュー名
	 * @return BSView ビュー
	 */
	public function getView ($name) {
		if (BSString::isBlank($name) || ($this->request->getMethod() == 'HEAD')) {
			return new BSEmptyView($this, null);
		}

		if (BSString::isBlank($class = $this->getConfig('view'))) {
			$class = 'BSSmartyView';
			if ($this->request->hasAttribute('renderer')) {
				$class = 'BSView';
			}
		}
		if ($dir = $this->getModule()->getDirectory('views')) {
			foreach (array($name, null) as $suffix) {
				$basename = $this->getName() . $suffix . 'View';
				if ($file = $dir->getEntry($basename . '.class.php')) {
					require $file->getPath();
					$class = BSClassLoader::getInstance()->getClass($basename);
					break;
				}
			}
		}

		return new $class($this, $name, $this->request->getAttribute('renderer'));
	}

	/**
	 * カレントレコードIDを返す
	 *
	 * BSModule::getRecordID()のエイリアス。
	 *
	 * @access public
	 * @return integer カレントレコードID
	 * @final
	 */
	final public function getRecordID () {
		return $this->getModule()->getRecordID();
	}

	/**
	 * カレントレコードIDを設定
	 *
	 * BSModule::setRecordID()のエイリアス。
	 *
	 * @access public
	 * @param integer $id カレントレコードID、又はレコード
	 * @final
	 */
	final public function setRecordID ($id) {
		$this->getModule()->setRecordID($id);
	}

	/**
	 * カレントレコードIDをクリア
	 *
	 * BSModule::clearRecordID()のエイリアス。
	 *
	 * @access public
	 * @final
	 */
	final public function clearRecordID () {
		$this->getModule()->clearRecordID();
	}

	/**
	 * 編集中レコードを返す
	 *
	 * @access public
	 * @return BSRecord 編集中レコード
	 */
	public function getRecord () {
		return null;
	}

	/**
	 * テーブルを返す
	 *
	 * @access public
	 * @return BSTableHandler テーブル
	 */
	public function getTable () {
		return $this->getModule()->getTable();
	}

	/**
	 * 抽出条件を生成して返す
	 *
	 * @access protected
	 * @return BSCriteriaSet 抽出条件
	 */
	protected function createCriteriaSet () {
		return $this->database->createCriteriaSet();
	}

	/**
	 * 必要なクレデンシャルを返す
	 *
	 * モジュール規定のクレデンシャル以外の、動的なクレデンシャルを設定。
	 * 必要がある場合、このメソッドをオーバライドする。
	 *
	 * @access public
	 * @return string 必要なクレデンシャル
	 */
	public function getCredential () {
		return $this->getModule()->getCredential();
	}

	/**
	 * クレデンシャルを持たないユーザーへの処理
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function deny () {
		return $this->controller->getAction('secure')->forward();
	}

	/**
	 * 正規なリクエストとして扱うメソッド
	 *
	 * ここに指定したリクエストではexecuteが、それ以外ではgetDefaultViewが実行される。
	 * 適宜オーバライド。
	 *
	 * @access public
	 * @return BSArray 許可されたメソッドの配列
	 */
	public function getRequestMethods () {
		if (!$this->methods) {
			$this->methods = new BSArray;
			if ($file = $this->getValidationFile()) {
				$config = new BSArray($file->getResult());
				if ($methods = $config['methods']) {
					$this->methods->merge($config['methods']);
					return $this->methods;
				}
			}
			$this->methods[] = 'GET';
			$this->methods[] = 'POST';
		}
		return $this->methods;
	}

	/**
	 * バリデーション設定ファイルを返す
	 *
	 * @access public
	 * @return BSConfigFile バリデーション設定ファイル
	 */
	public function getValidationFile () {
		return $this->getModule()->getValidationFile($this->getName());
	}

	/**
	 * リダイレクト対象
	 *
	 * URLを加工するケースが多い為、毎回生成する。
	 *
	 * @access public
	 * @return BSURL
	 */
	public function getURL () {
		$url = BSURL::getInstance(null, 'carrot');
		$url['action'] = $this;
		return $url;
	}

	/**
	 * リダイレクト
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function redirect () {
		return $this->getURL()->redirect();
	}

	/**
	 * 転送
	 *
	 * @access public
	 * @return string ビュー名
	 */
	public function forward () {
		$this->controller->registerAction($this);
		if (!$this->initialize()) {
			throw new BadFunctionCallException($this . 'が初期化できません。');
		}

		$filters = new BSFilterSet;
		$filters->loadAction($this);
		$filters->register(new BSExecutionFilter);
		$filters->execute();
		return BSView::NONE;
	}

	/**
	 * 状態オプションをアサインする
	 *
	 * @access protected
	 * @return string ビュー名
	 */
	protected function assignStatusOptions () {
		if ($table = $this->getModule()->getTable()) {
			$this->request->setAttribute('status_options', $table->getStatusOptions());
		}
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
		return sprintf('%sのアクション"%s"', $this->getModule(), $this->getName());
	}
}

/* vim:set tabstop=4: */
