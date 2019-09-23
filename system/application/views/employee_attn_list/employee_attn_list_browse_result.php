<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Attendance List: <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> (<?=$date_from;?> to <?=$date_to;?>)</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Start of menu and main CSS //-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/main.css?v=2" />

<style type="text/css" title="currentStyle">
<?php /*	@import "<?=base_url();?>css/demo_page.css"; */ ?>
	@import "<?=base_url();?>css/jquery.dataTables_themeroller.css";
	@import "<?=base_url();?>css/ui-lightness/jquery-ui-1.8.4.custom.css";
	@import "<?=base_url();?>css/TableTools.css";
</style>
<script type="text/javascript" language="javascript" src="<?=base_url();?>js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?=base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="<?=base_url();?>js/TableTools.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
	$('#JAGTable tr').click( function() {
		$(this).toggleClass('row_selected');
	} );
    var oTable = $('#JAGTable').dataTable( {
		"aaSorting": [[1,'asc']],
		"bJQueryUI": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "sScrollY": "350px",
		  "sScrollX": "100%",
		  "sScrollXInner": "<?php echo (200+(10*$days_interval));?>%",
		  "bScrollCollapse": true,
			"sDom": '<"H"Tfr>t<"F"ip>',
			"oTableTools": {
				"sSwfPath": "<?=base_url();?>js/swf/copy_csv_xls_pdf.swf",
				"aButtons": [
				"copy",
				"csv",
				"xls",
				{
					"sExtends": "pdf",
					"sPdfOrientation": "landscape",
					"sPdfMessage": "Tgl cetak: <?php echo date('Ymd-His'); ?> oleh: <?php echo $this->session->userdata['ADMIN']['admin_username']; ?>"
				},
				"print"
				]
			}

    } );
} );
</script>

</head>
<body>
<div align="center" class="page_title"><?=$page_title;?></div>
<p></p>
<div style="font-size:90%;float:right;margin:10px;padding:10px;border:#DEDEDE 1px solid;">
Keterangan:<br />
<p><span style="background-color:#AA1122;color:#FDD250;padding:2px;">NO SHIFT</span> &nbsp;: Belum ada shift</p>
<p><span style="background-color:#FFF;color:#575757;padding:2px;border:#DEDEDE 1px solid;">NO DATA</span> &nbsp;: Belum ada data</p>
<em>Data shift yang di-input hari ini, akan tampil besok</em>
</div>
<table>
	<tr>
		<td width="200"><b>Cabang:</b></td>
		<td><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
  <tr>
    <td><strong>Tanggal:</strong></td>
		<td>Dari <?=$date_from;?> s/d <?=$date_to;?></td>
	</tr>
  <tr>
    <td><strong>Waktu Pembaruan Data:</strong></td>
		<td style="color:#AA1122;"><?=$absen_data_last_updated;?></td>
	</tr>
</table>
<p></p>
<?php

if($data['employee'] !== FALSE) {
	$i = 1;
	$data_kd_aktual = Array();
	foreach ($data['employee'] as $employee){
		if (!Empty($employee['kd_aktual']))
		$data_kd_aktual=array_merge($data_kd_aktual,$employee['kd_aktual']);
	
	}
	ksort($data_kd_aktual);
}
?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="JAGTable" width="100%">
<thead>
	<tr>
<?php /*		<th>Cabang</th> */ ?>
		<th>NIK</th>
		<th>Nama Karyawan</th>
		<th>Divisi</th>
		<th>Department</th>
		<th>Bagian</th>
		<th>Jabatan</th>
		<th>Golongan</th>
		<th>Level</th>
<?php
$date_current = $timestamp['from'];

for($j = 1; $j <= $days_interval; $j++) :
?>
		<th><?=date("d-m-Y", $date_current);?></th>
<?php
	$date_current = $date_current + 86400;
endfor;
?>
<?php
	foreach ($data_kd_aktual as $key=>$value){
		echo '<th>'.$key.'</th>';
	}
//		<th>Total Per Izin/Cuti</th>
?>
		<th>Total All</th>
		<th>Keterangan</th>
  </tr>
</thead>
<tbody>
<?php
if($data['employee'] !== FALSE) :
	$i = 1;
	
	
	foreach ($data['employee'] as $employee):
	
	
	
?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
<?php /*		<td><?=$employee['kode_cabang'];?></td> */ ?>
		<td><?=$employee['nik'];?></td>
		<td><?=$employee['nama'];?></td>
		<td><?=$employee['divisi'];?></td>
		<td><?=$employee['department'];?></td>
		<td><?=$employee['bagian'];?></td>
		<td><?=$employee['jabatan'];?></td>
		<td><?=$employee['golongan'];?></td>
		<td><?=$employee['level'];?></td>
<?php
/*
		for($j = 1; $j <= $days_interval; $j++) :
?>
		<td><?=$employee['attn'][$attn['tanggal']];?></td>
<?php
		endfor;
*/
		$date_current = $timestamp['from'];
		for($j = 1; $j <= $days_interval; $j++) :
			$attn_tanggal = date("Y-m-d", $date_current);
			
			$gradeClass=$this->m_employee->employee_UI_kodeabsen($employee['attn'][$attn_tanggal]);
			if ($employee['lock'][$attn_tanggal]==1) $classLock = ' lock'; else $classLock = '';
			if ($employee['attn'][$attn_tanggal]=='NO SHIFT') { $gradeClass='grdF'; $employee['attn'][$attn_tanggal]= '<em>'.$employee['attn'][$attn_tanggal].'</em>'; }
			if (trim($employee['attn'][$attn_tanggal])=='') { $employee['attn'][$attn_tanggal] = '<em>NO DATA</em>'; }
?>
				<td class="grd <?=$gradeClass.$classLock;?>"><?=$employee['attn'][$attn_tanggal];?></td>
<?php
			$date_current = $date_current + 86400;
		endfor;
		unset($kd_aktual_empl);
		$kd_aktual_empl=Array();
		foreach ($data_kd_aktual as $key=>$value){
			$kd_aktual_empl[$key]=0;
		}		


		if($employee['kd_aktual'] != FALSE) {
			foreach($employee['kd_aktual'] as $key => $value) {
				$kd_aktual_empl[$key]=$value;
			}
		}
		
		foreach ($data_kd_aktual as $key=>$value){
			echo '<td align="center">'.$kd_aktual_empl[$key].'</td>';
		}		
		

/*		<td class="hrfkecil"><table cellpadding="0" cellspacing="0" border="0" align="left"><tr><?=$kd_aktual_partH;?></tr><tr><?=$kd_aktual_part;?></tr></table></td> */
?>
		<td align="center"><?=$employee['kd_aktual_total'];?></td>
		<td>&nbsp;</td>
  </tr>
<?php
		$i++;
	endforeach;
endif;
?>
</tbody>
</table>

</body>
