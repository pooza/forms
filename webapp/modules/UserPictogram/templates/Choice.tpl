{*
絵文字パレットテンプレート
 
@package org.carrot-framework
@subpackage UserPictogram
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: Choice.tpl 1778 2010-01-24 09:23:43Z pooza $
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

	<table>

{foreach from=$pictograms item='pictogram'}
		<tr>
			<td width="15" align="center">{picto name=$pictogram}</td>
			<td width="180">
				<a href="javascript:void(putSmartTag('picto',window.opener.$('{$params.field|default:'body'}'),'{$pictogram}'))">{$pictogram}</a>
			</td>
		</tr>
{/foreach}

	</table>
</body>
</html>

{* vim: set tabstop=4: *}
