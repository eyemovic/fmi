################################################################################################################################################################################
# ���ץ����������(��)�������������ӡ�����ͭ���Ƥ��ޤ���
# �ץ����β��ѡ����ɤϼ�ͳ�Ǥ��������ԡ��������Ѥ������ؤ��ޤ���
# 
# Copyright(C) Studio Canbe Corp. All rights reserved.
# Delivered: 2007-11-30
################################################################################################################################################################################


###########   �Ź沽���֥������Ⱥ���   ##########
#sub make_crypted_object
#{
###������
###	�Ź沽�����沽����
#	my($crypt_key) = @_;
#
###�������
###	�Ź沽���֥�������
#	my($cipher);
#
###���������ѿ�
#
###������
#
###	Crypt::CBC ����Ѥ���
#	use Crypt::CBC;
#
###	���֥������Ⱥ���
#	$cipher = Crypt::CBC->new({'key' => $crypt_key, 'cipher' => $CONFIG{'crypt_cipher'}, 'iv' => $CONFIG{'crypt_iv'}, 'regenerate_key' => $CONFIG{'crypt_regenerate_key'}, 'padding' => $CONFIG{'crypt_padding'}, 'prepend_iv' => $CONFIG{'crypt_prepend_iv'}});
#
#	return $cipher;
#}


##########      ���ߤλ��֤����      ##########
sub get_current_times
{
##������
##	�ʤ�

##�������
##	�����Х��ѿ� %FORM �˥��å�

##���������ѿ�

##������

	$FORM{'current_timestamp'} = time;

	($FORM{'current_sec'}, $FORM{'current_min'}, $FORM{'current_hour'}, $FORM{'current_day'}, $FORM{'current_mon'}, $FORM{'current_year'}, $FORM{'current_wday'}) = &get_date($FORM{'current_timestamp'}, "jp");

	$FORM{'current_date'} = "$FORM{'current_year'}ǯ$FORM{'current_mon'}��$FORM{'current_day'}�� ($FORM{'current_wday'}) $FORM{'current_hour'}:$FORM{'current_min'}:$FORM{'current_sec'}";
}


##########    ��ǯ��������ǯ��׻�    ##########
sub calc_age
{
##������
##	ǯ�� (0 = ����, 1 = ����, 2 = ����, 3 = ����, 4 = ʿ��)
##	��ǯ���� ǯ
##	��ǯ���� ��
##	��ǯ���� ��
	my($nengo, $born_year, $born_mon, $born_day) = @_;

##�������
##	ǯ��
	my($age);

##���������ѿ�
	my(@YEAR_LIST) = qw(0 1867 1911 1925 1988);
	my($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);

##������

	($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst) = localtime(time);
	$year += 1900;
	$mon += 1;

	$age = $year - $born_year - $YEAR_LIST[$nengo];
	if($born_mon > $mon){
		$age -= 1;
	}
	if($born_mon == $mon && $born_day > $day){
		$age -= 1;
	}

	return $age;
}


##########       ���������ռ���       ##########
sub get_date
{
##������
##	�����ॹ�����
##	�����η��� (num = 0��6 �ο��� (�ǥե����), en = �ѻ�(��ά), english = �ѻ�, jp = ����)
	my($timestamp, $weekday) = @_;

##�������
##	��, ʬ, ��, ��, ��, ǯ, ����, ǯ��, isdst
	my($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);

##���������ѿ�

##������

	($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst) = localtime($timestamp);

	if($sec < 10){
		$sec = "0".$sec;
	}
	if($min < 10){
		$min = "0".$min;
	}
	if($hour < 10){
		$hour = "0".$hour;
	}
	if($day < 10){
		$day = "0".$day;
	}
	$mon++;
	if($mon < 10){
		$mon = "0".$mon;
	}
	$year += 1900;

	if($weekday =~ /jp/i){
		$wday = ("��", "��", "��", "��", "��", "��", "��")[$wday];
	}
	elsif($weekday =~ /en/i){
		$wday = ("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT")[$wday];
	}
	elsif($weekday =~ /english/i){
		$wday = ("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")[$wday];
	}

	return ($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);
}


##########    �����ॹ����פ����    ##########
sub get_timestamp
{
##������
##	YYYY.MM.DD.HH.MM.SS ����������
	my($date) = @_;

##�������
##	�����ॹ����� (���ݥå���)
	my($timestamp);

##���������ѿ�
	my($year, $mon, $day, $hour, $min, $sec);

##������

	($year, $mon, $day, $hour, $min, $sec) = split(/\./, $date);
	$mon--;

	use Time::Local;
	$timestamp = timelocal($sec, $min, $hour, $day, $mon, $year);

	return $timestamp;
}


##########       �ĥ��顼�θ���       ##########
sub zeller
{
##������
##	ǯ
##	��
##	��
	my($year, $month, $day) = @_;

##�������
##	���� (���ͷ�)

##���������ѿ�

##������

	if($month < 3){
		$month += 12;
		$year--;
	}

	return($year + int($year / 4) - int($year / 100) + int($year / 400) + int((13 * $month + 8) / 5) + $day) % 7;
}


##########          �ǥ�����          ##########
sub decode
{
##������
##	�ʤ�

##�������
##	�ʤ�
##	�����Х��ѿ� %FORM �˥��å�

##���������ѿ�
	my(@pairs);
	my($name, $value);

##������

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("��METHOD�ۤ��ǧ���Ƥ���������");
	}

	foreach $pair(@pairs){
		($name, $value) = split(/=/, $pair);
		$name =~ tr/+/ /;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/'//g;
		&jcode::convert(\$name, 'euc');
		&jcode::convert(\$value, 'euc');
		&jcode::h2z_euc(\$value);
		$FORM{$name} = $value;
	}
}


##########    Shift_JIS �ѥǥ�����    ##########
sub sjis_decode
{
##������
##	�ʤ�

##�������
##	�ʤ�
##	�����Х��ѿ� %FORM �˥��å�

##���������ѿ�
	my(@pairs);
	my($name, $value);

##������

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("��METHOD�ۤ��ǧ���Ƥ���������");
	}

	foreach $pair(@pairs){
		($name, $value) = split(/=/, $pair);
		$name =~ tr/+/ /;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ s/'//g;
		&jcode::convert(\$name, 'euc');
		&jcode::h2z_sjis(\$value);
		&jcode::convert(\$value, 'euc');
		$FORM{$name} = $value;
	}
}


##########       CGI.pm�ǥ�����       ##########
sub pm_decode
{
##������
##	�ϥå���̾
	my($header) = @_;

##�������
##	�ʤ�
##	�����Х��ѿ� %$header �˥��å�

##���������ѿ�
	my(@name);

##������

##	CGI.pm ����Ѥ���
	use CGI;
	$query = new CGI;

##	�����꡼�ǡ����� NAME ��ʬ�����
	@name = $query->param;

##	�����꡼�ǡ��������
	foreach $name(@name){
		$$header{$name} = $query->param($name);
		$$header{$name} =~ s/'//g;
	}
}


##########     �ǥХå��ѥǥ�����     ##########
sub debug_decode
{
##������
##	�ʤ�

##�������
##	�ʤ�
##	�����Х��ѿ� %FORM �˥��å�

##���������ѿ�
	my(@pairs);
	my($name, $value);

##������

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("��METHOD�ۤ��ǧ���Ƥ���������");
	}

	foreach $pair(@pairs){
		($name, $value) = split(/=/, $pair);
		$name =~ tr/+/ /;
		$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		&jcode::convert(\$name, 'euc');
		&jcode::convert(\$value, 'euc');
		$FORM{$name} = $value;
	}
}


##########         ���󥳡���         ##########
sub encode
{
##������
##	���󥳡��ɤ���ʸ����
	my($text) = @_;

##�������
##	���󥳡��ɺѤ�ʸ����
	my($result);

##���������ѿ�
	my(@temp);
	my($temp);

##������

	@temp = unpack('C*', $text);
	foreach $temp(@temp){
		if($temp < 127 && $temp > 32){
			$result .= chr($temp);
		}
		else{
			$result .= sprintf("%%%lx", $temp);
		}
	}

	return $result;
}


##########       URL���󥳡���        ##########
sub url_encode
{
##������
##	���󥳡��ɤ���ʸ����
	my($text) = @_;

##�������
##	���󥳡��ɺѤ�ʸ����
	my($result);

##���������ѿ�
	my(@temp);
	my($temp);

##������

	@temp = unpack('C*', $text);
	foreach $temp(@temp){
#		��0-9A-Za-z'()*!-._�פϤ��Τޤޤ�OK
		if( ($temp >= 48 && $temp <= 57)
		||	($temp >= 65 && $temp <= 90)
		||	($temp >= 97 && $temp <= 122)
		||	($temp >= 39 && $temp <= 42)
		||	$temp == 33 || $temp == 45 || $temp == 46 || $temp == 95 ) {
			$result .= chr($temp);
		}
		else{
			$result .= sprintf("%%%lx", $temp);
		}
	}

	return $result;
}


##########       HTML���󥳡���       ##########
sub html_encode
{
##������
##	HTML���󥳡��ɤ���ʸ����
	my($encode) = @_;

##�������
##	HTML���󥳡��ɺѤ�ʸ����

##���������ѿ�

##������

	$encode =~ s/\&/\&amp;/g;
	$encode =~ s/\"/\&quot;/g;
	$encode =~ s/\</\&lt;/g;
	$encode =~ s/\>/\&gt;/g;

	return $encode;
}


##########        HTML�ǥ�����        ##########
sub html_decode
{
##������
##	HTML�ǥ����ɤ���ʸ����
	my($decode) = @_;

##�������
##	HTML�ǥ����ɺѤ�ʸ����

##���������ѿ�

##������

	$decode =~ s/\&amp;/\&/g;
	$decode =~ s/\&quot;/\"/g;
	$decode =~ s/\&lt;/\</g;
	$decode =~ s/\&gt;/\>/g;

	return $decode;
}


##########  �Ҥ餬�ʤ򥫥����ʤ��Ѵ�  ##########
sub hira2kana
{
##������
##	�Ѵ�����ʸ����
	my($keyword) = @_;

##�������
##	�Ѵ����줿ʸ����

##���������ѿ�

##������

	$keyword =~ s/\xa5\xa4/`/g;
	$keyword =~ s/\xa4([\xa1-\xfe])/\xa5$1/g;
	$keyword =~ s/`/\xa5\xa4/g;

	return $keyword;
}


##########      ���Ԥ�<BR>���Ѵ�      ##########
sub line2br
{
##������
##	�ִ�����ʸ����
	my($line) = @_;

##�������
##	<BR>���ִ��Ѥ�ʸ����

##���������ѿ�

##������

	$line =~ s/\r\n/\n/g;
	$line =~ s/\r/\n/g;
	$line =~ s/\n/<BR>/g;

	return $line;
}


##########      <BR>����Ԥ��Ѵ�      ##########
sub br2line
{
##������
##	�ִ�����ʸ����
	my($line) = @_;

##�������
##	���Ԥ��ִ��Ѥ�ʸ����

##���������ѿ�

##������

	$line =~ s/<BR>/\n/g;

	return $line;
}


##########ʸ���򥹥ڡ������ڤ������##########
sub split_words
{
##������
##	ʬ�䤹��ʸ��
	my($words) = @_;

##�������
##	ʬ�䤵�줿ʸ������
	my(@words, @temp_words);

##���������ѿ�
	my $ascii = '[\x00-\x7F]';
	my $twoBytes = '(?:[\x8E\xA1-\xFE][\xA1-\xFE])';
	my $threeBytes = '(?:\x8F[\xA1-\xFE][\xA1-\xFE])';
	my $Zspace = '(?:\xA1\xA1)';
	my $character = "(?:$ascii|$twoBytes|$threeBytes)";

##������

##	��Ƭ�����������פ�ʸ������
	$words =~ s/^(?:\s|$Zspace)+//o;
	$words =~ s/^($character*?)(?:\s|$Zspace)+$/$1/o;

##	ʸ����ζ��ڤ�ʸ����Ⱦ�ѥ��ڡ��������줹��
	$words =~ s/\s/ /g;
	$words =~ s/��/ /g;

##	���������
	@temp_words = split(/ /, $words);

##	������ѿ�����
	foreach $data(@temp_words){
		if($data ne ""){
			push(@words, $data);
		}
	}

	return @words;
}


##########          ʸ����ά          ##########
sub cut_text
{
##������
##	��������ʸ���� (EUC-JP�Τ�)
##	����ʸ����
	my($text, $max) = @_;

##�������
##	ʸ����ά�Ѥ�ʸ����
	my($res);

##���������ѿ�
	my($len, $euc);

##������

	$euc = q{[\x00-\x7F]|\x8E[\xA0-\xDF]|\x8F[\xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE]};

	if(length($text) <= $max){
		$res = $text;
	}
	else{
		while($text =~ /\G((?:$euc))/go){
			$len += length($1);
			if($len <= $max - 2){
				$res .= $1;
			}
			else{
				last;
			}
		}
		$len = $max - length($res);
		$res .= '.' x $len;
	}
	return $res;
}


##########        ���ͤΰ̼��        ##########
sub put_comma
{
##������
##	�̼�ꤹ�����
	my($number) = @_;

##�������
##	�̼��Ѥ߿���

##���������ѿ�

##������

	if(length($number) > 3){
		$number = reverse(join(',', reverse($number) =~ /((?:^\d+\.)?\d{1,3}[-+]?)/g)) if $number =~ /^[-+]?\d\d\d\d/;
	}

	return $number;
}


##########ʸ���URL ��ϥ��С���󥯲�##########
sub url2link
{
##������
##	HTML�ǡ���
##	��󥯤Υ������å� (�ǥե���ȡ�_blank)
	my($html, $target) = @_;

##�������
##	�ϥ��ѡ���󥯲��Ѥ�HTML�ǡ���

##���������ѿ�

##������

	if($target eq ""){
		$target = "_blank";
	}

	$html =~ s/([^=^\"]|^)(https?\:[\w\.\~\-\/\?\&\=\@\;\#\:\%]+)/$1<A HREF=\"$2\" TARGET=\"$target\">$2<\/A>/g;

	return $html;
}


##########        ���ͤ�������        ##########
sub value2int
{
##������
##	�������������
	my($value) = @_;

##�������
##	�������Ѥ߿���

##���������ѿ�

##������

##	���ѿ�����Ⱦ�ѿ�����
	$value = &zen2han($value);

##	���ͤ�������
	$value = int $value;

	return $value;
}


##########    ����ʸ����Ⱦ�Ѥ��Ѵ�    ##########
sub zen2han
{
##������
##	�Ѵ�����ʸ���� (EUC-JP�Τ�)
	my($text) = @_;

##�������
##	�Ѵ��Ѥ�ʸ����

##���������ѿ�
	my($euc);

##������

	$euc = q{[\x00-\x7F]|\x8E[\xA0-\xDF]|\x8F[\xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE]};

##	�ѿ���
	$text =~ s/\G((?:$euc)*?)\xA3([\xB0-\xB9\xC1-\xFA])/$1.chr(ord($2)-128)/ego;

##	�ԥꥪ�ɤΤĤ��(����)
	$text =~ s/\G((?:$euc)*?)\xA1([\xA3\xA5])/$1\./go;

##	�ϥ��ե�餷��ʸ��(�� �� ����)
	$text =~ s/\G((?:$euc)*?)\xA1([\xBC-\xBE\xDD])/$1\-/go;

##	����å���
	$text =~ s/\G((?:$euc)*?)��/$1\//go;

##	���åȥޡ���
	$text =~ s/\G((?:$euc)*?)��/$1\@/go;

##	�ݥ��å�
	$text =~ s/\G((?:$euc)*?)\xA1([\xCA\xCB])/$1.chr(ord($2)-162)/ego;

	return $text;
}


##########    �ƥ����Ȥ��ޤꤿ����    ##########
sub wrap_text
{
##������
##	�ޤꤿ���ߤ���ʸ����
##	�ޤꤿ���ߤ���Х��Ȱ��� (�����ʸ����������ǥ�ȴޤ�)
##	����ǥ�Ȥ���Х��Ȱ���
##	�ǽ�ιԤΥ���ǥ�� (0 = ���ʤ�, 1 = ����)
	my($text, $max, $indent, $firstline) = @_;

##�������
##	�ޤꤿ���ߺѤ�ʸ����
	my($result);

##���������ѿ�
	my($euc);
	my($itx, $temp);

##������

	$euc = q{[\x00-\x7F]|\x8E[\xA0-\xDF]|\x8F[\xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE]};

##	��������
	$text =~ s/\r\n/\n/g;
	$text =~ s/\r/\n/g;
	$text =~ s/\t/    /g;

	if($indent){
		$itx = " " x $indent;
		$max -= $indent;
	}

	@text = split(/\n/,$text);

	foreach $text(@text){
		if(length($text) > $max){
##			�ޤ��֤�����
			while($text =~ /\G($euc)/go){
				$temp .= $1;
				if(length($temp) >= $max){
					$result .= "$itx$temp\n";
					$temp = "";
				}
			}
			if(length($temp) > 0){
				$result .= "$itx$temp\n";
				$temp = "";
			}
		}
		else{
##			1���ܤ�MAX�Х��Ȱʲ��ʤ餽�Τޤ�
			$result .= "$itx$text\n";
		}
	}

	if(($indent) && ($firstline == 0)){
		$result =~ s/^\s{$indent}//;
	}

	return $result;
}


##########     �ѥ���ɼ�ư����     ##########
sub make_password
{
##������
##	�ѥ���ɤκ���Х��ȿ�
	my($figure) = @_;

##�������
##	�����Ѥߥѥ����
	my($password);

##���������ѿ�

##������

##	�ѥ���ɤ�����
	$password = crypt(rand(1000), rand(99));

##	������ʸ����ȴְ㤨�䤹��ʸ�������
	$password =~ s/[.\/0Ol1iI]//g;

##	����Ĺ��Ĵ��
	$password = substr($password, -$figure);

	return $password;
}


########## �ȹ�ե�����ȥǡ����ξȹ� ##########
sub compare_tdb
{
##������
##	�ȹ礹��٤Υե�����̾
##	�����å�����ǡ���
	my($fname, $value) = @_;

##�������
##	0 = �ȹ�, 1 = ��ȹ�

##���������ѿ�
	my(@data);

##������

	foreach $data(&fread($fname, 0, 1)){
		chomp $data;
		($code, $name) = split("<>", $data);

		if($code eq $value){
			return 1;
		}
	}

	return 0;
}


##########    E-MAIL����(sendmail)    ##########
sub sendmail
{
##������
##	���顼���Υ᡼��������
##	������ (ʣ���ξ��ϥ���ޤǶ��ڤ�)
##	Cc������ (ʣ���ξ��ϥ���ޤǶ��ڤ�)
##	Bcc������ (ʣ���ξ��ϥ���ޤǶ��ڤ�)
##	���п� (����: "���п�̾" <���пͥ᡼�륢�ɥ쥹>)
##	��̾
##	��ʸ (text/plain)
##	��ʸ (text/html)
##	ź�եե�����̾
##	ź�եե�����ѥ�
##	�ǥХå����� (0 = NO[�᡼������], 1 = YES[���̽���])
	my($errors_to, $to, $cc, $bcc, $from, $subject, $text_body, $html_body, $attached_name, $attached_path, $debug) = @_;


##�������
##	�ʤ�

##���������ѿ�
	my($senddata);

##������

##	ɬ�ܹ��ܤ�ȴ���Ƥ��ʤ��������å�
	if($errors_to eq ""){
		&error_html("�����ƥ२�顼��&sendmail has a error.<BR>\nNo \$errors_to.<BR>\nSystem error message: $!");
	}
	elsif($to eq ""){
		&error_html("�����ƥ२�顼��&sendmail has a error.<BR>\nNo \$to.<BR>\nSystem error message: $!");
	}
	elsif($text_body eq ""){
		&error_html("�����ƥ२�顼��&sendmail has a error.<BR>\nNo \$text_body.<BR>\nSystem error message: $!");
	}

##	����
	my($partition) = "------partition." . time;

##	�ޥ���ѡ���
	my($multi_part) = 0;
	if($html_body ne "" || ($attached_name ne "" && -f $attached_path == 1)){
		$multi_part  = 1;
	}

####�᡼��إå���
	if($multi_part == 1){
		$senddata	.= "Content-Type: multipart/mixed; boundary=\"$partition\"\n";
		$senddata	.= "Content-Transfer-Encoding:Base64\n";
	}
	$senddata		.= "To: $to\n";
	$senddata		.= "Cc: $cc\n";
	$senddata		.= "Bcc: $bcc\n";
	$senddata		.= "From: $from\n";
	$senddata		.= "Subject: $subject\n";

####��ʸ (text/plain)
	if($multi_part == 1){
		$senddata	.= "--$partition\n";
	}
	$senddata		.= "Content-Type: text/plain; charset=\"iso-2022-jp\"\n";
	$senddata		.= "\n";
	$senddata		.= $text_body;
	$senddata		.= "\n";

####��ʸ (text/html)
	if($html_body ne ""){
		$senddata	.= "--$partition\n";
		$senddata	.= "Content-Type: text/html; charset=\"iso-2022-jp\"\n";
		$senddata	.= "\n";
		$senddata	.= $html_body;
		$senddata	.= "\n";
	}

####ź�եե�����
	if($attached_name ne "" && -f $attached_path == 1){
##		ź�եե�����̾��MIME���󥳡���
		&jcode::convert(\$attached_name, 'sjis', 'euc');
		$attached_name = &mimeencode($attached_name);

##		ź�եե������BASE64���󥳡���
		my($attached_file)	= join("", &fread($attached_path, 1, 1));
		$attached_file		= &bodyencode($attached_file, "b64");
		$attached_file	   .= &benflush("b64");

		$senddata	.= "--$partition\n";
		$senddata	.= "Content-Type: application/octet-stream; name=\"$attached_name\"\n";
		$senddata	.= "Content-Transfer-Encoding: base64\n";
		$senddata	.= "Content-Disposition: attachment; filename=\"$attached_name\"\n";
		$senddata	.= "\n";
		$senddata	.= "$attached_file\n";
		$senddata	.= "\n";
	}

##	�ޥ���ѡ��Ȥξ��եå�������Ϳ
	if($multi_part == 1){
		$senddata	.= "--$partition--\n";
	}

##	ʸ�������ɤ��Ѵ�
	&jcode::convert(\$senddata, "jis", "euc", "z");

##���᡼������
	if($debug == 0){
		open(ML, "| $CONFIG{'sendmail'} -t -f $errors_to") or die &error_html("�ڥ᡼�륵���С����顼�ۤΰ٤˥᡼��������Ǥ��ޤ���Ǥ��������顼�����ɡ�$!��");
		print ML $senddata;
		close(ML);
	}
##�����̽���
	else{
		print "Content-type: text/html\n";
		print "\n";
		print "<HTML>\n";
		print "<HEAD>\n";
		print "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=iso-2022-jp\">\n";
		print "</HEAD>\n";
		print "<BODY BGCOLOR=\"#FFFFFF\">\n";
		print "<PRE>\n";
		print "$senddata\n";
		print "</PRE>\n";
	}
}


###########      E-MAIL����(SMTP)      ##########
#sub smtp_sendmail
#{
###������
###	To: (BASE64���󥳡��ɺ�)
###	Cc:
###	Bcc:
###	From:
###	Subject: (BASE64���󥳡��ɺ�)
###	Message: (JIS���󥳡��ɺ�)
#	my($to, $cc, $bcc, $from, $subject, $message) = @_;
#
###�������
###	�ʤ�
#
###���������ѿ�
#	my($SMTP);
#
###������
#
#	use Net::SMTP;
#	use Authen::SASL;
#
###	����������
#	my($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdat) = gmtime(time + 60 * 60 * 9);
#	my($week)	= ('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')[$wday];
#	my($month)	= ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')[$mon];
#	my($date)	= sprintf("%s, %02d %s %04d %02d:%02d:%02d +0900", $week, $mday, $month, $year+1900, $hour, $min, $sec);
#
###	���֥������Ȥκ���
#	$SMTP = Net::SMTP -> new($CONFIG{'smtp'},
#				Hello => $CONFIG{'smtp'},
#				Timeout => 60) or die &error_html("new ERROR:[$CONFIG{'smtp'}]$!");
#
###	ǧ��
#	$SMTP -> auth($CONFIG{'auth_id'}, $CONFIG{'auth_pass'}) or die &error_html("auth ERROR:[$CONFIG{'auth_id'}], [$CONFIG{'auth_pass'}]$!");
#
###	�إå���
#	$SMTP -> mail($from) or die &error_html("mail error:$!");
#	$SMTP -> to($to) or die &error_html("to error:[$to]$!");
#	if($cc ne ""){
#		$SMTP -> cc($cc) or die &error_html("cc error:[$cc]$!");
#	}
#	if($bcc ne ""){
#		$SMTP -> bcc($bcc) or die &error_html("bcc error:[$bcc]$!");
#	}
#
###	�ǡ���
#	$SMTP -> data();
#	$SMTP -> datasend("From:$from\n");
#	$SMTP -> datasend("To:$to\n");
#	$SMTP -> datasend("Subject:$subject\n");
#	$SMTP -> datasend("Mime-Version: 1.0\n");
#	$SMTP -> datasend("Content-type: text/plain; charset=iso-2022-jp\n");
#	$SMTP -> datasend("Content-transfer-encoding: 7bit\n");
#	$SMTP -> datasend("Date: $date\n");
#	$SMTP -> datasend("\n");
#	$SMTP -> datasend("$message\n");
#	$SMTP -> dataend();
#	$SMTP -> quit;
#}


##########      BASE64���󥳡���      ##########
sub base64encode
{
##������
##	BASE64���󥳡��ɤ���ʸ����
	my($text) = @_;

##�������
##	BASE64���󥳡��ɺѤ�ʸ����

##���������ѿ�
	my($base);
	my($xx, $yy, $zz, $i);

##������

	$base = "ABCDEFGHIJKLMNOPQRSTUVWXYZ" . "abcdefghijklmnopqrstuvwxyz" . "0123456789+/";
	$xx = unpack("B*", $text);
	for($i = 0; $yy = substr($xx, $i, 6); $i += 6){
		$zz .= substr($base, ord(pack("B*", "00" . $yy)), 1);
		if(length($yy) == 2){
			$zz .= "==";
		}
		elsif(length($yy) == 4){
			$zz .= "=";
		}
	}

	return($zz);
}


##########  BASE64���󥳡���(E-MAIL)  ##########
sub base64encode_email
{
##������
##	BASE64���󥳡���(E-MAIL)����ʸ����
	my($enc_s) = @_;

##�������
##	BASE64���󥳡���(E-MAIL)�Ѥ�ʸ����

##���������ѿ�
	my($enc_l, $enc_o);

##������

	&jcode::convert(\$enc_s, 'jis');
	$enc_l = &base64encode($enc_s);
	$enc_o = "=?ISO-2022-JP?B?${enc_l}?=";

	return $enc_o;
}


##########   ��å��ե�����ǥ�å�   ##########
sub lock
{
##������
##	��å��ե�����̾
	my($file_name) = @_;

##�������
##	�ʤ�

##���������ѿ�
	my($busy) = 5;

##������

	while(!symlink(".", $file_name)){
		if(--$busy <= 0){
			&error_html("��å�������Ԥ��ޤ���Ǥ�������ۤɤ������������"); 
		}
		sleep(1);
	}
}


##########         ��å����         ##########
sub unlock
{
##������
##	��å��ե�����̾
	my($file_name) = @_;

##�������
##	�ʤ�

##���������ѿ�

##������

	unlink($file_name);
}


##########      �ե������ɤ߹���      ##########
sub fread
{
##������
##	�ե�����̾
##	�ɤ߹��ߥ⡼�� (0 = ASCII MODE, 1 = BINARY MODE)
##	���顼������ (0 = ̵��, 1 = ���顼����)
	my($file_name, $binary, $RaiseError) = @_;

##�������
##	�ɤ߹�����ǡ���
	my(@data);

##���������ѿ�
	my($flag);

##������

##	�ե����륪���ץ�
	foreach (1..2){
		if(open(FR, "$file_name")){
			$flag++;
			last;
		}
		else{
			sleep(1);
		}
	}
	if(($RaiseError) && ($flag == 0)){
		die(&error_html("��$file_name�ۤ򳫤��ޤ���Ǥ�����<BR>\n            ��EC:$!��"));
	}

##	�Х��ʥ�⡼��
	if($binary == 1){
		binmode(FR);
	}

##	�ɤ߹���
	@data = <FR>;

	close(FR);

	return (@data);
}


##########      �ե�����񤭹���      ##########
sub fwrite
{
##������
##	�ե�����̾
##	�񤭹����ѿ�
##	�񤭹��ߥ⡼�� (0 = ASCII MODE, 1 = BINARY MODE)
##	�ѡ��ߥå����
##	���顼������ (0 = ̵��, 1 = ���顼����)
	my($file_name, $data, $binary, $permission, $RaiseError) = @_;

##�������
##	�ʤ�

##���������ѿ�
	my($flag);

##������

##	��å�����
	&lock("$file_name.lock");

##	�ե����륪���ץ�
	foreach ( 1..2 ){
		if(open(FW, ">> $file_name")){
			$flag++;
			last;
		}
		else{
			sleep(1);
		}
	}
	if(($RaiseError) && ($flag == 0)){
		die(&error_html("��$file_name�ۤ򳫤��ޤ���Ǥ�����<BR>\n            ��EC:$!��"));
	}

##	�Х��ʥ�⡼��
	if($binary == 1){
		binmode(FW);
	}

##	�񤭹���
	flock(FW, 2);
	truncate(FW, 0);
	seek(FW, 0, 0);
	print FW $data;

	close(FW);

##	�ѡ��ߥå������ѹ�
	chmod($permission, $file_name);

##	��å����
	&unlock("$file_name.lock");
}


##########    �ե����륢�åץ���    ##########
sub upload
{
##������
##	��¸�ե�����̾
##	��¸�ե�������¸�ǥ��쥯�ȥ꡼
##	FORM ��������줿 VALUE
	my($file_name, $path, $value) = @_;

##�������
##	�ʤ�

##���������ѿ�

##������

##	�ե�����򥢥åץ��ɤ���
	unlink "$path$file_name";
	open(FW, ">> $path$file_name") or die &error_html("��$path$file_name�ۤ򳫤��ޤ���Ǥ�����<BR>\n            ��EC:$!��");
		binmode(FW);
		while($bytesread = read($value, $buffer, "2048")){
			print FW $buffer;
		}
	close(FW);

	return $file_name;
}


##########      HTML���������      ##########
sub html_location
{
##������
##	���������URL
	my($url) = @_;

##�������
##	�ʤ� (��λ)

##���������ѿ�

##������

	print <<EOM;
Content-type: text/html
Pragma: no-cache
Cache-Control: no-cache
Expires: Thu, 01 Dec 1994 16:00:00 GMT

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML LANG="ja">
<HEAD>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=euc-jp">
  <META HTTP-EQUIV="Content-Language" CONTENT="ja">
  <META HTTP-EQUIV="Content-Script-Type" CONTENT="text/javascript">
  <META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
  <META HTTP-EQUIV="Expires" CONTENT="0">
</HEAD>
<BODY onLoad="javascript: document.input.submit();">
<FORM METHOD="POST" ACTION="$url" NAME="input">
EOM

	foreach $key(sort keys %FORM){
		if($key =~ /^u_id$|^u_password$|^cookie$|^login_mode$/){
			next;
		}
		print "<INPUT TYPE=\"HIDDEN\" NAME=\"$key\" VALUE=\"$FORM{$key}\">\n";
	}

	print <<EOM;
</FORM>
</BODY>
</HTML>
EOM
	exit;
}


##########        ���������        ##########
sub location
{
##������
##	���������URL
	my($url) = @_;

##�������
##	�ʤ� (��λ)

##���������ѿ�

##������

	print "Location: $url\n";
	print "\n";
	exit;
}


##########      ���å����ɤ߹���      ##########
sub get_cookie
{
##������
##	���å���̾
	my($key) = @_;

##�������
##	���å����Υǡ���
	my($result);

##���������ѿ�
	my(@data, $data, $tmpkey, $tmpval);

##������

	@data = split(/; /, $ENV{'HTTP_COOKIE'});
	foreach $data(@data){
		if($data =~ /^([^=]+)=(.+)/){
			$tmpkey = $1;
			$tmpval = $2;
		}
		else{
			$tmpkey = "";
			$tmpval = $data;
		}
		if($tmpkey eq $key){
			$result = $tmpval;
			$result =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
			last;
		}
	}

	return $result;
}


##########      ���å����񤭹���      ##########
sub set_cookie
{
##������
##	���å���̾
##	��
##	�ѥ� (��ά�ϥǥե����)
##	ͭ������ (���ߤ���Ρ�ʬ�פǻ���)
	my($key, $val, $path, $expmin) = @_;

##�������
##	�ʤ�

##���������ѿ�
	my(@temp, $cookie, $expires);

##������

##	����ե��٥åȰʳ��ϥ��󥳡���
	$val =~ s/(\W)/sprintf("%%%02X", unpack("C", $1))/eg;

	$cookie = "Set-Cookie: $key=$val;";

##	�ѥ�
	if($path){
		$cookie .= " path=$path;";
	}

##	ͭ������
	if($expmin){
		@temp = gmtime(time + $expmin * 60);
		$expires = sprintf( "%s, %d-%s-%04d %02d:%02d:%02d GMT" ,
					(Sun,Mon,Tue,Wed,Thu,Fri,Sat)[$temp[6]],
					$temp[3],
					(Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec)[$temp[4]],
					$temp[5] + 1900,
					$temp[2], $temp[1], $temp[0] );
		$cookie .= " expires=$expires;";
	}

##	�񤭹���
	print "$cookie\n";
}


##########        ���å������        ##########
sub del_cookie
{
##������
##	���å���̾
	my($key) = @_;

##�������
##	���Υ��å�������
	my($result);

##���������ѿ�
	my($cookie);

##������

##	����ѥ��å���
	$cookie = "Set-Cookie: $key=0; expires=Thu, 1-Jan-1980 00:00:00 GMT;";

##	��˥��å������ͤ����
	$result = &get_cookie($key);

##	�񤭽Ф�
	print "$cookie\n";

	return $result;
}


##########    �����νĲ�����������    ##########
sub get_imagesize
{
##������
##	�����ե�����̾ (�ѥ��ޤ�)
	my($filename) = @_;

##�������
##	�����νĲ�������
	my($width, $height);

##���������ѿ�
	my($buf);

##������

##	����¸�ߥ����å�
	-f $filename or return (0, 0);

##	���������ץ� (BIN�⡼��)
	open(IMG, $filename) or return (0, 0);
	binmode(IMG);

##	�����Υ����פϥե�����̾��Ƚ��
#	GIF
	if($filename =~ /\.gif$/){
		seek(IMG, 6, 0);
		read(IMG, $buf, 2);
		$width = unpack("v*", $buf);
		read(IMG, $buf, 2);
		$height = unpack("v*", $buf);
	}
#	PNG
	elsif($filename =~ /\.png$/){
		seek(IMG, 8, 0);
		while(read(IMG, $buf, 8)){
		    my($offset, $CODE) = unpack("NA4", $buf);
		    if($CODE eq 'IHDR'){
				read(IMG, $buf, 8);
				($width, $height) = unpack("NN", $buf);
				last;
		    }
		    elsif($CODE eq 'IEND'){
				last;
			}
			seek(IMG, $offset + 4, 1);
		}
	}
#	JPEG
	elsif($filename =~ /\.jpe?g?$/){
		seek(IMG, 0, 0);
		read(IMG, $buf, 2);
		my($type);
		($buf, $type) = unpack("C*", $buf);
		if($buf == 0xFF && $type == 0xD8){
			my($mark) = pack("C", 0xff);
			while(read(IMG, $buf, 1)){
				next if($buf ne $mark);
				read(IMG, $buf, 1);
				$type = unpack("C*", $buf);
				read(IMG, $buf, 2);
				my($f_size) = unpack("n*", $buf) - 2;
				if($type == 0xD9 || $type == 0xDA){
					last;
				}
				elsif($type == 0xC0 || $type == 0xC2){
					read(IMG, $buf, $f_size);
					$height = unpack("n*", substr($buf, 1, 2));
					$width  = unpack("n*", substr($buf, 3, 2));
					last;
				}
				elsif($type == 0x01 || ($type >= 0xD0 && $type < 0xD9)){
					seek(IMG, -2, 1);
				}
				else{
					read(IMG, $buf, $f_size);
				}
			}
		}
	}

##	����������
	close(IMG);

	return($width, $height);
}


################################################################################################################################################################################
##################################################                                    HTML                                    ##################################################
################################################################################################################################################################################


##########    HTML�إå����񤭽Ф�    ##########
sub html_head
{
	print <<EOM;
Content-type: text/html

<HTML LANG="ja">
<HEAD>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=euc-jp">
  <TITLE>�ǥХå�</TITLE>
</HEAD>
<BODY BGCOLOR="#123456">
<FONT SIZE="-1" COLOR="#FFFFFF">
EOM
	return "";
}


1;