{*
バックアップ画面テンプレート

@package org.carrot-framework
@subpackage AdminUtility
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: Backup.tpl 1812 2010-02-03 15:15:09Z pooza $
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form}
	バックアップファイルをダウンロードします。<br/>
	<input type="submit" value="実行" />
{/form}

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
