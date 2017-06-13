<?php
/**
 * @package jp.co.b-shock.carrot
 * @subpackage view.renderer.smarty
 */

BSUtility::includeFile('Smarty/Smarty_Compiler.class');

/**
 * Smarty_Compilerラッパー
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSSmartyCompiler extends Smarty_Compiler {

	/**
	 * 初期化
	 *
	 * 生成元Smartyオブジェクトのプロパティをコピー
	 *
	 * @access public
	 * @param BSSmarty $smarty 生成元Smartyオブジェクト
	 * @return boolean 成功したらTrue
	 */
	public function initialize (BSSmarty $smarty) {
		$this->template_dir = $smarty->template_dir;
		$this->compile_dir = $smarty->compile_dir;
		$this->plugins_dir = $smarty->plugins_dir;
		$this->config_dir = $smarty->config_dir;
		$this->force_compile = $smarty->force_compile;
		$this->caching = $smarty->caching;
		$this->php_handling = $smarty->php_handling;
		$this->left_delimiter = $smarty->left_delimiter;
		$this->right_delimiter = $smarty->right_delimiter;
		$this->_version = $smarty->_version;
		$this->security = $smarty->security;
		$this->secure_dir = $smarty->secure_dir;
		$this->security_settings = $smarty->security_settings;
		$this->trusted_dir = $smarty->trusted_dir;
		$this->use_sub_dirs = $smarty->use_sub_dirs;
		$this->_reg_objects = &$smarty->_reg_objects;
		$this->_plugins = &$smarty->_plugins;
		$this->_tpl_vars = &$smarty->_tpl_vars;
		$this->default_modifiers = $smarty->default_modifiers;
		$this->compile_id = $smarty->_compile_id;
		$this->_config = $smarty->_config;
		$this->request_use_auto_globals = $smarty->request_use_auto_globals;
		$this->template = $smarty->getTemplate();
		return true;
	}

	/**
	 * 属性を返す
	 *
	 * @access public
	 * @param string $name 属性名
	 * @return mixed 属性
	 */
	public function getAttribute ($name) {
		return $this->$name;
	}

	/**
	 * 属性を設定
	 *
	 * @access public
	 * @param string $name 属性名
	 * @param mixed $value 属性値
	 */
	public function setAttribute ($name, $value) {
		$this->$name = $value;
	}

	/**
	 * テンプレートファイルを返す
	 *
	 * @access public
	 * @return BSTemplateFile テンプレートファイル
	 */
	public function getTemplate () {
		return $this->template;
	}

	/**
	 * Compile {foreach ...} tag.
	 *
	 * @access public
	 * @param string $args
	 * @return string
	 */
	public function _compile_foreach_start ($args) {
		$params = BSArray::create($this->_parse_attrs($args));
		if (BSString::isBlank($params['name'])) {
			$params['name'] = 'foreach_' . BSUtility::getUniqueID();
		}
		if (BSString::isBlank($params['item'])) {
			$params['item'] = $params['name'] . '_item';
		}
		if (BSString::isBlank($params['key'])) {
			$params['key'] = $params['name'] . '_key';
		}

		$var = '$this->_foreach[' . $this->quote($params['name']) . ']';
		$body = new BSArray;
		$body[] = sprintf(
			'<?php %s = [\'from\' => %s, \'iteration\' => 0];',
			$var, $params['from']
		);
		$body[] = sprintf('%s[\'total\'] = count(%s[\'from\']);', $var, $var);
		$body[] = sprintf('if (0 < %s[\'total\']):', $var);
		$body[] = sprintf(
			'  foreach (%s[\'from\'] as $this->_tpl_vars[%s] => $this->_tpl_vars[%s]):',
			$var, $this->quote($params['key']), $this->quote($params['item'])
		);
		$body[] = sprintf('  %s[\'iteration\'] ++;', $var);
		if ($max = $params['max']) {
			$body[] = sprintf('  if (%s < %s[\'iteration\']) {break;}', $max, $var);
		}
		$body[] = '?>';
		return $body->join("\n");
	}

	/**
	 * compile a resource
	 *
	 * sets $contents to the compiled source
	 * @param string $resource
	 * @param string $source
	 * @param string $contents
	 * @return true
	 */
	public function _compile_file ($resource, $source, &$contents) {
		$this->_load_filters();
		$this->_current_file = $resource;
		$source = $this->removeComments($source);
		$source = $this->pushLiterals($source, ($literals = new BSArray));
		$blocks = $this->split($source);
		$tags = $this->compileTags($this->fetchTags($source), $blocks);
		$this->parseStrip($tags, $blocks);
		$contents = clone $this->getHeader();
		$contents[] = $this->join($tags, $blocks);
		$contents->merge($this->getFooter());
		$contents = $this->popLiterals($contents->join("\n"), $literals);
		return true;
	}

	private function removeComments ($source) {
		$ldq = $this->left_delimiter;
		$rdq = $this->right_delimiter;
		foreach (BSString::eregMatchAll("{$ldq}\*.*?\*{$rdq}", $source) as $matches) {
			$source = str_replace($matches[0], null, $source);
		}
		return $source;
	}

	private function fetchTags ($source) {
		$ldq = $this->left_delimiter;
		$rdq = $this->right_delimiter;
		$tags = new BSArray;
		foreach (BSString::eregMatchAll("{$ldq} *([^\n]+?) *{$rdq}", $source) as $matches) {
			$tags[] = $matches[1];
		}
		return $tags;
	}

	private function split ($source) {
		$ldq = $this->left_delimiter;
		$rdq = $this->right_delimiter;
		return BSArray::create(mb_split("{$ldq}[^\n]+?{$rdq}", $source));
	}

	private function compileTags (BSArray $tags, BSArray $blocks) {
		$this->_current_line_no = 1;
		$compiled = new BSArray;
		for ($i = 0 ; $i < count($tags) ; $i ++) {
			$this->_current_line_no += substr_count($blocks[$i], "\n");
			$compiled[] = $this->_compile_tag($tags[$i]);
			$this->_current_line_no += substr_count($tags[$i], "\n");
		}
		if (0 < count($this->_tag_stack)) {
			list($_open_tag, $_line_no) = end($this->_tag_stack);
			$message = new BSStringFormat('閉じられていないタグ "%s" があります。(%s, %d行目)');
			$message[] = $_open_tag;
			$message[] = (new BSFile($resource))->getShortPath();
			$message[] = $_line_no;
			throw new BSViewException($message, $this);
		}
		return $compiled;
	}

	private function parseStrip (BSArray $tags, BSArray $blocks) {
		$strip = false;
		for ($i = 0 ; $i < $tags->count() ; $i ++) {
			if ($tags[$i] == '{strip}') {
				$tags[$i] = '';
				$strip = true;
				$blocks[$i + 1] = ltrim($blocks[$i + 1]);
			}
			if ($strip) {
				for ($j = $i + 1 ; $j < $tags->count() ; $j ++) {
					$blocks[$j] = mb_ereg_replace('[\t ]*[\r\n]+[\t ]*', '', $blocks[$j]);
					if ($tags[$j] == '{/strip}') {
						$blocks[$j] = rtrim($blocks[$j]);
					}
					$blocks[$j] = "<?php echo '" . strtr($blocks[$j], ["'"=>"\'", "\\"=>"\\\\"]) . "'; ?>";
					if ($tags[$j] == '{/strip}') {
						$tags[$j] = "\n";
						$strip = false;
						$i = $j;
						break;
					}
				}
			}
		}
	}

	private function pushLiterals ($source, BSArray $literals) {
		$ldq = $this->left_delimiter;
		$rdq = $this->right_delimiter;
		$literals->clear();
		$pattern = "{$ldq} *literal *{$rdq}(.+?){$ldq} */literal *{$rdq}";
		foreach (BSString::eregMatchAll($pattern, $source) as $matches) {
			$block = $matches[0];
			$literal = $matches[1];
			$tag = BSCrypt::digest([get_class($this), $literal]);
			$literals[$tag] = $literal;
			$source = str_replace($block, $tag, $source);
		}
		return $source;
	}

	private function popLiterals ($source, BSArray $literals) {
		foreach ($literals as $tag => $literal) {
			$source = str_replace($tag, $literal, $source);
		}
		return $source;
	}

	private function join (BSArray $tags, BSArray $blocks) {
		$contents = new BSArray;
		$tag = BSCrypt::digest([get_class($this), BSUtility::getUniqueID()]);
		for ($i = 0 ; $i < $tags->count() ; $i ++) {
			if ($tags[$i] == '') {
				$blocks[$i + 1] = mb_ereg_replace('^(\r\n|\r|\n)', '', $blocks[$i + 1]);
			}
			$blocks[$i] = str_replace('<?', $tag, $blocks[$i]);
			$tags[$i] = str_replace('<?', $tag, $tags[$i]);
			$contents[] = $blocks[$i] . $tags[$i];
		}
		$contents[] = str_replace('<?', $tag, $blocks[$i]);
		$contents = $contents->join();
		$contents = str_replace('<?', "<?= '<?' ?>\n", $contents);
		$contents = str_replace($tag, '<?', $contents);
		return trim($contents);
	}

	private function getHeader () {
		$header = new BSArray;
		$header[] = '<?php';
		$header[] = '// auth-generated by ' . get_class($this);
		$header[] = '// date: ' . BSDate::getNow('%Y/%m/%d %H:%M:%S');
		$header[] = '$this->_tpl_vars[\'error_level\'] = error_reporting();';
		$header[] = 'error_reporting(E_ERROR);';
		if (0 < count($this->_plugin_info)) {
			$plugins = ['plugins' => []];
			foreach ($this->_plugin_info as $type => $plugin) {
				foreach ($plugin as $name => $info) {
					$plugins['plugins'][] = [$type, $name, $info[0], $info[1], !!$info[2]];
				}
			}
			$header[] = 'require_once SMARTY_CORE_DIR . \'core.load_plugins.php\';';
			$header[] = 'smarty_core_load_plugins(' . $this->quote($plugins) . ', $this);';
			$this->_plugin_info = [];
		}
		$header[] = '?>';
		return $header;
	}

	private function getFooter () {
		return BSArray::create([
			'<?php',
			'error_reporting($this->_tpl_vars[\'error_level\']);',
		]);
	}

	private function quote ($value) {
		$value = BSString::dequote($value);
		$value = BSConfigCompiler::quote($value);
		return $value;
	}

	/**
	 * クォートされた文字列から、クォートを外す
	 *
	 * @access public
	 * @param mixed $value 変換対象の文字列又は配列
	 * @return mixed 変換後
	 */
	public function _dequote ($value) {
		return BSString::dequote($value);
	}

	/**
	 * エラートリガ
	 *
	 * @access public
	 * @param string $error_msg エラーメッセージ
	 * @param integer $error_type
	 */
	public function trigger_error ($error_msg, $error_type = null) {
		throw new BSViewException($error_msg);
	}
}

