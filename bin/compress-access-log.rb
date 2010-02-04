#!/usr/local/bin/ruby -Ku

# 昨日分のアクセスログをgzip圧縮
#
# @package org.carrot-framework
# @author 小石達也 <tkoishi@b-shock.co.jp>
# @version $Id: compress-access-log.rb 1812 2010-02-03 15:15:09Z pooza $

GZIP_CMD = '/usr/bin/gzip'
LOG_DIR = '/var/log/httpd'

require 'date'

date = Date.today - 1
command = GZIP_CMD + ' ' + LOG_DIR + '/*/' + date.strftime('%Y/%m') \
  + '/*_' + date.strftime('%Y%m%d') + '.log'
system(command)