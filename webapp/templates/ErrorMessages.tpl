{*
エラーメッセージ表示 テンプレート

@package org.carrot-framework
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: ErrorMessages.tpl 738 2008-12-12 00:59:09Z pooza $
*}
{if $errors}
<p class="alert">
	{foreach from=$errors key=code item=message}
		{if !$hide_error_code}{$code|translate:$error_code_dictionary}:{/if}
		{$message|url2link|nl2br}<br />
	{/foreach}
</p>
{/if}

{* vim: set tabstop=4: *}