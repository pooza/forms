{*
エラー文面テンプレート
 
@package jp.co.b-shock.carrot
@author 小石達也 <tkoishi@b-shock.co.jp>
*}
Subject: [{$server_host.name}] {$priority}
From: {$from}

{$priority}:
{$message}


クライアントホスト:
{$client_host.name}

ブラウザ:
{$useragent.type}系
{$useragent.name}

{* vim: set tabstop=4: *}
