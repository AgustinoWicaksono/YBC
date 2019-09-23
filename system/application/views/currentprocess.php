<?php
include_once(APPPATH."views/currproc.php");
if (Empty($swbcurrprocess)) $swbcurrprocess = "";
if ($swbcurrprocess == "") include_once(APPPATH."views/currannounce.php");
if (Empty($swbcurrprocess)) $swbcurrprocess = "";

if ($swbcurrprocess=="sync"){ 
	$swbann_pic="load.gif";
	$swbann_subj="PROSES SINKRONISASI MATERIAL";
	$swbann_msg="Sedang proses sinkronisasi material. Beberapa material mungkin tidak muncul saat Anda melakukan transaksi. Silahkan tunggu beberapa saat dan refresh browser Anda untuk menampilkan material setelah proses ini selesai. Proses sekitar 25 menit sejak waktu mulai.";
	
} elseif ($swbcurrprocess=="synchr"){ 
	$swbann_pic="load.gif";
	$swbann_subj="PROSES SINKRONISASI HR";
	$swbann_msg="Sedang proses sinkronisasi sistem HR Payroll. Beberapa data karyawan mungkin tidak muncul saat Anda melakukan transaksi. Silahkan tunggu beberapa saat dan refresh browser Anda untuk menampilkan data karyawan terkini setelah proses ini selesai. Proses sekitar 5 jam sejak waktu mulai.";
	
} elseif ($swbcurrprocess!="") { 
	$swbann_pic="announce.png";
	if (Empty($swbann_subj)) $swbann_subj="";
	if (Empty($swbann_msg)) $swbann_msg="";
} 

if (Empty($swbann_datetime)) $swbann_datetime= date('j M y - H:i')." WIB";
if (Empty($swbann_msg)) $swbcurrprocess = "";
if (Empty($swbann_endtime)) $swbann_endtime = "";
elseif ($swbann_msg=="") $swbcurrprocess = "";

if ($swbcurrprocess != "") {
?>
<div style="background-color:#fde18c;color:#353535;padding:0px;border-right:#aa1122 77px solid;border-bottom:#fd9e50 2px solid;">
<div style="padding:5px;float:left;margin:0px 5px 0px 0px;"><img src="<?php echo base_url();?>images/<?php echo $swbann_pic; ?>" alt="YBC SAP Portal Info" title="YBC SAP Portal Info" /></div>
<div style="margin-left:50px;padding:3px;">
<h2 style="font-size:12px;font-style:italic;"><span style="font-weight:normal;">[<?php echo $swbann_datetime; ?>]: </span><span style="font-size:120%;"><?php echo $swbann_subj;?></span></h2>
<div>
<?php echo $swbann_msg; ?>
<?php if ($swbann_endtime!="") echo '<br /><i style="color:#aa1122;">Perkiraan waktu selesai: <b>'.@$swbann_endtime.'</b></i>'; ?>
</div>
</div>
<div style="clear:both;"></div>
</div>
<?php } ?>
