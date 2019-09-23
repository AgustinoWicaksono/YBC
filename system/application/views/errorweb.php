<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));


// Function to get the client ip address
function get_webclient_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}


$webip = get_webclient_ip();
if ($webip!='UNKNOWN')
	$webhost = @gethostbyaddr($webip);
if (Empty($webhost )) {
	$webhost = '';
} else {
	if ($webip!=$webhost)
		$webip = $webip." (".$webhost.")";
}
// print_r($this->session);
?>
<div style="padding:17px;">

<div style="float:left;margin-right:10px;">
<img src="<?php echo base_url();?>images/error.png" alt="Error" border="0" />
</div>
<div style="display:block;float:left;"><h1>TRANSAKSI ERROR</h1>
Terdapat kesalahan saat transaksi.<br /><br />
<em style="color:#C53508;font-size:90%;">Jika Anda tidak dapat mengatasi error ini, silahkan klik tombol <b>&quot;Lapor Error ke SX&quot;</b> atau klik <b><a href="<?php echo site_url($refresh_url); ?>" title="Lanjut">di sini</a></b> untuk melanjutkan transaksi berikutnya.</em><br />&nbsp;
<?php

echo form_open('mail/sendmail');
?>

<?php 
	// echo $this->lang->line('error');
	$error_time = date('Y-m-d H:i:s');
	$error_timestamp = date('Ymd.His');
	$error_checksum = md5('JAGIT77'.$this->session->userdata['ADMIN']['admin_username'].$error_time.$this->session->userdata['ADMIN']['plant']);
	if (Empty($jag_module['web_module'])) $jag_module['web_module'] = 'system';
	$jag_module['web_module'] = strtoupper($jag_module['web_module']);
	if (Empty($jag_module['web_trans'])) $jag_module['web_trans'] = 'system';
	$jag_module['web_trans'] = ucwords($jag_module['web_trans']);
	
	if (Empty($error_code)) $error_code = $jag_module['module_code'].'x0'; else $error_code = $jag_module['module_code'].'x'.$error_code;
	
	$jag_module['web_transdtl'] = $web_transdtl;
	if (Empty($jag_module['web_transdtl'])) $jag_module['web_transdtl'] = '';

	$error_text = $refresh_text;
	$error_text = str_ireplace("<br>","\n",$error_text);
	$error_text = str_ireplace("<br/>","\n",$error_text);
	$error_text = str_ireplace("<br />","\n",$error_text);
	while (strpos($error_text,"  ")>0) {
		$error_text = str_ireplace("  "," ",$error_text);
	}
	$errarray= explode("\n", trim($error_text));
	for($i=0;$i<count($errarray);$i++){
		$errarray[$i] = trim($errarray[$i]);
	}
	$error_text = implode("\n",$errarray);
	$error_text = trim(strip_tags($error_text));
	
	$error_row = count($errarray);
	if ($error_row>17) $error_row=17;
	$error_row=$error_row+3;
?>	
<div style="float:right;">
<?php
	echo form_submit($this->config->item('button_sendhelpsx'), 'Lapor ke SX Helpdesk');
?>
</div>
<br />
<a href="#" onClick="history.go(-1);return true;"><img src="<?php echo base_url();?>images/jbtnback2.png" alt="Back" title="Back" border="0" /></a>

<?php	
//print_r($this->session->userdata['ADMIN']);
	echo form_hidden('mail_type', $jag_module['web_module']);
	echo form_hidden('mail_trans', $jag_module['web_trans']);
	echo form_hidden('mail_errorcode', $error_code);
	echo form_hidden('mail_transdtl', $jag_module['web_transdtl']);
	echo form_hidden('mail_time', $error_time);
	echo form_hidden('mail_timestamp', $error_timestamp);
	echo form_hidden('mail_checksum', $error_checksum);
	echo form_hidden('mail_user', $this->session->userdata['ADMIN']['admin_username']);
	echo form_hidden('mail_outlet', $this->session->userdata['ADMIN']['plant']);
	echo form_hidden('mail_redirect', $refresh_url);
	
	$error_text;
	$mail_error = 'Error Code: '.$error_code."<br />";
	$mail_error .= 'Module: '. $jag_module['web_module']."<br />";
	$mail_error .= 'Transaction: '. $jag_module['web_trans']."<br />";
	if ($jag_module['web_transdtl']!='')  $mail_error .= 'Detail: '.$jag_module['web_transdtl']."<br />";
	$mail_error .= 'Time: '. $error_time."<br />";
	$mail_error .= 'User: '. $this->session->userdata['ADMIN']['admin_username']."<br />";
	$mail_error .= 'Outlet: '. $this->session->userdata['ADMIN']['plant'].' / '.$this->session->userdata['ADMIN']['hr_plant_code']."<br />";
	$mail_error .= 'Loc: '. $webip."<br />";
	$mail_error .= 'Checksum: '. $error_checksum;
	echo form_hidden('mail_error', $mail_error);
	
	?>
	<br />
	<textarea name="error_text" id="error_text" rows="<?php echo $error_row; ?>" cols="110"  class="error_text" readonly="readonly" style="padding:10px;"><?php echo $error_text; ?></textarea>
	<?php /* <div style="font-size:80%;color:#353535;color:#aa1122;text-align:right;font-style:italic;"> 
	<?php echo $mail_error; ?>
	</div>
	*/ ?>
	
	</div><div style="clear:both;"></div><br />
<?php
echo form_close();

//	echo sprintf($this->lang->line('redirect_no_refresh_text'), site_url($refresh_url));
?>
</div>