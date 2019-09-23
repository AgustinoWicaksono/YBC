<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));
if ($this->session->userdata['ADMIN']['plant_type_id']=="BID") $supmail = "sap.helpdesk@ybc.co.id";
	else $supmail = "sap.helpdesk@jcodonuts.com";
?>
<div style="padding:17px;">

<div style="float:left;margin-right:10px;">
<img src="<?=base_url();?>images/error.png" alt="Error" border="0" />
</div>
<div style="display:block;float:left;"><h1>TRANSAKSI ERROR</h1>
Terdapat kesalahan saat transaksi.<br /><br />
<em style="color:#aa1122;">Silahkan kirim error berikut ke <b style="color:#567;"><?php echo $supmail; ?></b>.
<br />Anda tidak perlu melakukan <b>print screen</b> atau kirim gambar karena akan <u>membebani email Anda</u>. 
Cukup kirimkan teks di bawah ini, caranya:
<ul><li>Klik kanan teks dalam kotak di bawah ini, lalu pilih &quot;Select All&quot;</li>
<li>Klik kanan lagi di area teks di bawah, lalu pilih &quot;Copy&quot;</li>
<li>Masuk ke aplikasi email Anda (Outlook / Thunderbird), lalu &quot;Paste&quot;</li>
</ul></em>

<?php 
	// echo $this->lang->line('error');
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
	$error_row=$error_row+1;
	
	?>
	<textarea name="error_text" id="error_text" rows="<?php echo $error_row; ?>" cols="100"  class="error_text" readonly="readonly" style="padding:10px;"><?php echo $error_text; ?></textarea>
	
	</div><div style="clear:both;"></div><br />
<?php
if($refresh == 1)
	echo sprintf($this->lang->line('redirect_refresh_text'), $refresh_time, site_url($refresh_url));
else
	echo sprintf($this->lang->line('redirect_no_refresh_text'), site_url($refresh_url));
?>
</div>