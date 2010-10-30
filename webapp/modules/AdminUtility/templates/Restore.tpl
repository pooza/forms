{*
リストア画面テンプレート

@package org.carrot-framework
@subpackage AdminUtility
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: Restore.tpl 2415 2010-10-30 09:49:00Z pooza $
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form attachable=true}
	現在の状態をバックアップすることを強くお勧めします。<br/>
	<input type="file" name="file" value="アップロード" />
	<input type="submit" value="実行" />
{/form}

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
