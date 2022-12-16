#!/usr/bin/perl


################################################################################################################################################################################
# 当プログラムの著作権は(株)スタジオキャンビーが保有しています。
# プログラムの改変・改良は自由ですが、コピーして利用する事を禁じます。
# 
# Copyright(C) Studio Canbe Corp. All rights reserved.
# Delivered: 2007-11-30
################################################################################################################################################################################


##########    ライブラリインポート    ##########
# CGI共通ライブラリのインポート
require			"../cgibin/common/common.pl";

# 日本語コード変換ライブラリのインポート
require			"../cgibin/common/jcode.pl";

# フォーム初期設定ライブラリのインポート
require			"__form/default.cfg";


##########         メイン処理         ##########
MAIN:{
	foreach $data(&fread($CONFIG{'csv_column_file'}, 0, 1)){
		chomp $data;
		$FORM{$data} = "";
	}
	&decode;

	unless($FORM{'p'}){
		&error_html("製品が指定されていません。");
	}

##	当日データ取得
	&get_current_times;

##●入・再入力ページ
	if($FORM{'mode'} eq "" || $FORM{'mode'} eq "input_html"){
##		HTML エンコード
		foreach $key(keys %FORM){
			$FORM{$key} = &html_encode($FORM{$key});
		}

##		入力ページ
		&input_html;
	}
##●内容確認ページ
	elsif($FORM{'mode'} eq "confirm_html"){
##		エラーチェック
		$errmsg = &input_check;
		if($errmsg ne ""){
##			HTML エンコード
			foreach $key(keys %FORM){
				$FORM{$key} = &html_encode($FORM{$key});
			}

			&input_html;
		}

##		HTML エンコード
		foreach $key(keys %FORM){
			$FORM{$key} = &html_encode($FORM{$key});
		}

##		内容確認ページ
		&confirm_html;
	}
##●メール送信, 送信完了ページ
	elsif($FORM{'mode'} eq "complete_html"){
##		エラーチェック
		$errmsg = &input_check;
		if($errmsg ne ""){
			&input_html;
		}

####	CSV出力
##		カラムリスト
		@column = &fread($CONFIG{'csv_column_file'}, 0, 1);

##		ファイル名取得
		$CONFIG{'csv_file'} =~ s/YYYY/$FORM{'current_year'}/g;
		$CONFIG{'csv_file'} =~ s/MM/$FORM{'current_mon'}/g;
		$CONFIG{'csv_file'} =~ s/DD/$FORM{'current_day'}/g;

##		旧ボディー
		open(FR, $CONFIG{'csv_file'});
		@body = <FR>;
		close(FR);
		$old_body = join("", @body);

##		旧ボディーがない場合、ヘッダーを作成
		if($old_body eq ""){
			@header = &fread($CONFIG{'csv_head_file'}, 0, 1);
			$header = join("", @header);
			$header =~ s/\r\n/\n/g;
			$header =~ s/\r/\n/g;
			$header =~ s/\n/","/g;
			$header =~ s/","$//g;
			$header = "\"$header\"\r\n";
		}

##		初期値
		my(@prefectures)	= &fread("__DATABASE/prefectures.dia", 0, 1);
		my(@contact_type)	= &fread("__DATABASE/contact_type.dia", 0, 1);

##		追加ボディー
		$add_body = "";
		for(my $i = 0; $i < @column; $i++){
			$column[$i] =~ s/\r\n/\n/g;
			$column[$i] =~ s/\r/\n/g;
			$column[$i] =~ s/\n//g;
			$FORM{$column[$i]} =~ s/"/”/g;

##			郵便番号:本番/枝番は無視
			if($column[$i] eq "zipcode1" || $column[$i] eq "zipcode2"){
				next;
			}
##			ＴＥＬ:市外局番/市内局番/加入番号は無視
			if($column[$i] eq "tel1" || $column[$i] eq "tel2" || $column[$i] eq "tel3"){
				next;
			}
##			お問い合わせ項目
			elsif($column[$i] eq "contact_type"){
				foreach $data(@contact_type){
					my($code, $name) = split(/<>/, $data);
					if($code eq $FORM{'contact_type'}){
						$add_body .= "\"$name\",";
					}
				}
			}
##			都道府県
			elsif($column[$i] eq "prefectures"){
				foreach $data(@prefectures){
					my($code, $name) = split(/<>/, $data);
					if($code eq $FORM{'prefectures'}){
						$add_body .= "\"$name\",";
					}
				}
			}
##			上記以外
			else{
				$add_body .= "\"$FORM{$column[$i]}\",";
			}
		}
		$add_body =~ s/,$/\r\n/g;
		&jcode::convert(\$add_body, 'sjis', 'euc');

##		書き込み
		&fwrite($CONFIG{'csv_file'}, "$header$old_body$add_body", 0, 0666, 1);

####	メール送信
##		メールの送信:ユーザー宛
		if($FORM{'email'} ne ""){
			$mail_body		= &make_mail_body($CONFIG{'body_file_user'});
			$mail_sender	= &base64encode_email($CONFIG{'mail_sender'});
			$from_email		= "\"$mail_sender\" <$CONFIG{'from_email'}>";
			$subject		= &base64encode_email($CONFIG{'subject_user'});
			&sendmail($CONFIG{'error_email'}, $FORM{'email'}, $CONFIG{'cc_email'}, $CONFIG{'bcc_email'}, $from_email, $subject, $mail_body, '', '', '', 0);
		}

##		メールの送信:サイト管理者宛
		$mail_body		= &make_mail_body($CONFIG{'body_file_admin'});
		$mail_sender	= &base64encode_email("$FORM{'name1'} 様");
		$from_email		= "\"$mail_sender\" <$FORM{'email'}>";
		$subject		= &base64encode_email($CONFIG{'subject_admin'});
		&sendmail($CONFIG{'error_email'}, $CONFIG{'to_email'}, $CONFIG{'cc_email'}, $CONFIG{'bcc_email'}, $from_email, $subject, $mail_body, '', '', '', 0);

####	完了ページ表示
		&location($CONFIG{'complete_html'});
	}
}


################################################################################################################################################################################
##################################################                                SUB ROUTINE                                 ##################################################
################################################################################################################################################################################


##########       メール本文作成       ##########
sub make_mail_body
{
##●引数
##	テンプレートファイル名
	my($file_name) = @_;

##●戻り値
##	メール本文
	my($mail_body);

##●ローカル変数
	my(@data);

##●処理

##●MAILデータ作成

##	お問い合せ項目
	$MAIL{'contact_type'} = "";
	@data = &fread("__DATABASE/contact_type.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'contact_type'}){
			$MAIL{'contact_type'} = $name;
		}
	}

##	都道府県
	$MAIL{'prefectures'} = "";
	@data = &fread("__DATABASE/prefectures.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'prefectures'}){
			$MAIL{'prefectures'} = $name;
		}
	}

##●テンプレートファイル読み込み、タグの置換
	$mail_body = join("", &fread($file_name, 0, 1));

##	置換:FORM値
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$mail_body =~ s/<$key>/$FORM{$key}/sg;
	}

##	置換:MAIL値
	foreach $key(sort keys %MAIL){
		$mail_body =~ s/<mail_$key>/$MAIL{$key}/sg;
	}

##	置換:例外処理

	return($mail_body);
}


##########        入力チェック        ##########
sub input_check
{
##●ローカル変数
	my($errmsg);
	my(@data);
	my($flag);

##	製品名 (※)
	if($FORM{'p'} eq ""){
		$errmsg .= "【製品名】が選択されていません。<BR>\n";
	}

##	お問い合せ項目 (※)
	if($FORM{'contact_type'} eq ""){
		$errmsg .= "【お問い合せ項目】が選択されていません。<BR>\n";
	}
	elsif(&compare_tdb("__DATABASE/contact_type.dia", $FORM{'contact_type'}) == 0){
		$errmsg .= "【お問い合せ項目 [ $FORM{'contact_type'} ]】は存在しません。<BR>\n";
	}

##	お問い合せ内容 (※)
	if($FORM{'note'} eq ""){
		$errmsg .= "【お問い合せ内容】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'note'}) > 100000){
		$errmsg .= "【お問い合せ内容】のバイト数が [ 100,000 ] を超えています。<BR>\n";
	}

##	ご氏名:姓 (※)
	if($FORM{'name1'} eq ""){
		$errmsg .= "【ご氏名:姓】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'name1'}) > 20){
		$errmsg .= "【ご氏名:姓】のバイト数が [ 20 ] を超えています。<BR>\n";
	}

##	ご氏名:名 (※)
	if($FORM{'name2'} eq ""){
		$errmsg .= "【ご氏名:名】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'name2'}) > 20){
		$errmsg .= "【ご氏名:名】のバイト数が [ 20 ] を超えています。<BR>\n";
	}

##	フリガナ:セイ (※)
	if($FORM{'f_name1'} eq ""){
		$errmsg .= "【フリガナ:セイ】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'f_name1'}) > 20){
		$errmsg .= "【フリガナ:セイ】のバイト数が [ 20 ] を超えています。<BR>\n";
	}

##	フリガナ:メイ (※)
	if($FORM{'f_name2'} eq ""){
		$errmsg .= "【フリガナ:メイ】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'f_name2'}) > 20){
		$errmsg .= "【フリガナ:メイ】のバイト数が [ 20 ] を超えています。<BR>\n";
	}

##	会社名（店舗名）
	if(length($FORM{'company'}) > 50){
		$errmsg .= "【会社名（店舗名）】のバイト数が [ 50 ] を超えています。<BR>\n";
	}

##	郵便番号:本番 (※)
	$FORM{'zipcode1'} = &zen2han($FORM{'zipcode1'});
	if($FORM{'zipcode1'} eq ""){
		$errmsg .= "【郵便番号:本番】が入力されていません。<BR>\n";
	}
	elsif((length $FORM{'zipcode1'} != 3) || ($FORM{'zipcode1'} =~ /[^0-9]/)){
		$errmsg .= "【郵便番号:本番】が正しく入力されていません。<BR>\n";
	}

##	郵便番号:枝番 (※)
	$FORM{'zipcode2'} = &zen2han($FORM{'zipcode2'});
	if($FORM{'zipcode2'} eq ""){
		$errmsg .= "【郵便番号:枝番】が入力されていません。<BR>\n";
	}
	elsif((length $FORM{'zipcode2'} != 4) || ($FORM{'zipcode2'} =~ /[^0-9]/)){
		$errmsg .= "【郵便番号:枝番】が正しく入力されていません。<BR>\n";
	}

##	郵便番号
	$FORM{'zipcode'} = "$FORM{'zipcode1'}-$FORM{'zipcode2'}";

##	都道府県 (※)
	if($FORM{'prefectures'} eq ""){
		$errmsg .= "【都道府県】が選択されていません。<BR>\n";
	}
	elsif(&compare_tdb("__DATABASE/prefectures.dia", $FORM{'prefectures'}) == 0){
		$errmsg .= "【都道府県 [ $FORM{'prefectures'} ]】は存在しません。<BR>\n";
	}

##	市区町村 (※)
	if($FORM{'address1'} eq ""){
		$errmsg .= "【市区町村】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'address1'}) > 100){
		$errmsg .= "【市区町村】のバイト数が [ 100 ] を超えています。<BR>\n";
	}

##	番地 (※)
	if($FORM{'address2'} eq ""){
		$errmsg .= "【番地】が入力されていません。<BR>\n";
	}
	elsif(length($FORM{'address2'}) > 100){
		$errmsg .= "【番地】のバイト数が [ 100 ] を超えています。<BR>\n";
	}

##	ビル・マンション名
	if(length($FORM{'address3'}) > 100){
		$errmsg .= "【ビル・マンション名】のバイト数が [ 100 ] を超えています。<BR>\n";
	}

##	ＴＥＬ:市外局番 (※)
	$FORM{'tel1'} = &zen2han($FORM{'tel1'});
	if($FORM{'tel1'} eq ""){
		$errmsg .= "【ＴＥＬ:市外局番】が入力されていません。<BR>\n";
	}
	elsif($FORM{'tel1'} =~ /[^0-9-]/){
		$errmsg .= "【ＴＥＬ:市外局番】が正しく入力されていません。<BR>\n";
	}
	elsif(length($FORM{'tel1'}) > 7){
		$errmsg .= "【ＴＥＬ:市外局番】のバイト数が [ 7 ] を超えています。<BR>\n";
	}

##	ＴＥＬ:市内局番 (※)
	$FORM{'tel2'} = &zen2han($FORM{'tel2'});
	if($FORM{'tel2'} eq ""){
		$errmsg .= "【ＴＥＬ:市内局番】が入力されていません。<BR>\n";
	}
	elsif($FORM{'tel2'} =~ /[^0-9-]/){
		$errmsg .= "【ＴＥＬ:市内局番】が正しく入力されていません。<BR>\n";
	}
	elsif(length($FORM{'tel2'}) > 7){
		$errmsg .= "【ＴＥＬ:市内局番】のバイト数が [ 7 ] を超えています。<BR>\n";
	}

##	ＴＥＬ:加入番号 (※)
	$FORM{'tel3'} = &zen2han($FORM{'tel3'});
	if($FORM{'tel3'} eq ""){
		$errmsg .= "【ＴＥＬ:加入番号】が入力されていません。<BR>\n";
	}
	elsif($FORM{'tel3'} =~ /[^0-9-]/){
		$errmsg .= "【ＴＥＬ:加入番号】が正しく入力されていません。<BR>\n";
	}
	elsif(length($FORM{'tel3'}) > 7){
		$errmsg .= "【ＴＥＬ:加入番号】のバイト数が [ 7 ] を超えています。<BR>\n";
	}

##	ＴＥＬ
	$FORM{'tel'} = "$FORM{'tel1'}-$FORM{'tel2'}-$FORM{'tel3'}";

##	E-mail
	my $mail_regex = '[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*|(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[^()<>@,;:".\\\[\]\x80-\xff\000-\010\012-\037]*(?:(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[^()<>@,;:".\\\[\]\x80-\xff\000-\010\012-\037]*)*<[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*(?:,[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*)*:[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)?(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*>)';

##	E-mail (※)
	$FORM{'email'} =~ s/\s//g;
	$FORM{'email'} = &zen2han($FORM{'email'});
	$FORM{'email'} =~ tr/A-Z/a-z/;
	if($FORM{'email'} eq ""){
		$errmsg .= "【E-mail】が入力されていません。<BR>\n";
	}
	elsif($FORM{'email'} !~ /^$mail_regex$/o){
		$errmsg .= "【E-mail】が正しく入力されていません。<BR>\n";
	}
	elsif(length($FORM{'email'}) > 250){
		$errmsg .= "【E-mail】のバイト数が [ 250 ] を超えています。<BR>\n";
	}

##	アクセス元IPアドレス
	$FORM{'remote_addr'} = $ENV{'REMOTE_ADDR'};

	return($errmsg);
}


################################################################################################################################################################################
##################################################                                    HTML                                    ##################################################
################################################################################################################################################################################


##########        再入力ページ        ##########
sub input_html
{
##●引数
##	なし

##●戻り値
##	なし

##●ローカル変数
	my(@data);
	my($output_html);

##●処理

##●HTMLデータ作成

##	お問い合せ項目
	$HTML{"contact_type"} = "";
	@data = &fread("__DATABASE/contact_type.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'contact_type'}){
			$HTML{"contact_type"} .= "          <option value=\"$code\" selected=\"selected\">$name</option>\n";
		}
		else{
			$HTML{"contact_type"} .= "          <option value=\"$code\">$name</option>\n";
		}
	}
	$HTML{"contact_type"} =~ s/\n$//g;

##	都道府県
	$HTML{"prefectures"} = "";
	@data = &fread("__DATABASE/prefectures.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'prefectures'}){
			$HTML{"prefectures"} .= "          <option value=\"$code\" selected=\"selected\">$name</option>\n";
		}
		else{
			$HTML{"prefectures"} .= "          <option value=\"$code\">$name</option>\n";
		}
	}
	$HTML{"prefectures"} =~ s/\n$//g;

##●テンプレートファイル読み込み、タグの置換
	$output_html = join("", &fread($CONFIG{'input_html'}, 0, 1));
	&jcode::convert(\$output_html, 'euc');

##	置換:エラーメッセージ、ACTION属性
	$output_html =~ s/###errmsg###/$errmsg/sg;
	$output_html =~ s/###action###/$ENV{'SCRIPT_NAME'}/sg;

##	置換:FORM値
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$output_html =~ s/###$key###/$FORM{$key}/sg;
	}

##	置換:HTML値
	foreach $key(sort keys %HTML){
		$output_html =~ s/###html_$key###/$HTML{$key}/sg;
	}

##	置換:例外処理

##●ページ出力
	&jcode::convert(\$output_html, 'sjis', 'euc');
	print <<EOM;
Content-type: text/html
Pragma: no-cache
Cache-Control: no-cache
Expires: Thu, 01 Dec 1994 16:00:00 GMT

$output_html
EOM
	exit;
}


##########       内容確認ページ       ##########
sub confirm_html
{
##●引数
##	なし

##●戻り値
##	なし

##●ローカル変数
	my(@data);
	my($output_html);

##●処理

##●HTMLデータ作成

##	お問い合せ項目
	$HTML{'contact_type'} = "";
	@data = &fread("__DATABASE/contact_type.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'contact_type'}){
			$HTML{'contact_type'} = $name;
		}
	}

##	都道府県
	$HTML{'prefectures'} = "";
	@data = &fread("__DATABASE/prefectures.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'prefectures'}){
			$HTML{'prefectures'} = $name;
		}
	}

##	お問い合せ内容
	$HTML{'note'} = &line2br($FORM{'note'});

##●テンプレートファイル読み込み、タグの置換
	$output_html = join("", &fread($CONFIG{'confirm_html'}, 0, 1));
	&jcode::convert(\$output_html, 'euc');

##	置換:ACTION属性
	$output_html =~ s/###action###/$ENV{'SCRIPT_NAME'}/sg;

##	置換:FORM値
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$output_html =~ s/###$key###/$FORM{$key}/sg;
	}

##	置換:HTML値
	foreach $key(sort keys %HTML){
		$output_html =~ s/###html_$key###/$HTML{$key}/sg;
	}

##	置換:例外処理

##●ページ出力
	&jcode::convert(\$output_html, 'sjis', 'euc');
	print <<EOM;
Content-type: text/html
Pragma: no-cache
Cache-Control: no-cache
Expires: Thu, 01 Dec 1994 16:00:00 GMT

$output_html
EOM
	exit;
}


##########        エラーページ        ##########
sub error_html
{
##●引数
##	エラーメッセージ
	my($errmsg) = @_;

##●戻り値
##	なし

##●ローカル変数
	my($output_html);

##●処理

##●HTMLデータ作成

##●ページ出力
	print <<EOM;
Content-type: text/html; charset=euc-jp
Pragma: no-cache
Cache-Control: no-cache
Expires: Thu, 01 Dec 1994 16:00:00 GMT

$errmsg
EOM
	exit;
}


__END__