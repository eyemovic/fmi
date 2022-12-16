################################################################################################################################################################################
# 当プログラムの著作権は(株)スタジオキャンビーが保有しています。
# プログラムの改変・改良は自由ですが、コピーして利用する事を禁じます。
# 
# Copyright(C) Studio Canbe Corp. All rights reserved.
# Delivered: 2007-11-30
################################################################################################################################################################################


###########   暗号化オブジェクト作成   ##########
#sub make_crypted_object
#{
###●引数
###	暗号化・復号化キー
#	my($crypt_key) = @_;
#
###●戻り値
###	暗号化オブジェクト
#	my($cipher);
#
###●ローカル変数
#
###●処理
#
###	Crypt::CBC を使用する
#	use Crypt::CBC;
#
###	オブジェクト作成
#	$cipher = Crypt::CBC->new({'key' => $crypt_key, 'cipher' => $CONFIG{'crypt_cipher'}, 'iv' => $CONFIG{'crypt_iv'}, 'regenerate_key' => $CONFIG{'crypt_regenerate_key'}, 'padding' => $CONFIG{'crypt_padding'}, 'prepend_iv' => $CONFIG{'crypt_prepend_iv'}});
#
#	return $cipher;
#}


##########      現在の時間を取得      ##########
sub get_current_times
{
##●引数
##	なし

##●戻り値
##	グローバル変数 %FORM にセット

##●ローカル変数

##●処理

	$FORM{'current_timestamp'} = time;

	($FORM{'current_sec'}, $FORM{'current_min'}, $FORM{'current_hour'}, $FORM{'current_day'}, $FORM{'current_mon'}, $FORM{'current_year'}, $FORM{'current_wday'}) = &get_date($FORM{'current_timestamp'}, "jp");

	$FORM{'current_date'} = "$FORM{'current_year'}年$FORM{'current_mon'}月$FORM{'current_day'}日 ($FORM{'current_wday'}) $FORM{'current_hour'}:$FORM{'current_min'}:$FORM{'current_sec'}";
}


##########    生年月日から年齢計算    ##########
sub calc_age
{
##●引数
##	年号 (0 = 西暦, 1 = 明治, 2 = 大正, 3 = 昭和, 4 = 平成)
##	生年月日 年
##	生年月日 月
##	生年月日 日
	my($nengo, $born_year, $born_mon, $born_day) = @_;

##●戻り値
##	年齢
	my($age);

##●ローカル変数
	my(@YEAR_LIST) = qw(0 1867 1911 1925 1988);
	my($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);

##●処理

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


##########       日時・日付取得       ##########
sub get_date
{
##●引数
##	タイムスタンプ
##	曜日の形式 (num = 0〜6 の数字 (デフォルト), en = 英字(省略), english = 英字, jp = 漢字)
	my($timestamp, $weekday) = @_;

##●戻り値
##	秒, 分, 時, 日, 月, 年, 曜日, 年日, isdst
	my($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);

##●ローカル変数

##●処理

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
		$wday = ("日", "月", "火", "水", "木", "金", "土")[$wday];
	}
	elsif($weekday =~ /en/i){
		$wday = ("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT")[$wday];
	}
	elsif($weekday =~ /english/i){
		$wday = ("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")[$wday];
	}

	return ($sec, $min, $hour, $day, $mon, $year, $wday, $yday, $isdst);
}


##########    タイムスタンプを取得    ##########
sub get_timestamp
{
##●引数
##	YYYY.MM.DD.HH.MM.SS 形式の日付
	my($date) = @_;

##●戻り値
##	タイムスタンプ (エポック秒)
	my($timestamp);

##●ローカル変数
	my($year, $mon, $day, $hour, $min, $sec);

##●処理

	($year, $mon, $day, $hour, $min, $sec) = split(/\./, $date);
	$mon--;

	use Time::Local;
	$timestamp = timelocal($sec, $min, $hour, $day, $mon, $year);

	return $timestamp;
}


##########       ツェラーの公式       ##########
sub zeller
{
##●引数
##	年
##	月
##	日
	my($year, $month, $day) = @_;

##●戻り値
##	曜日 (数値型)

##●ローカル変数

##●処理

	if($month < 3){
		$month += 12;
		$year--;
	}

	return($year + int($year / 4) - int($year / 100) + int($year / 400) + int((13 * $month + 8) / 5) + $day) % 7;
}


##########          デコード          ##########
sub decode
{
##●引数
##	なし

##●戻り値
##	なし
##	グローバル変数 %FORM にセット

##●ローカル変数
	my(@pairs);
	my($name, $value);

##●処理

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("【METHOD】を確認してください。");
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


##########    Shift_JIS 用デコード    ##########
sub sjis_decode
{
##●引数
##	なし

##●戻り値
##	なし
##	グローバル変数 %FORM にセット

##●ローカル変数
	my(@pairs);
	my($name, $value);

##●処理

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("【METHOD】を確認してください。");
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


##########       CGI.pmデコード       ##########
sub pm_decode
{
##●引数
##	ハッシュ名
	my($header) = @_;

##●戻り値
##	なし
##	グローバル変数 %$header にセット

##●ローカル変数
	my(@name);

##●処理

##	CGI.pm を使用する
	use CGI;
	$query = new CGI;

##	クエリーデータの NAME 部分を取得
	@name = $query->param;

##	クエリーデータを取得
	foreach $name(@name){
		$$header{$name} = $query->param($name);
		$$header{$name} =~ s/'//g;
	}
}


##########     デバッグ用デコード     ##########
sub debug_decode
{
##●引数
##	なし

##●戻り値
##	なし
##	グローバル変数 %FORM にセット

##●ローカル変数
	my(@pairs);
	my($name, $value);

##●処理

	if($ENV{'REQUEST_METHOD'} eq 'GET'){
		@pairs = split(/&/, $ENV{'QUERY_STRING'});
	}
	elsif($ENV{'REQUEST_METHOD'} eq 'POST'){
		read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
		@pairs = split(/&/, $buffer);
	}
	else{
		&error_html("【METHOD】を確認してください。");
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


##########         エンコード         ##########
sub encode
{
##●引数
##	エンコードする文字列
	my($text) = @_;

##●戻り値
##	エンコード済み文字列
	my($result);

##●ローカル変数
	my(@temp);
	my($temp);

##●処理

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


##########       URLエンコード        ##########
sub url_encode
{
##●引数
##	エンコードする文字列
	my($text) = @_;

##●戻り値
##	エンコード済み文字列
	my($result);

##●ローカル変数
	my(@temp);
	my($temp);

##●処理

	@temp = unpack('C*', $text);
	foreach $temp(@temp){
#		「0-9A-Za-z'()*!-._」はそのままでOK
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


##########       HTMLエンコード       ##########
sub html_encode
{
##●引数
##	HTMLエンコードする文字列
	my($encode) = @_;

##●戻り値
##	HTMLエンコード済み文字列

##●ローカル変数

##●処理

	$encode =~ s/\&/\&amp;/g;
	$encode =~ s/\"/\&quot;/g;
	$encode =~ s/\</\&lt;/g;
	$encode =~ s/\>/\&gt;/g;

	return $encode;
}


##########        HTMLデコード        ##########
sub html_decode
{
##●引数
##	HTMLデコードする文字列
	my($decode) = @_;

##●戻り値
##	HTMLデコード済み文字列

##●ローカル変数

##●処理

	$decode =~ s/\&amp;/\&/g;
	$decode =~ s/\&quot;/\"/g;
	$decode =~ s/\&lt;/\</g;
	$decode =~ s/\&gt;/\>/g;

	return $decode;
}


##########  ひらがなをカタカナに変換  ##########
sub hira2kana
{
##●引数
##	変換する文字列
	my($keyword) = @_;

##●戻り値
##	変換された文字列

##●ローカル変数

##●処理

	$keyword =~ s/\xa5\xa4/`/g;
	$keyword =~ s/\xa4([\xa1-\xfe])/\xa5$1/g;
	$keyword =~ s/`/\xa5\xa4/g;

	return $keyword;
}


##########      改行を<BR>に変換      ##########
sub line2br
{
##●引数
##	置換する文字列
	my($line) = @_;

##●戻り値
##	<BR>に置換済み文字列

##●ローカル変数

##●処理

	$line =~ s/\r\n/\n/g;
	$line =~ s/\r/\n/g;
	$line =~ s/\n/<BR>/g;

	return $line;
}


##########      <BR>を改行に変換      ##########
sub br2line
{
##●引数
##	置換する文字列
	my($line) = @_;

##●戻り値
##	改行に置換済み文字列

##●ローカル変数

##●処理

	$line =~ s/<BR>/\n/g;

	return $line;
}


##########文字をスペース区切りで配列化##########
sub split_words
{
##●引数
##	分割する文字
	my($words) = @_;

##●戻り値
##	分割された文字配列
	my(@words, @temp_words);

##●ローカル変数
	my $ascii = '[\x00-\x7F]';
	my $twoBytes = '(?:[\x8E\xA1-\xFE][\xA1-\xFE])';
	my $threeBytes = '(?:\x8F[\xA1-\xFE][\xA1-\xFE])';
	my $Zspace = '(?:\xA1\xA1)';
	my $character = "(?:$ascii|$twoBytes|$threeBytes)";

##●処理

##	行頭・行末の不要な文字を削除
	$words =~ s/^(?:\s|$Zspace)+//o;
	$words =~ s/^($character*?)(?:\s|$Zspace)+$/$1/o;

##	文字内の区切り文字を半角スペースに統一する
	$words =~ s/\s/ /g;
	$words =~ s/　/ /g;

##	配列に代入
	@temp_words = split(/ /, $words);

##	空白の変数を削除
	foreach $data(@temp_words){
		if($data ne ""){
			push(@words, $data);
		}
	}

	return @words;
}


##########          文字省略          ##########
sub cut_text
{
##●引数
##	処理する文字列 (EUC-JPのみ)
##	最大文字数
	my($text, $max) = @_;

##●戻り値
##	文字省略済み文字列
	my($res);

##●ローカル変数
	my($len, $euc);

##●処理

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


##########        数値の位取り        ##########
sub put_comma
{
##●引数
##	位取りする数値
	my($number) = @_;

##●戻り値
##	位取り済み数値

##●ローカル変数

##●処理

	if(length($number) > 3){
		$number = reverse(join(',', reverse($number) =~ /((?:^\d+\.)?\d{1,3}[-+]?)/g)) if $number =~ /^[-+]?\d\d\d\d/;
	}

	return $number;
}


##########文中のURL をハイバーリンク化##########
sub url2link
{
##●引数
##	HTMLデータ
##	リンクのターゲット (デフォルト：_blank)
	my($html, $target) = @_;

##●戻り値
##	ハイパーリンク化済みHTMLデータ

##●ローカル変数

##●処理

	if($target eq ""){
		$target = "_blank";
	}

	$html =~ s/([^=^\"]|^)(https?\:[\w\.\~\-\/\?\&\=\@\;\#\:\%]+)/$1<A HREF=\"$2\" TARGET=\"$target\">$2<\/A>/g;

	return $html;
}


##########        数値の整数化        ##########
sub value2int
{
##●引数
##	整数化する数値
	my($value) = @_;

##●戻り値
##	整数化済み数値

##●ローカル変数

##●処理

##	全角数字を半角数字化
	$value = &zen2han($value);

##	数値を整数化
	$value = int $value;

	return $value;
}


##########    全角文字を半角に変換    ##########
sub zen2han
{
##●引数
##	変換する文字列 (EUC-JPのみ)
	my($text) = @_;

##●戻り値
##	変換済み文字列

##●ローカル変数
	my($euc);

##●処理

	$euc = q{[\x00-\x7F]|\x8E[\xA0-\xDF]|\x8F[\xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE]};

##	英数字
	$text =~ s/\G((?:$euc)*?)\xA3([\xB0-\xB9\xC1-\xFA])/$1.chr(ord($2)-128)/ego;

##	ピリオドのつもり(。．)
	$text =~ s/\G((?:$euc)*?)\xA1([\xA3\xA5])/$1\./go;

##	ハイフンらしき文字(ー ― ‐−)
	$text =~ s/\G((?:$euc)*?)\xA1([\xBC-\xBE\xDD])/$1\-/go;

##	スラッシュ
	$text =~ s/\G((?:$euc)*?)／/$1\//go;

##	アットマーク
	$text =~ s/\G((?:$euc)*?)＠/$1\@/go;

##	丸カッコ
	$text =~ s/\G((?:$euc)*?)\xA1([\xCA\xCB])/$1.chr(ord($2)-162)/ego;

	return $text;
}


##########    テキストの折りたたみ    ##########
sub wrap_text
{
##●引数
##	折りたたみする文字列
##	折りたたみするバイト位置 (＝最大文字数、インデント含む)
##	インデントするバイト位置
##	最初の行のインデント (0 = しない, 1 = する)
	my($text, $max, $indent, $firstline) = @_;

##●戻り値
##	折りたたみ済み文字列
	my($result);

##●ローカル変数
	my($euc);
	my($itx, $temp);

##●処理

	$euc = q{[\x00-\x7F]|\x8E[\xA0-\xDF]|\x8F[\xA1-\xFE][\xA1-\xFE]|[\xA1-\xFE][\xA1-\xFE]};

##	事前処理
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
##			折り返し処理
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
##			1行目がMAXバイト以下ならそのまま
			$result .= "$itx$text\n";
		}
	}

	if(($indent) && ($firstline == 0)){
		$result =~ s/^\s{$indent}//;
	}

	return $result;
}


##########     パスワード自動生成     ##########
sub make_password
{
##●引数
##	パスワードの最大バイト数
	my($figure) = @_;

##●戻り値
##	生成済みパスワード
	my($password);

##●ローカル変数

##●処理

##	パスワードの生成
	$password = crypt(rand(1000), rand(99));

##	不正な文字列と間違えやすい文字列を削除
	$password =~ s/[.\/0Ol1iI]//g;

##	最大長を調整
	$password = substr($password, -$figure);

	return $password;
}


########## 照合ファイルとデータの照合 ##########
sub compare_tdb
{
##●引数
##	照合する為のファイル名
##	チェックするデータ
	my($fname, $value) = @_;

##●戻り値
##	0 = 照合, 1 = 非照合

##●ローカル変数
	my(@data);

##●処理

	foreach $data(&fread($fname, 0, 1)){
		chomp $data;
		($code, $name) = split("<>", $data);

		if($code eq $value){
			return 1;
		}
	}

	return 0;
}


##########    E-MAIL送信(sendmail)    ##########
sub sendmail
{
##●引数
##	エラー時のメール送信先
##	送信先 (複数の場合はカンマで区切る)
##	Cc送信先 (複数の場合はカンマで区切る)
##	Bcc送信先 (複数の場合はカンマで区切る)
##	差出人 (書式例: "差出人名" <差出人メールアドレス>)
##	件名
##	本文 (text/plain)
##	本文 (text/html)
##	添付ファイル名
##	添付ファイルパス
##	デバッグ処理 (0 = NO[メール送信], 1 = YES[画面出力])
	my($errors_to, $to, $cc, $bcc, $from, $subject, $text_body, $html_body, $attached_name, $attached_path, $debug) = @_;


##●戻り値
##	なし

##●ローカル変数
	my($senddata);

##●処理

##	必須項目が抜けていないかチェック
	if($errors_to eq ""){
		&error_html("システムエラー。&sendmail has a error.<BR>\nNo \$errors_to.<BR>\nSystem error message: $!");
	}
	elsif($to eq ""){
		&error_html("システムエラー。&sendmail has a error.<BR>\nNo \$to.<BR>\nSystem error message: $!");
	}
	elsif($text_body eq ""){
		&error_html("システムエラー。&sendmail has a error.<BR>\nNo \$text_body.<BR>\nSystem error message: $!");
	}

##	境界
	my($partition) = "------partition." . time;

##	マルチパート
	my($multi_part) = 0;
	if($html_body ne "" || ($attached_name ne "" && -f $attached_path == 1)){
		$multi_part  = 1;
	}

####メールヘッダー
	if($multi_part == 1){
		$senddata	.= "Content-Type: multipart/mixed; boundary=\"$partition\"\n";
		$senddata	.= "Content-Transfer-Encoding:Base64\n";
	}
	$senddata		.= "To: $to\n";
	$senddata		.= "Cc: $cc\n";
	$senddata		.= "Bcc: $bcc\n";
	$senddata		.= "From: $from\n";
	$senddata		.= "Subject: $subject\n";

####本文 (text/plain)
	if($multi_part == 1){
		$senddata	.= "--$partition\n";
	}
	$senddata		.= "Content-Type: text/plain; charset=\"iso-2022-jp\"\n";
	$senddata		.= "\n";
	$senddata		.= $text_body;
	$senddata		.= "\n";

####本文 (text/html)
	if($html_body ne ""){
		$senddata	.= "--$partition\n";
		$senddata	.= "Content-Type: text/html; charset=\"iso-2022-jp\"\n";
		$senddata	.= "\n";
		$senddata	.= $html_body;
		$senddata	.= "\n";
	}

####添付ファイル
	if($attached_name ne "" && -f $attached_path == 1){
##		添付ファイル名をMIMEエンコード
		&jcode::convert(\$attached_name, 'sjis', 'euc');
		$attached_name = &mimeencode($attached_name);

##		添付ファイルをBASE64エンコード
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

##	マルチパートの場合フッターを付与
	if($multi_part == 1){
		$senddata	.= "--$partition--\n";
	}

##	文字コードの変換
	&jcode::convert(\$senddata, "jis", "euc", "z");

##●メール送信
	if($debug == 0){
		open(ML, "| $CONFIG{'sendmail'} -t -f $errors_to") or die &error_html("【メールサーバーエラー】の為にメールを送信できませんでした。エラーコード【$!】");
		print ML $senddata;
		close(ML);
	}
##●画面出力
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


###########      E-MAIL送信(SMTP)      ##########
#sub smtp_sendmail
#{
###●引数
###	To: (BASE64エンコード済)
###	Cc:
###	Bcc:
###	From:
###	Subject: (BASE64エンコード済)
###	Message: (JISエンコード済)
#	my($to, $cc, $bcc, $from, $subject, $message) = @_;
#
###●戻り値
###	なし
#
###●ローカル変数
#	my($SMTP);
#
###●処理
#
#	use Net::SMTP;
#	use Authen::SASL;
#
###	日時の生成
#	my($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdat) = gmtime(time + 60 * 60 * 9);
#	my($week)	= ('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat')[$wday];
#	my($month)	= ('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')[$mon];
#	my($date)	= sprintf("%s, %02d %s %04d %02d:%02d:%02d +0900", $week, $mday, $month, $year+1900, $hour, $min, $sec);
#
###	オブジェクトの作成
#	$SMTP = Net::SMTP -> new($CONFIG{'smtp'},
#				Hello => $CONFIG{'smtp'},
#				Timeout => 60) or die &error_html("new ERROR:[$CONFIG{'smtp'}]$!");
#
###	認証
#	$SMTP -> auth($CONFIG{'auth_id'}, $CONFIG{'auth_pass'}) or die &error_html("auth ERROR:[$CONFIG{'auth_id'}], [$CONFIG{'auth_pass'}]$!");
#
###	ヘッダー
#	$SMTP -> mail($from) or die &error_html("mail error:$!");
#	$SMTP -> to($to) or die &error_html("to error:[$to]$!");
#	if($cc ne ""){
#		$SMTP -> cc($cc) or die &error_html("cc error:[$cc]$!");
#	}
#	if($bcc ne ""){
#		$SMTP -> bcc($bcc) or die &error_html("bcc error:[$bcc]$!");
#	}
#
###	データ
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


##########      BASE64エンコード      ##########
sub base64encode
{
##●引数
##	BASE64エンコードする文字列
	my($text) = @_;

##●戻り値
##	BASE64エンコード済み文字列

##●ローカル変数
	my($base);
	my($xx, $yy, $zz, $i);

##●処理

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


##########  BASE64エンコード(E-MAIL)  ##########
sub base64encode_email
{
##●引数
##	BASE64エンコード(E-MAIL)する文字列
	my($enc_s) = @_;

##●戻り値
##	BASE64エンコード(E-MAIL)済み文字列

##●ローカル変数
	my($enc_l, $enc_o);

##●処理

	&jcode::convert(\$enc_s, 'jis');
	$enc_l = &base64encode($enc_s);
	$enc_o = "=?ISO-2022-JP?B?${enc_l}?=";

	return $enc_o;
}


##########   ロックファイルでロック   ##########
sub lock
{
##●引数
##	ロックファイル名
	my($file_name) = @_;

##●戻り値
##	なし

##●ローカル変数
	my($busy) = 5;

##●処理

	while(!symlink(".", $file_name)){
		if(--$busy <= 0){
			&error_html("ロック処理を行えませんでした。後ほどお試しください。"); 
		}
		sleep(1);
	}
}


##########         ロック解除         ##########
sub unlock
{
##●引数
##	ロックファイル名
	my($file_name) = @_;

##●戻り値
##	なし

##●ローカル変数

##●処理

	unlink($file_name);
}


##########      ファイル読み込み      ##########
sub fread
{
##●引数
##	ファイル名
##	読み込みモード (0 = ASCII MODE, 1 = BINARY MODE)
##	エラー時処理 (0 = 無視, 1 = エラー処理)
	my($file_name, $binary, $RaiseError) = @_;

##●戻り値
##	読み込んだデータ
	my(@data);

##●ローカル変数
	my($flag);

##●処理

##	ファイルオープン
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
		die(&error_html("【$file_name】を開けませんでした。<BR>\n            【EC:$!】"));
	}

##	バイナリモード
	if($binary == 1){
		binmode(FR);
	}

##	読み込み
	@data = <FR>;

	close(FR);

	return (@data);
}


##########      ファイル書き込み      ##########
sub fwrite
{
##●引数
##	ファイル名
##	書き込む変数
##	書き込みモード (0 = ASCII MODE, 1 = BINARY MODE)
##	パーミッション
##	エラー時処理 (0 = 無視, 1 = エラー処理)
	my($file_name, $data, $binary, $permission, $RaiseError) = @_;

##●戻り値
##	なし

##●ローカル変数
	my($flag);

##●処理

##	ロック処理
	&lock("$file_name.lock");

##	ファイルオープン
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
		die(&error_html("【$file_name】を開けませんでした。<BR>\n            【EC:$!】"));
	}

##	バイナリモード
	if($binary == 1){
		binmode(FW);
	}

##	書き込み
	flock(FW, 2);
	truncate(FW, 0);
	seek(FW, 0, 0);
	print FW $data;

	close(FW);

##	パーミッションの変更
	chmod($permission, $file_name);

##	ロック解除
	&unlock("$file_name.lock");
}


##########    ファイルアップロード    ##########
sub upload
{
##●引数
##	保存ファイル名
##	保存ファイル保存ディレクトリー
##	FORM から送られた VALUE
	my($file_name, $path, $value) = @_;

##●戻り値
##	なし

##●ローカル変数

##●処理

##	ファイルをアップロードする
	unlink "$path$file_name";
	open(FW, ">> $path$file_name") or die &error_html("【$path$file_name】を開けませんでした。<BR>\n            【EC:$!】");
		binmode(FW);
		while($bytesread = read($value, $buffer, "2048")){
			print FW $buffer;
		}
	close(FW);

	return $file_name;
}


##########      HTMLロケーション      ##########
sub html_location
{
##●引数
##	ロケーションURL
	my($url) = @_;

##●戻り値
##	なし (終了)

##●ローカル変数

##●処理

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


##########        ロケーション        ##########
sub location
{
##●引数
##	ロケーションURL
	my($url) = @_;

##●戻り値
##	なし (終了)

##●ローカル変数

##●処理

	print "Location: $url\n";
	print "\n";
	exit;
}


##########      クッキー読み込み      ##########
sub get_cookie
{
##●引数
##	クッキー名
	my($key) = @_;

##●戻り値
##	クッキーのデータ
	my($result);

##●ローカル変数
	my(@data, $data, $tmpkey, $tmpval);

##●処理

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


##########      クッキー書き込み      ##########
sub set_cookie
{
##●引数
##	クッキー名
##	値
##	パス (省略はデフォルト)
##	有効期限 (現在からの「分」で指定)
	my($key, $val, $path, $expmin) = @_;

##●戻り値
##	なし

##●ローカル変数
	my(@temp, $cookie, $expires);

##●処理

##	アルファベット以外はエンコード
	$val =~ s/(\W)/sprintf("%%%02X", unpack("C", $1))/eg;

	$cookie = "Set-Cookie: $key=$val;";

##	パス
	if($path){
		$cookie .= " path=$path;";
	}

##	有効期限
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

##	書き込み
	print "$cookie\n";
}


##########        クッキー削除        ##########
sub del_cookie
{
##●引数
##	クッキー名
	my($key) = @_;

##●戻り値
##	そのクッキーの値
	my($result);

##●ローカル変数
	my($cookie);

##●処理

##	削除用クッキー
	$cookie = "Set-Cookie: $key=0; expires=Thu, 1-Jan-1980 00:00:00 GMT;";

##	先にクッキーの値を取得
	$result = &get_cookie($key);

##	書き出し
	print "$cookie\n";

	return $result;
}


##########    画像の縦横サイズ取得    ##########
sub get_imagesize
{
##●引数
##	画像ファイル名 (パス含む)
	my($filename) = @_;

##●戻り値
##	画像の縦横サイズ
	my($width, $height);

##●ローカル変数
	my($buf);

##●処理

##	画像存在チェック
	-f $filename or return (0, 0);

##	画像オープン (BINモード)
	open(IMG, $filename) or return (0, 0);
	binmode(IMG);

##	画像のタイプはファイル名で判別
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

##	画像クローズ
	close(IMG);

	return($width, $height);
}


################################################################################################################################################################################
##################################################                                    HTML                                    ##################################################
################################################################################################################################################################################


##########    HTMLヘッダー書き出し    ##########
sub html_head
{
	print <<EOM;
Content-type: text/html

<HTML LANG="ja">
<HEAD>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=euc-jp">
  <TITLE>デバッグ</TITLE>
</HEAD>
<BODY BGCOLOR="#123456">
<FONT SIZE="-1" COLOR="#FFFFFF">
EOM
	return "";
}


1;