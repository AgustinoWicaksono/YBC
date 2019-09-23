<div style="display:block;width:350px;float:right;margin:10px;">
<?php 
$jagonduty_pic="";
$jagonduty_tel="";
$jagonduty_mail="";

$jaglead_pic="";
$jaglead_tel="";
$jaglead_mail="";


$nama[1]="Data Goods Receipts from Vendor (Terima Barang Vendor/Supplier)";
$nama[2]="Data Goods Receipt From CK";
$nama[3]="Data Stock Opname";
$nama[4]="Data Goods Issue Stock Transfer Antar Plant";
$nama[5]="Data Goods Receipt Stock Transfer Antar Plant";
$nama[6]="Data Waste material";
$nama[7]="Data Goods Receipt Non PO";
$nama[8]="Data Request for Non Standard Stock";
$nama[9]="Data Store Room Request";
$nama[10]="Data GR FG Outlet";
$nama[11]="Data Transfer Selisih Stock ke CK";
$nama[12]="Data Trend Utility (Usage)";
$nama[13]="Data Productivity Staff";
$nama[14]="Data Goods Issue To Cost Center";
$nama[15]="Data End of Day";
$nama[17]="Data Retur Out";
$nama[18]="Data Retur In";
$nama[19]="Data Good Issues";
$nama[20]="Data Produksi";
$nama[21]="Data Purchase Request (PR)";
$nama[16]="Data Transfer Out Inter Outlet";
$nama[22]="Data Opname";
//$nama[17]="Data Transfer Selisih Stock Transfer Antar Departement";
//$nama[18]="Data Goods Isuue Stock Transfer Antar Departement";


$data[1]=''.$data['grpo_count_unapproved'];
$data[2]=''.$data['grpodlv_count_unapproved'];
$data[3]=''.$data['stockoutlet_count_unapproved'];
$data[4]=''.$data['gisto_count_unapproved'];
$data[5]=''.$data['grsto_count_unapproved'];
$data[6]=''.$data['waste_count_unapproved'];
$data[7]=''.$data['grnonpo_count_unapproved'];
$data[8]=''.$data['nonstdstock_count_unapproved'];
$data[9]=''.$data['stdstock_count_unapproved'];
$data[10]=''.$data['grfg_count_unapproved'];
$data[11]=''.$data['tssck_count_unapproved'];
$data[12]=''.$data['trend_utility_count_unapproved'];
$data[13]=''.$data['prodstaff_count_unapproved'];
$data[14]=''.$data['gitcc_count_unapproved'];
$data[15]=''.$data['posinc_count_unapproved'];
//$data[16]=''.$data['grpodlv_dept_count_unapproved'];
$data[16]=''.$data['gistonew_out_count_unapproved'];
$data[17]=''.$data['gisto_dept_count_unapproved'];
$data[18]=''.$data['retin_count_unapproved'];
$data[19]=''.$data['issue_count_unapproved'];
$data[20]=''.$data['produksi_count_unapproved'];
$data[21]=''.$data['pr_count_unapproved'];
$data[22]=''.$data['opname_count_unapproved'];


$link1[1]=''.$link['grpo_count_unapproved'];
$link1[2]=''.$link['grpodlv_count_unapproved'];
$link1[3]=''.$link['stockoutlet_count_unapproved'];
$link1[4]=''.$link['gisto_count_unapproved'];
$link1[5]=''.$link['grsto_count_unapproved'];
$link1[6]=''.$link['waste_count_unapproved'];
$link1[7]=''.$link['grnonpo_count_unapproved'];
$link1[8]=''.$link['nonstdstock_count_unapproved'];
$link1[9]=''.$link['stdstock_count_unapproved'];
$link1[10]=''.$link['grfg_count_unapproved'];
$link1[11]=''.$link['tssck_count_unapproved'];
$link1[12]=''.$link['trend_utility_count_unapproved'];
$link1[13]=''.$link['prodstaff_count_unapproved'];
$link1[14]=''.$link['gitcc_count_unapproved'];
$link1[15]=''.$link['posinc_count_unapproved'];
//$link1[16]=''.$link['grpodlv_dept_count_unapproved'];
$link1[16]=''.$link['gistonew_out_count_unapproved'];
$link1[17]=''.$link['gisto_dept_count_unapproved'];
$link1[18]=''.$link['retin_count_unapproved'];
$link1[19]=''.$link['issue_count_unapproved'];
$link1[20]=''.$link['produksi_count_unapproved'];
$link1[21]=''.$link['pr_count_unapproved'];
$link1[22]=''.$link['opname_count_unapproved'];

/*
$data1[1]=$data['grpo_count'];
$data1[2]=$data['grpodlv_count'];
$data1[3]=$data['stockoutlet_count'];
$data1[4]=$data['gisto_count'];
$data1[5]=$data['grsto_count'];
$data1[6]=$data['waste_count'];
$data1[7]=$data['grnonpo_count'];
$data1[8]=$data['nonstdstock_count'];
$data1[9]=$data['stdstock_count'];
$data1[10]=$data['grfg_count'];
$data1[11]=$data['tssck_count'];
$data1[12]=$data['trend_utility_count'];
$data1[13]=$data['prodstaff_count'];
$data1[14]=$data['gitcc_count'];
$data1[15]=$data['posinc_count'];
*/

$nama[101]="PO from Vendor";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[101]=''.$data['po_count_outstanding'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[101]=''.$link['po_count_outstanding'];
//$link1[102]=''.$link['posto_count_outstanding'];
$nama[102]="GR PO Antar Departement";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[102]=''.$data['grpodlv_dept_count'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[102]=''.$link['grpodlv_dept_count'];

$nama[103]="Good Receipt From CK";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[103]=''.$data['grpodlv_count'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[103]=''.$link['grpodlv_count'];

$nama[104]="Good Issue Stock Transfer Antar Outlet";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[104]=''.$data['gistonew_out_count'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[104]=''.$link['gistonew_out_count'];


$nama[105]="Error Log Manajemen";
$data[105]=''.$data['error_log'];
$link1[105]=''.$link['error_log'];

$nama[106]="Item Agging";
$data[106]=''.$data['item_agging'];
$link1[106]=''.$link['item_agging'];

$nama[107]="Good Receipt From Outlet";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[107]=''.$data['grsto_count'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[107]=''.$link['grsto_count'];

$nama[108]="Retur In";
//$nama[102]="DO from CK (PO STO with Delivery)";
$data[108]=''.$data['retin_count'];
//$data[102]=''.$data['posto_count_outstanding'];
$link1[108]=''.$link['retin_count'];

$nama[109]="List of PO Outstanding";
$data[109]=''.$data['poouts'];
$link1[109]=''.$link['poouts'];



$nama[1001]="Data Goods Receipts from Vendor (Terima Barang Vendor/Supplier)";
$data[1001]=''.$data['grpo_count_sap'];
$link1[1001]=''.$link['grpo_count_sap'];
$nama[1002]="Data Goods Receipt From CK";
$data[1002]=''.$data['grpodlv_count_sap'];
$link1[1002]=''.$link['grpodlv_count_sap'];
$nama[1003]="Data Stock Opname";
$data[1003]=''.$data['stockoutlet_count_sap'];
$link1[1003]=''.$link['stockoutlet_count_sap'];
$nama[1004]="Data Goods Issue Stock Transfer Antar Plant";
$data[1004]=''.$data['gisto_count_sap'];
$link1[1004]=''.$link['gisto_count_sap'];
$nama[1005]="Data Goods Receipt Stock Transfer Antar Plant";
$data[1005]=''.$data['grsto_count_sap'];
$link1[1005]=''.$link['grsto_count_sap'];
$nama[1006]="Data Waste material";
$data[1006]=''.$data['waste_count_sap'];
$link1[1006]=''.$link['waste_count_sap'];
$nama[1007]="Data Goods Receipt Non PO";
$data[1007]=''.$data['grnonpo_count_sap'];
$link1[1007]=''.$link['grnonpo_count_sap'];
$nama[1008]="Data Request for Non Standard Stock";
$data[1008]=''.$data['nonstdstock_count_sap'];
$link1[1008]=''.$link['nonstdstock_count_sap'];
$nama[1009]="Data Store Room Request";
$data[1009]=''.$data['stdstock_count_sap'];
$link1[1009]=''.$link['stdstock_count_sap'];
$nama[1010]="Data GR FG Outlet";
$data[1010]=''.$data['grfg_count_sap'];
$link1[1010]=''.$link['grfg_count_sap'];
$nama[1011]="Data Transfer Selisih Stock ke CK";
$data[1011]=''.$data['tssck_count_sap'];
$link1[1011]=''.$link['tssck_count_sap'];
$nama[1012]="Data Trend Utility (Usage)";
$data[1012]=''.$data['trend_utility_count_sap'];
$link1[1012]=''.$link['trend_utility_count_sap'];
$nama[1013]="Data Productivity Staff";
$data[1013]=''.$data['prodstaff_count_sap'];
$link1[1013]=''.$link['prodstaff_count_sap'];
$nama[1014]="Data Goods Issue To Cost Center";
$data[1014]=''.$data['gitcc_count_sap'];
$link1[1014]=''.$link['gitcc_count_sap'];
$nama[1015]="Data End of Day";
$data[1015]=''.$data['posinc_count_sap'];
$link1[1015]=''.$link['posinc_count_sap'];
$nama[1016]="Data Transfer Out Inter Outlet";
$data[1016]=''.$data['gistonew_out_count_sap'];
$link1[1016]=''.$link['gistonew_out_count_sap'];
//$data[1016]=''.$data['grpodlv_dept_count_sap'];
$nama[1017]="Data Retur Out";
$data[1017]=''.$data['gisto_dept_count_sap'];
$link1[1017]=''.$link['gisto_dept_count_sap'];
$nama[1018]="Data Retur In";
$data[1018]=''.$data['retin_count_sap'];
$link1[1018]=''.$link['retin_count_sap'];
$nama[1019]="Data Good Issues";
$data[1019]=''.$data['issue_count_sap'];
$link1[1019]=''.$link['issue_count_sap'];
$nama[1020]="Data Produksi";
$data[1020]=''.$data['produksi_count_sap'];
$link1[1020]=''.$link['produksi_count_sap'];
$nama[1021]="Data Purchase Request (PR)";
$data[1021]=''.$data['pr_count_sap'];
$link1[1021]=''.$link['pr_count_sap'];
$nama[1022]="Data Opname";
$data[1022]=''.$data['produksi_count_sap'];
$link1[1022]=''.$link['opname_count_sap'];


$tglterkini = date("j M Y",strtotime($this->m_general->posting_date_select_max()));

$jagalert=false;
for($i=0; $i<=25; $i++){
   if($data[$i] > 0) { $jagalert=true;break; }
}

$jagwarning=false;
for($i=101; $i<=111; $i++){
   if($data[$i] > 0) { $jagwarning=true;break; }
}

$jagadanger=false;
for($i=1001; $i<=1025; $i++){
   if($data[$i] > 0) { $jagadanger=true;break; }
}


   
if ($jagalert) {
?>

<table class="swbbodyb" cellpadding="0" cellspacing="0" width="350" border="0" style="background-color:#f2dddc;">
<tr>
<td width="100"></td>
<td width="220"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#8e3b39;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
<?php echo $tglterkini; ?>
</td>
<td style="color:#ffffff;background-color:#c0504d;color:#fdd250;padding:3px;font-size:14px;" colspan="2"><b style="color:#ffffff;">PENTING:</b><br />Harap Segera Setujui!</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Belum Disetujui</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Jumlah</td>
</tr>

<?php 
for($i=0; $i<=25; $i++){
   if($data[$i] > 0){
echo '<tr>';
echo '<td style="padding:5px;border-bottom:#8e3b39 1px solid;" colspan="2">'.anchor($link1[$i],"&raquo; ".$nama[$i]).'</td>';
echo '<td style="padding:5px;border-bottom:#8e3b39 1px solid;text-align:center;">'.$data[$i].'</td>';
echo '</tr>';

   }
 } 
?>
</table>
<br /><br />
<?php
}

if ($jagadanger) {
?>

<table class="swbbodyb" cellpadding="0" cellspacing="0" width="350" border="0" style="background-color:#f2dddc;">
<tr>
<td width="100"></td>
<td width="220"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#800080;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
<?php echo $tglterkini; ?>
</td>
<td style="color:#ffffff;background-color:#663399;color:#fdd250;padding:3px;font-size:14px;" colspan="2"><b style="color:#ffffff;">PENTING:</b><br />Kesalahan Data!</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Harap Diperbaiki</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Jumlah</td>
</tr>

<?php 
for($i=1001; $i<=1025; $i++){
   if($data[$i] > 0){
echo '<tr>';
echo '<td style="padding:5px;border-bottom:#8e3b39 1px solid;" colspan="2">'.anchor($link1[$i],"&raquo; ".$nama[$i]).'</td>';
echo '<td style="padding:5px;border-bottom:#8e3b39 1px solid;text-align:center;">'.$data[$i].'</td>';
echo '</tr>';

   }
 } 
?>
</table>
<br /><br />
<?php
}

if ($jagwarning) {
?>

<table class="swbbodyb" cellpadding="0" cellspacing="0" width="350" border="0" style="background-color:#fde9d9;">
<tr>
<td width="100"></td>
<td width="220"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#e36300;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
<?php echo $tglterkini; ?>
</td>
<td style="color:#ffffff;background-color:#f79646;color:#121212;padding:3px;font-size:14px;" colspan="2"><b style="color:#ffffff;">PERHATIAN:</b><br />Harap Segera Tindak Lanjuti!</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Data Baru</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Jumlah</td>
</tr>

<?php 
for($i=101; $i<=111; $i++){
   if($data[$i] > 0){
echo '<tr>';
echo '<td style="padding:5px;border-bottom:#e36300 1px solid;" colspan="2">'.anchor($link1[$i],"&raquo; ".$nama[$i]).'</td>';
echo '<td style="padding:5px;border-bottom:#e36300 1px solid;text-align:center;">'.$data[$i].'</td>';
echo '</tr>';

   }
 } 
?>
</table><br />


<?php
}


?>

<div style="display:block;margin-top:7px;width:350px;background-color:#AAA690;padding:0px;padding-bottom:2px;">
<div style="background-color:#DEDEDE;padding:3px;padding-bottom:0px;">
	<div style="padding-left:14px;"><img src="<?php echo base_url();?>images/helpus.png" alt="Corporate Helpdesk" title="Corporate Helpdesk" align="left" style="float:left;margin:0px 3px 0px 0px;" />
	<h2 style="color:#d80015;border-bottom:#d80015 1px solid;margin-bottom:-7px;"><span style="font-weight:normal;">EMAIL</span> PENGADUAN / RF:</h2>
	</div>
	<br />
	<ul>
	<li>HEAD OFFICE: <blink><b style="color:#aa1122;">New!</b></blink><br /><b style="color:#223344;">support@ybc.co.id</b><br />&nbsp;</li>

	<li>IT: <br /><b style="color:#223344;">it.helpdesk@ybc.co.id</b><br />&nbsp;</li>
	</ul>
</div>
</div>

</div>

<div style="padding:1.7em;font-size:120%;font-family:Lucida Grande,Lucida Sans Unicode, sans-serif;letter-spacing:1px;line-height:22px;">
	<h2 style="font-size:170%;font-weight:normal;">Pengumuman</h2>
	Cabang: <b><?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></b>
	<br /><br />
	<?php 

$swbipaddress=@$_SERVER['REMOTE_ADDR'];


		include_once(APPPATH."views/currannounce.php");
		if (Empty($swbcurrprocess)) $swbcurrprocess = "";
		
		if ($swbcurrprocess!="") { 
			echo 'Tanggal: '. $swbann_datetime; 
			echo '<br />';
			echo '<b>'.$swbann_subj.'</b>: '.$swbann_msg;
			echo '<br /><br />';
		
		}
		
		$stat_web_sap=$this->m_home->home_web_sap();
		$stat_web_hr=$this->m_home->home_web_hr();
		$stat_transight=$this->m_home->home_transight();
	?>
	<div style="font-size:90%;letter-spacing:0px;line-height:20px;">
	<h4>Status Data Terkini</h4><hr /><ul>
	<li>End of Day SAP: <?php echo $stat_web_sap; ?> </li>
	<li>Transight POS:  <?php echo $stat_transight; ?></li>
	<li>Fingerprint: <?php echo $stat_web_hr; ?> </li>
	</ul><br />


	</div>
</div>
