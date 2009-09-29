#!/usr/bin/env rake

# carrotユーティリティタスク
#
# @package __PACKAGE__
# @author 小石達也 <tkoishi@b-shock.co.jp>
# @version $Id: Rakefile.local.rb 881 2009-02-18 14:42:50Z pooza $

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