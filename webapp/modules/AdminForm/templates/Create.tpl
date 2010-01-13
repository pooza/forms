{*
フォーム登録画面テンプレート

@package jp.co.commons.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
@version $Id$
*}
{include file='AdminHeader'}

<div id="BreadCrumbs">
	<a href="/{$module.name}/">フォーム一覧</a>
	<a href="#">{$action.title}</a>
</div>

<h1>{$action.title}</h1>

{include file='ErrorMessages'}

{form attachable=true}
	<table class="Detail">
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" value="{$params.name}" size="48" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>フォーム<br/>テンプレート</th>
			<td>
				<input type="file" name="form_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>確認画面<br/>テンプレート</th>
			<td>
				<input type="file" name="confirm_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>サンクス画面<br/>テンプレート</th>
			<td>
				<input type="file" name="thanx_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>フォーム<br/>テンプレート(携)</th>
			<td>
				<input type="file" name="form_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>確認画面<br/>テンプレート(携)</th>
			<td>
				<input type="file" name="confirm_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>サンクス画面<br/>テンプレート(携)</th>
			<td>
				<input type="file" name="thanx_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>サンクスメール<br/>テンプレート</th>
			<td>
				<input type="file" name="thanx_mail_template" size="48" />
			</td>
		</tr>
		<tr>
			<th>状態</th>
			<td>
				{html_radios name='status' options=$status_options selected=$params.status}
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="登録" />
			</td>
		</tr>
	</table>
{/form}

{include file='AdminFooter'}

{* vim: set tabstop=4: *}
