{*
管理画面 テンプレートひな形

@package org.carrot-framework
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id: AdminHeader.tpl 1313 2009-07-09 16:01:46Z pooza $
*}
<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<title>{const name='app_name_ja'} {$title|default:$module.title}</title>
<script type="text/javascript" src="/JavaScript{if $jsset}?jsset={$jsset}{/if}" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="/StyleSheet{if $styleset}?styleset={$styleset}{/if}" />
</head>
<body {if $body.id}id="{$body.id}"{/if}>

{if $menu}
<div id="Menu">
	<ul>
{foreach from=$menu item=item}
	{if $item.separator}
		<li class="separator">&nbsp;</li>
	{elseif $item.href}
		<li><a href="{$item.href}" target="{$item.target|default:'_blank'}">{$item.title}</a></li>
	{else}
		<li><a href="/{$item.module}/{$item.action}">{$item.title}</a></li>
	{/if}
{/foreach}
	</ul>
</div>
<script type="text/javascript">
actions.onload.push(function () {ldelim}
  new Elevator($('Menu'), 10, 10, 10);
{rdelim});
</script>
{/if}

<div id="Contents">

<div id="Header">
{const name='app_name_ja'} {$title|default:$module.title}
</div>

{* vim: set tabstop=4: *}