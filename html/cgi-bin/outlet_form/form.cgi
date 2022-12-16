#!/usr/bin/perl


################################################################################################################################################################################
# ���ץ����������(��)�������������ӡ�����ͭ���Ƥ��ޤ���
# �ץ����β��ѡ����ɤϼ�ͳ�Ǥ��������ԡ��������Ѥ������ؤ��ޤ���
# 
# Copyright(C) Studio Canbe Corp. All rights reserved.
# Delivered: 2007-11-30
################################################################################################################################################################################


##########    �饤�֥�ꥤ��ݡ���    ##########
# CGI���̥饤�֥��Υ���ݡ���
require			"../cgibin/common/common.pl";

# ���ܸ쥳�����Ѵ��饤�֥��Υ���ݡ���
require			"../cgibin/common/jcode.pl";

# �ե�����������饤�֥��Υ���ݡ���
require			"__form/default.cfg";


##########         �ᥤ�����         ##########
MAIN:{
	foreach $data(&fread($CONFIG{'csv_column_file'}, 0, 1)){
		chomp $data;
		$FORM{$data} = "";
	}
	&decode;

	unless($FORM{'p'}){
		&error_html("���ʤ����ꤵ��Ƥ��ޤ���");
	}

##	�����ǡ�������
	&get_current_times;

##�����������ϥڡ���
	if($FORM{'mode'} eq "" || $FORM{'mode'} eq "input_html"){
##		HTML ���󥳡���
		foreach $key(keys %FORM){
			$FORM{$key} = &html_encode($FORM{$key});
		}

##		���ϥڡ���
		&input_html;
	}
##�����Ƴ�ǧ�ڡ���
	elsif($FORM{'mode'} eq "confirm_html"){
##		���顼�����å�
		$errmsg = &input_check;
		if($errmsg ne ""){
##			HTML ���󥳡���
			foreach $key(keys %FORM){
				$FORM{$key} = &html_encode($FORM{$key});
			}

			&input_html;
		}

##		HTML ���󥳡���
		foreach $key(keys %FORM){
			$FORM{$key} = &html_encode($FORM{$key});
		}

##		���Ƴ�ǧ�ڡ���
		&confirm_html;
	}
##���᡼������, ������λ�ڡ���
	elsif($FORM{'mode'} eq "complete_html"){
##		���顼�����å�
		$errmsg = &input_check;
		if($errmsg ne ""){
			&input_html;
		}

####	CSV����
##		�����ꥹ��
		@column = &fread($CONFIG{'csv_column_file'}, 0, 1);

##		�ե�����̾����
		$CONFIG{'csv_file'} =~ s/YYYY/$FORM{'current_year'}/g;
		$CONFIG{'csv_file'} =~ s/MM/$FORM{'current_mon'}/g;
		$CONFIG{'csv_file'} =~ s/DD/$FORM{'current_day'}/g;

##		��ܥǥ���
		open(FR, $CONFIG{'csv_file'});
		@body = <FR>;
		close(FR);
		$old_body = join("", @body);

##		��ܥǥ������ʤ���硢�إå��������
		if($old_body eq ""){
			@header = &fread($CONFIG{'csv_head_file'}, 0, 1);
			$header = join("", @header);
			$header =~ s/\r\n/\n/g;
			$header =~ s/\r/\n/g;
			$header =~ s/\n/","/g;
			$header =~ s/","$//g;
			$header = "\"$header\"\r\n";
		}

##		�����
		my(@prefectures)	= &fread("__DATABASE/prefectures.dia", 0, 1);
		my(@contact_type)	= &fread("__DATABASE/contact_type.dia", 0, 1);

##		�ɲåܥǥ���
		$add_body = "";
		for(my $i = 0; $i < @column; $i++){
			$column[$i] =~ s/\r\n/\n/g;
			$column[$i] =~ s/\r/\n/g;
			$column[$i] =~ s/\n//g;
			$FORM{$column[$i]} =~ s/"/��/g;

##			͹���ֹ�:����/���֤�̵��
			if($column[$i] eq "zipcode1" || $column[$i] eq "zipcode2"){
				next;
			}
##			�ԣţ�:�Գ�����/�������/�����ֹ��̵��
			if($column[$i] eq "tel1" || $column[$i] eq "tel2" || $column[$i] eq "tel3"){
				next;
			}
##			���䤤��碌����
			elsif($column[$i] eq "contact_type"){
				foreach $data(@contact_type){
					my($code, $name) = split(/<>/, $data);
					if($code eq $FORM{'contact_type'}){
						$add_body .= "\"$name\",";
					}
				}
			}
##			��ƻ�ܸ�
			elsif($column[$i] eq "prefectures"){
				foreach $data(@prefectures){
					my($code, $name) = split(/<>/, $data);
					if($code eq $FORM{'prefectures'}){
						$add_body .= "\"$name\",";
					}
				}
			}
##			�嵭�ʳ�
			else{
				$add_body .= "\"$FORM{$column[$i]}\",";
			}
		}
		$add_body =~ s/,$/\r\n/g;
		&jcode::convert(\$add_body, 'sjis', 'euc');

##		�񤭹���
		&fwrite($CONFIG{'csv_file'}, "$header$old_body$add_body", 0, 0666, 1);

####	�᡼������
##		�᡼�������:�桼������
		if($FORM{'email'} ne ""){
			$mail_body		= &make_mail_body($CONFIG{'body_file_user'});
			$mail_sender	= &base64encode_email($CONFIG{'mail_sender'});
			$from_email		= "\"$mail_sender\" <$CONFIG{'from_email'}>";
			$subject		= &base64encode_email($CONFIG{'subject_user'});
			&sendmail($CONFIG{'error_email'}, $FORM{'email'}, $CONFIG{'cc_email'}, $CONFIG{'bcc_email'}, $from_email, $subject, $mail_body, '', '', '', 0);
		}

##		�᡼�������:�����ȴ����԰�
		$mail_body		= &make_mail_body($CONFIG{'body_file_admin'});
		$mail_sender	= &base64encode_email("$FORM{'name1'} ��");
		$from_email		= "\"$mail_sender\" <$FORM{'email'}>";
		$subject		= &base64encode_email($CONFIG{'subject_admin'});
		&sendmail($CONFIG{'error_email'}, $CONFIG{'to_email'}, $CONFIG{'cc_email'}, $CONFIG{'bcc_email'}, $from_email, $subject, $mail_body, '', '', '', 0);

####	��λ�ڡ���ɽ��
		&location($CONFIG{'complete_html'});
	}
}


################################################################################################################################################################################
##################################################                                SUB ROUTINE                                 ##################################################
################################################################################################################################################################################


##########       �᡼����ʸ����       ##########
sub make_mail_body
{
##������
##	�ƥ�ץ졼�ȥե�����̾
	my($file_name) = @_;

##�������
##	�᡼����ʸ
	my($mail_body);

##���������ѿ�
	my(@data);

##������

##��MAIL�ǡ�������

##	���䤤�礻����
	$MAIL{'contact_type'} = "";
	@data = &fread("__DATABASE/contact_type.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'contact_type'}){
			$MAIL{'contact_type'} = $name;
		}
	}

##	��ƻ�ܸ�
	$MAIL{'prefectures'} = "";
	@data = &fread("__DATABASE/prefectures.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'prefectures'}){
			$MAIL{'prefectures'} = $name;
		}
	}

##���ƥ�ץ졼�ȥե������ɤ߹��ߡ��������ִ�
	$mail_body = join("", &fread($file_name, 0, 1));

##	�ִ�:FORM��
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$mail_body =~ s/<$key>/$FORM{$key}/sg;
	}

##	�ִ�:MAIL��
	foreach $key(sort keys %MAIL){
		$mail_body =~ s/<mail_$key>/$MAIL{$key}/sg;
	}

##	�ִ�:�㳰����

	return($mail_body);
}


##########        ���ϥ����å�        ##########
sub input_check
{
##���������ѿ�
	my($errmsg);
	my(@data);
	my($flag);

##	����̾ (��)
	if($FORM{'p'} eq ""){
		$errmsg .= "������̾�ۤ����򤵤�Ƥ��ޤ���<BR>\n";
	}

##	���䤤�礻���� (��)
	if($FORM{'contact_type'} eq ""){
		$errmsg .= "�ڤ��䤤�礻���ܡۤ����򤵤�Ƥ��ޤ���<BR>\n";
	}
	elsif(&compare_tdb("__DATABASE/contact_type.dia", $FORM{'contact_type'}) == 0){
		$errmsg .= "�ڤ��䤤�礻���� [ $FORM{'contact_type'} ]�ۤ�¸�ߤ��ޤ���<BR>\n";
	}

##	���䤤�礻���� (��)
	if($FORM{'note'} eq ""){
		$errmsg .= "�ڤ��䤤�礻���ơۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'note'}) > 100000){
		$errmsg .= "�ڤ��䤤�礻���ơۤΥХ��ȿ��� [ 100,000 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	����̾:�� (��)
	if($FORM{'name1'} eq ""){
		$errmsg .= "�ڤ���̾:���ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'name1'}) > 20){
		$errmsg .= "�ڤ���̾:���ۤΥХ��ȿ��� [ 20 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	����̾:̾ (��)
	if($FORM{'name2'} eq ""){
		$errmsg .= "�ڤ���̾:̾�ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'name2'}) > 20){
		$errmsg .= "�ڤ���̾:̾�ۤΥХ��ȿ��� [ 20 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�եꥬ��:���� (��)
	if($FORM{'f_name1'} eq ""){
		$errmsg .= "�ڥեꥬ��:�����ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'f_name1'}) > 20){
		$errmsg .= "�ڥեꥬ��:�����ۤΥХ��ȿ��� [ 20 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�եꥬ��:�ᥤ (��)
	if($FORM{'f_name2'} eq ""){
		$errmsg .= "�ڥեꥬ��:�ᥤ�ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'f_name2'}) > 20){
		$errmsg .= "�ڥեꥬ��:�ᥤ�ۤΥХ��ȿ��� [ 20 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	���̾��Ź��̾��
	if(length($FORM{'company'}) > 50){
		$errmsg .= "�ڲ��̾��Ź��̾�ˡۤΥХ��ȿ��� [ 50 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	͹���ֹ�:���� (��)
	$FORM{'zipcode1'} = &zen2han($FORM{'zipcode1'});
	if($FORM{'zipcode1'} eq ""){
		$errmsg .= "��͹���ֹ�:���֡ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif((length $FORM{'zipcode1'} != 3) || ($FORM{'zipcode1'} =~ /[^0-9]/)){
		$errmsg .= "��͹���ֹ�:���֡ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}

##	͹���ֹ�:���� (��)
	$FORM{'zipcode2'} = &zen2han($FORM{'zipcode2'});
	if($FORM{'zipcode2'} eq ""){
		$errmsg .= "��͹���ֹ�:���֡ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif((length $FORM{'zipcode2'} != 4) || ($FORM{'zipcode2'} =~ /[^0-9]/)){
		$errmsg .= "��͹���ֹ�:���֡ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}

##	͹���ֹ�
	$FORM{'zipcode'} = "$FORM{'zipcode1'}-$FORM{'zipcode2'}";

##	��ƻ�ܸ� (��)
	if($FORM{'prefectures'} eq ""){
		$errmsg .= "����ƻ�ܸ��ۤ����򤵤�Ƥ��ޤ���<BR>\n";
	}
	elsif(&compare_tdb("__DATABASE/prefectures.dia", $FORM{'prefectures'}) == 0){
		$errmsg .= "����ƻ�ܸ� [ $FORM{'prefectures'} ]�ۤ�¸�ߤ��ޤ���<BR>\n";
	}

##	�Զ�Į¼ (��)
	if($FORM{'address1'} eq ""){
		$errmsg .= "�ڻԶ�Į¼�ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'address1'}) > 100){
		$errmsg .= "�ڻԶ�Į¼�ۤΥХ��ȿ��� [ 100 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	���� (��)
	if($FORM{'address2'} eq ""){
		$errmsg .= "�����ϡۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'address2'}) > 100){
		$errmsg .= "�����ϡۤΥХ��ȿ��� [ 100 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�ӥ롦�ޥ󥷥��̾
	if(length($FORM{'address3'}) > 100){
		$errmsg .= "�ڥӥ롦�ޥ󥷥��̾�ۤΥХ��ȿ��� [ 100 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�ԣţ�:�Գ����� (��)
	$FORM{'tel1'} = &zen2han($FORM{'tel1'});
	if($FORM{'tel1'} eq ""){
		$errmsg .= "�ڣԣţ�:�Գ����֡ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif($FORM{'tel1'} =~ /[^0-9-]/){
		$errmsg .= "�ڣԣţ�:�Գ����֡ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'tel1'}) > 7){
		$errmsg .= "�ڣԣţ�:�Գ����֡ۤΥХ��ȿ��� [ 7 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�ԣţ�:������� (��)
	$FORM{'tel2'} = &zen2han($FORM{'tel2'});
	if($FORM{'tel2'} eq ""){
		$errmsg .= "�ڣԣţ�:������֡ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif($FORM{'tel2'} =~ /[^0-9-]/){
		$errmsg .= "�ڣԣţ�:������֡ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'tel2'}) > 7){
		$errmsg .= "�ڣԣţ�:������֡ۤΥХ��ȿ��� [ 7 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�ԣţ�:�����ֹ� (��)
	$FORM{'tel3'} = &zen2han($FORM{'tel3'});
	if($FORM{'tel3'} eq ""){
		$errmsg .= "�ڣԣţ�:�����ֹ�ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif($FORM{'tel3'} =~ /[^0-9-]/){
		$errmsg .= "�ڣԣţ�:�����ֹ�ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'tel3'}) > 7){
		$errmsg .= "�ڣԣţ�:�����ֹ�ۤΥХ��ȿ��� [ 7 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	�ԣţ�
	$FORM{'tel'} = "$FORM{'tel1'}-$FORM{'tel2'}-$FORM{'tel3'}";

##	E-mail
	my $mail_regex = '[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*|(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[^()<>@,;:".\\\[\]\x80-\xff\000-\010\012-\037]*(?:(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[^()<>@,;:".\\\[\]\x80-\xff\000-\010\012-\037]*)*<[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*(?:,[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*)*:[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)?(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|"[^\\\x80-\xff\n\015"]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015"]*)*")[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*@[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:\.[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*(?:[^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\x80-\xff\n\015\[\]]|\\[^\x80-\xff])*\])[\040\t]*(?:\([^\\\x80-\xff\n\015()]*(?:(?:\\[^\x80-\xff]|\([^\\\x80-\xff\n\015()]*(?:\\[^\x80-\xff][^\\\x80-\xff\n\015()]*)*\))[^\\\x80-\xff\n\015()]*)*\)[\040\t]*)*)*>)';

##	E-mail (��)
	$FORM{'email'} =~ s/\s//g;
	$FORM{'email'} = &zen2han($FORM{'email'});
	$FORM{'email'} =~ tr/A-Z/a-z/;
	if($FORM{'email'} eq ""){
		$errmsg .= "��E-mail�ۤ����Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif($FORM{'email'} !~ /^$mail_regex$/o){
		$errmsg .= "��E-mail�ۤ����������Ϥ���Ƥ��ޤ���<BR>\n";
	}
	elsif(length($FORM{'email'}) > 250){
		$errmsg .= "��E-mail�ۤΥХ��ȿ��� [ 250 ] ��Ķ���Ƥ��ޤ���<BR>\n";
	}

##	����������IP���ɥ쥹
	$FORM{'remote_addr'} = $ENV{'REMOTE_ADDR'};

	return($errmsg);
}


################################################################################################################################################################################
##################################################                                    HTML                                    ##################################################
################################################################################################################################################################################


##########        �����ϥڡ���        ##########
sub input_html
{
##������
##	�ʤ�

##�������
##	�ʤ�

##���������ѿ�
	my(@data);
	my($output_html);

##������

##��HTML�ǡ�������

##	���䤤�礻����
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

##	��ƻ�ܸ�
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

##���ƥ�ץ졼�ȥե������ɤ߹��ߡ��������ִ�
	$output_html = join("", &fread($CONFIG{'input_html'}, 0, 1));
	&jcode::convert(\$output_html, 'euc');

##	�ִ�:���顼��å�������ACTION°��
	$output_html =~ s/###errmsg###/$errmsg/sg;
	$output_html =~ s/###action###/$ENV{'SCRIPT_NAME'}/sg;

##	�ִ�:FORM��
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$output_html =~ s/###$key###/$FORM{$key}/sg;
	}

##	�ִ�:HTML��
	foreach $key(sort keys %HTML){
		$output_html =~ s/###html_$key###/$HTML{$key}/sg;
	}

##	�ִ�:�㳰����

##���ڡ�������
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


##########       ���Ƴ�ǧ�ڡ���       ##########
sub confirm_html
{
##������
##	�ʤ�

##�������
##	�ʤ�

##���������ѿ�
	my(@data);
	my($output_html);

##������

##��HTML�ǡ�������

##	���䤤�礻����
	$HTML{'contact_type'} = "";
	@data = &fread("__DATABASE/contact_type.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'contact_type'}){
			$HTML{'contact_type'} = $name;
		}
	}

##	��ƻ�ܸ�
	$HTML{'prefectures'} = "";
	@data = &fread("__DATABASE/prefectures.dia", 0, 1);
	foreach $data(@data){
		my($code, $name) = split(/<>/, $data);
		if($code eq $FORM{'prefectures'}){
			$HTML{'prefectures'} = $name;
		}
	}

##	���䤤�礻����
	$HTML{'note'} = &line2br($FORM{'note'});

##���ƥ�ץ졼�ȥե������ɤ߹��ߡ��������ִ�
	$output_html = join("", &fread($CONFIG{'confirm_html'}, 0, 1));
	&jcode::convert(\$output_html, 'euc');

##	�ִ�:ACTION°��
	$output_html =~ s/###action###/$ENV{'SCRIPT_NAME'}/sg;

##	�ִ�:FORM��
	foreach $key(sort keys %FORM){
		if($key =~ /^mode$/){
			next;
		}
		$output_html =~ s/###$key###/$FORM{$key}/sg;
	}

##	�ִ�:HTML��
	foreach $key(sort keys %HTML){
		$output_html =~ s/###html_$key###/$HTML{$key}/sg;
	}

##	�ִ�:�㳰����

##���ڡ�������
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


##########        ���顼�ڡ���        ##########
sub error_html
{
##������
##	���顼��å�����
	my($errmsg) = @_;

##�������
##	�ʤ�

##���������ѿ�
	my($output_html);

##������

##��HTML�ǡ�������

##���ڡ�������
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