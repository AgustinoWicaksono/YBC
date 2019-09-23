<?php
ob_start();
?>
Harap tunggu sebentar, sedang update PO...

<?php
ob_flush();

$kd_plant = $this->session->userdata['ADMIN']['plant'];
if ((!Empty($kd_plant)) && (trim($kd_plant)!="")) {
	$dirsap = "/var/www/html/pos.ybc.co.id/saprfc/";
	include("../../../pooutstanding.php");	
}

// $this->lang->load('g_general', $this->session->userdata('lang_name'));
?>
<center>
<div style="display:block;width:70%;background-color:#eaac98;padding:10px;border:#aa1122 5px solid;">

Data PO telah berhasil diperbarui. Beberapa saat lagi otomatis kembali ke halaman dengan data PO yang sudah diperbarui.
</div>
</center>
<?php
ob_flush();
$myrootDomain = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '').'://'.$_SERVER['HTTP_HOST'].str_replace('//','/',dirname($_SERVER['SCRIPT_NAME']).'/');

$alamatPO = $myrootDomain."grpo/input";
ob_end_flush();
header('Location: '.$alamatPO);


?>