#!/usr/local/bin/ruby -Ku

# 昨日分のアクセスログをgzip圧縮
#
# @package org.carrot-framework
# @author 小石達也 <tkoishi@b-shock.co.jp>
# @version $Id: compress-access-log.rb 501 2008-08-17 16:36:14Z pooza $

GZIP_CMD = '/usr/bin/gzip'
LOG_DIR = '/var/log/httpd'

require 'date'

date = Date.today - 1
command = GZIP_CMD + ' ' + LOG_DIR + '/*/' + date.strftime('%Y/%m') \
  + '/*_' + date.strftime('%Y%m%d') + '.log'
system(command)