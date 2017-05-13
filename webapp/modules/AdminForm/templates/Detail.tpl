{*
フォーム詳細画面テンプレート

@package jp.co.b-shock.forms
@subpackage AdminForm
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
{include file='AdminHeader'}

<nav class="bread_crumbs">
	<a href="/{$module.name}/">フォーム一覧</a>
	<a href="#">{$action.title}</a>
</nav>

<h1>{$action.title}</h1>

<div class="tabs10">
	<ul id="Tabs">
{if $credentials.AdminEdit}
		<li><a href="#DetailForm"><span>フォーム</span></a></li>
{/if}
		<li><a href="#FieldList"><span>フィールド</span></a></li>
		<li><a href="#RegistrationList"><span>応募</span></a></li>
	</ul>
</div>

{if $credentials.AdminEdit}
<div id="DetailForm" class="panel">
	{form attachable=true}
		<h2>■フォーム詳細</h2>

		{include file='ErrorMessages'}

		<table class="detail">
			<tr>
				<th>フォームID</th>
				<td>{$form.id}</td>
			</tr>
			<tr>
				<th>応募画面URL</th>
				<td>
					{$form.url|url2link}
	{if $form.mobile_form_template || $form.smartphone_form_template}
					<div>{$form.url|qrcode}</div>
	{/if}
				</td>
			</tr>
			<tr>
				<th>プレビュー</th>
				<td>
	{if $form.pc_form_template}
					[<a href="{$form.url}" target="_blank">PC</a>]
	{/if}
	{if $form.mobile_form_template}
					[<a href="{$form.url}?ua=DoCoMo" target="_blank">ケータイ</a>]
	{/if}
	{if $form.smartphone_form_template}
					[<a href="{$form.url}?ua={'iPhone; AppleWebKit/530.0'|urlencode}" target="_blank">スマートフォン</a>]
	{/if}
				</td>
			</tr>
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
				<th>作成日</th>
				<td>{$form.create_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<th>更新日</th>
				<td>{$form.update_date|date_format:'Y年 n月j日 (ww) H:i:s'}</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" value="更新" />
					<input type="button" value="複製" onclick="CarrotLib.redirect('{$module.name}','Duplicate')" />
					<input type="button" value="このフォームを削除..." onclick="CarrotLib.confirmDelete('{$module.name}','Delete','フォーム')" />
				</td>
			</tr>
		</table>
	{/form}
</div>
{/if}

<div id="FieldList" class="panel"></div>
<div id="RegistrationList" class="panel"></div>

{if !$credentials.AdminEdit && !$params.pane}
	{assign var='params.pane' value='FieldList'}
{/if}
<script type="text/javascript">
document.observe('dom:loaded', function(){
  new ProtoTabs('Tabs', {
    defaultPanel:'{$params.pane|default:'DetailForm'}',
    ajaxUrls: {
      FieldList: '/AdminField/List/{$form.id}',
      RegistrationList: '/AdminRegistration/List'
    }
  });
});
</script>

{include file='AdminFooter'}

