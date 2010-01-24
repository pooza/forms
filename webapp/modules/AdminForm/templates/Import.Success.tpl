{*
インポート画面テンプレート

@package jp.co.commons.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>{const name='app_name_ja'} {$title}</title>
{js_cache name=$jsset}
</head>
<body>
	<script type="text/javascript">
		new Ajax.Updater(
			window.opener.$('RegistrationList'),
			'/AdminRegistration/List',
			{ldelim}
				onComplete: function () {ldelim}
					window.close();
				{rdelim}
			{rdelim}
		);
	</script>
</body>
</html>
{* vim: set tabstop=4: *}
