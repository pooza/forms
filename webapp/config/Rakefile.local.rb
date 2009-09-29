#!/usr/bin/env rake

# carrotユーティリティタスク
#
# @package jp.co.commons.forms
# @author 小石達也 <tkoishi@b-shock.co.jp>
# @version $Id$

$KCODE = 'u'

namespace :production do
  namespace :local do
    task :init => []
  end
end

namespace :development do
  namespace :local do
    task :init => ['ajaxzip2:init']
  end
end

namespace :database do
  namespace :local do
    task :init => ['ajaxzip2:init']
  end
end

namespace :local do
end