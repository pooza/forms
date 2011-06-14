{*
経歴詳細画面テンプレート

@package jp.co.b-shock.forms
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
{css_cache name=$styleset}
</head>
<body>
	<h1>{$action.title}</h1>
	{include file='ErrorMessages'}
	{form id='form' attachable=1}
		<table>
			<tr>
				<th width="60" align="left">ファイル</th>
				<td width="210"><input type="file" name="file" size="20" /></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="送信" />
				</td>
			</tr>
		</table>
	{/form}
</body>
</html>
{* vim: set tabstop=4: *}
