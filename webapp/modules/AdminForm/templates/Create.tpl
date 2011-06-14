{*
フォーム登録画面テンプレート

@package jp.co.b-shock.forms
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
	<table class="detail">
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" value="{$params.name}" size="48" maxlength="64" />
			</td>
		</tr>
		<tr>
			<th>メールアドレス</th>
			<td>
				<input type="text" name="email" value="{$params.email}" size="24" maxlength="64" class="english" />
			</td>
		</tr>
		<tr>
			<th>フォームテンプレート</th>
			<td>
				<textarea name="pc_form_template" cols="60" rows="8">{$params.pc_form_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>確認画面テンプレート</th>
			<td>
				<textarea name="pc_confirm_template" cols="60" rows="8">{$params.pc_confirm_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>サンクス画面テンプレート</th>
			<td>
				<textarea name="pc_thanx_template" cols="60" rows="8">{$params.pc_thanx_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>フォームテンプレート(ケータイ)</th>
			<td>
				<textarea name="mobile_form_template" cols="60" rows="8">{$params.mobile_form_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>確認画面テンプレート(ケータイ)</th>
			<td>
				<textarea name="mobile_confirm_template" cols="60" rows="8">{$params.mobile_confirm_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>サンクス画面テンプレート(ケータイ)</th>
			<td>
				<textarea name="mobile_thanx_template" cols="60" rows="8">{$params.mobile_thanx_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>フォームテンプレート(スマートフォン)</th>
			<td>
				<textarea name="smartphone_form_template" cols="60" rows="8">{$params.smartphone_form_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>確認画面テンプレート(スマートフォン)</th>
			<td>
				<textarea name="smartphone_confirm_template" cols="60" rows="8">{$params.smartphone_confirm_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>サンクス画面テンプレート(スマートフォン)</th>
			<td>
				<textarea name="smartphone_thanx_template" cols="60" rows="8">{$params.smartphone_thanx_template}</textarea>
			</td>
		</tr>
		<tr>
			<th>サンクスメールテンプレート</th>
			<td>
				<textarea name="thanx_mail_template" cols="60" rows="8">{$params.thanx_mail_template}</textarea>
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
