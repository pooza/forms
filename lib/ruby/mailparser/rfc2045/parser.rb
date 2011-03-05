#
# DO NOT MODIFY!!!!
# This file is automatically generated by racc 1.4.5
# from racc grammer file "lib/mailparser/rfc2045/parser.y".
#

require 'racc/parser'


module MailParser

  module RFC2045

    class Parser < Racc::Parser

module_eval <<'..end lib/mailparser/rfc2045/parser.y modeval..idcdf01fc9ea', 'lib/mailparser/rfc2045/parser.y', 62

require "mailparser/rfc2045/scanner"

def parse(header_type, value)
  @header_type = header_type
  @value = value
  @scanner = Scanner.new(header_type, value)
  ret = yyparse(self, :parse_sub)
  class << ret
    attr_accessor :comments
  end
  ret.comments = @scanner.comments
  ret
end

def parse_sub(&block)
  yield @header_type, nil
  @scanner.scan(&block)
end

def on_error(t, val, vstack)
#  p t, val, vstack
#  p racc_token2str(t)
  raise MailParser::ParseError, val+@scanner.rest
end
..end lib/mailparser/rfc2045/parser.y modeval..idcdf01fc9ea

##### racc 1.4.5 generates ###

racc_reduce_table = [
 0, 0, :racc_error,
 2, 13, :_reduce_1,
 2, 13, :_reduce_2,
 2, 13, :_reduce_3,
 4, 14, :_reduce_4,
 1, 15, :_reduce_5,
 3, 16, :_reduce_6,
 1, 20, :_reduce_none,
 1, 17, :_reduce_none,
 1, 18, :_reduce_none,
 0, 19, :_reduce_10,
 3, 19, :_reduce_11,
 3, 21, :_reduce_12,
 1, 22, :_reduce_none,
 1, 23, :_reduce_none,
 1, 23, :_reduce_none ]

racc_reduce_n = 16

racc_shift_n = 29

racc_action_table = [
    28,     8,    10,    26,     1,     3,     4,    13,    14,    15,
     7,    18,    19,    21,    23,    25,    16 ]

racc_action_check = [
    25,     2,     3,    25,     0,     0,     0,     4,     6,     8,
     1,    14,    16,    20,    21,    22,    13 ]

racc_action_pointer = [
     2,     2,     1,    -6,     1,   nil,     3,   nil,     9,   nil,
   nil,   nil,   nil,     9,     3,   nil,     6,   nil,   nil,   nil,
     4,     6,     5,   nil,   nil,    -8,   nil,   nil,   nil ]

racc_action_default = [
   -16,   -16,   -16,   -16,   -16,    -1,   -16,    -8,   -16,    -2,
    -7,    -5,    -3,   -16,   -16,    29,   -16,   -10,    -9,    -6,
    -4,   -16,   -16,   -13,   -11,   -16,   -15,   -12,   -14 ]

racc_goto_table = [
     2,     5,     9,    12,     6,    17,    20,    11,    24,    22,
    27 ]

racc_goto_check = [
     1,     2,     3,     4,     5,     6,     7,     8,     9,    10,
    11 ]

racc_goto_pointer = [
   nil,     0,     0,    -1,    -1,     3,    -9,   -11,     4,   -13,
   -12,   -15 ]

racc_goto_default = [
   nil,   nil,   nil,   nil,   nil,   nil,   nil,   nil,   nil,   nil,
   nil,   nil ]

racc_token_table = {
 false => 0,
 Object.new => 1,
 :CONTENT_TYPE => 2,
 :CONTENT_TRANSFER_ENCODING => 3,
 :MIME_VERSION => 4,
 "/" => 5,
 :DIGIT => 6,
 "." => 7,
 :TOKEN => 8,
 ";" => 9,
 "=" => 10,
 :QUOTED_STRING => 11 }

racc_use_result_var = false

racc_nt_base = 12

Racc_arg = [
 racc_action_table,
 racc_action_check,
 racc_action_default,
 racc_action_pointer,
 racc_goto_table,
 racc_goto_check,
 racc_goto_default,
 racc_goto_pointer,
 racc_nt_base,
 racc_reduce_table,
 racc_token_table,
 racc_shift_n,
 racc_reduce_n,
 racc_use_result_var ]

Racc_token_to_s_table = [
'$end',
'error',
'CONTENT_TYPE',
'CONTENT_TRANSFER_ENCODING',
'MIME_VERSION',
'"/"',
'DIGIT',
'"."',
'TOKEN',
'";"',
'"="',
'QUOTED_STRING',
'$start',
'all',
'content_type',
'content_transfer_encoding',
'mime_version',
'type',
'subtype',
'parameter_list',
'mechanism',
'parameter',
'attribute',
'value']

Racc_debug_parser = false

##### racc system variables end #####

 # reduce 0 omitted

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 9
  def _reduce_1( val, _values)
val[1]
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 11
  def _reduce_2( val, _values)
val[1]
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 13
  def _reduce_3( val, _values)
val[1]
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 19
  def _reduce_4( val, _values)
                    ContentType.new(val[0], val[2], val[3])
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 24
  def _reduce_5( val, _values)
                    ContentTransferEncoding.new(val[0])
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 31
  def _reduce_6( val, _values)
                    val.join
  end
.,.,

 # reduce 7 omitted

 # reduce 8 omitted

 # reduce 9 omitted

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 42
  def _reduce_10( val, _values)
                    {}
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 49
  def _reduce_11( val, _values)
                    pn, pv = val[2]
                    pv = $1 if pv =~ /\A\"(.*)\"\Z/m
                    val[0][pn] = pv.gsub(/\s*\n\s*/, " ")
                    val[0]
  end
.,.,

module_eval <<'.,.,', 'lib/mailparser/rfc2045/parser.y', 54
  def _reduce_12( val, _values)
                    [val[0].downcase, val[2]]
  end
.,.,

 # reduce 13 omitted

 # reduce 14 omitted

 # reduce 15 omitted

 def _reduce_none( val, _values)
  val[0]
 end

    end   # class Parser

  end   # module RFC2045

end   # module MailParser
