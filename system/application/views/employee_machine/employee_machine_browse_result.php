<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
// print_r($this->session->userdata['ADMIN']);
$hr_code=$this->session->userdata['ADMIN']['hr_plant_code'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Data Mesin Absen: <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> (<?=$date_from;?> to <?=$date_to;?>)</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Start of menu and main CSS //-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/main.css" />

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
		"aaSorting": [[1,'asc'],[2,'asc'],[3,'asc']],
		"bJQueryUI": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "sScrollY": "350px",
		  "sScrollX": "100%",
		  "sScrollXInner": "100%",
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
<p>Keterangan <b>Status Mesin</b>:<br />
<span class="grdA">&nbsp;IN&nbsp;</span> &nbsp;: Absen kondisi IN</br>
<span class="grdE">&nbsp;OUT&nbsp;</span> &nbsp;: Absen kondisi OUT</p>

<p>Keterangan <b>Status Proses</b>:<br />
<span class="grdA">&nbsp;OK&nbsp;</span> &nbsp;: Sudah diproses</br>
<span class="grdC">&nbsp;WAITING&nbsp;</span> &nbsp;: Proses data menunggu sinkron berikutnya<br />
<span class="grdF">&nbsp;NOT OK&nbsp;</span> &nbsp;: Finger ID belum terdaftar di Web HR</p>

</div>
<table>
	<tr>
		<td width="200"><b>Cabang</b></td>
		<td><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
	<tr>
		<td><b>Divisi</b></td>
		<td><?php
		if (trim($data['divisi'])=='ALL') echo '<b>ALL</b>'; else echo $data['divisi'];?></td>
	</tr>
	<tr>
		<td><b>Nama Karyawan</b></td>
		<td><?php
		if (trim($data['employee']['nama'])=='') echo '<b>ALL</b>'; else echo $data['employee']['nama'];?></td>
	</tr>
  <tr>
    <td><strong>Tanggal</strong></td>
		<td>Dari <?=$date_from;?> s/d <?=$date_to;?></td>
	</tr>
  <tr>
    <td><strong>Waktu Pembaruan Data:</strong></td>
		<td style="color:#AA1122;"><?=$this->m_employee_attn->data_last_update();?></td>
	</tr>
</table>
<p></p>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="JAGTable" width="100%">
<thead>
	<tr>
		<th>NIK</th>
		<th>Nama Karyawan</th>
		<th>Tanggal</th>
		<th>Jam</th>
		<th>Cabang</th>
		<th>Finger ID</th>
		<th>Status Mesin</th>
		<th>Status Proses</th>
  </tr>
</thead>
<tbody>
<?php
//$attn1 =  $data['attns']->result_array();
//echo '<pre>';
//print_r($attn1);
//echo '</pre>';
if($data['attns'] != FALSE) :
	$i = 1;
	$attn_tgl = '';
	foreach ($data['attns'] as $attn):
	
?>
<?php if($attn_tgl != $attn['tanggal']) { 
	$attn_tgl = $attn['tanggal'];
?>
  <tr class="table_row_1">
<?php } else { ?>
  <tr class="table_row_2">
<?php } ?>

<?php if ($attn['nik']=='BELUM TERDAFTAR') { ?>
		<td class="grdF"><?=$attn['nik'];?></td>
		<td style="color:#AA1122;"><b>Finger ID belum terdaftar</b></td>
<?php } else { ?>		
		<td><?=$attn['nik'];?></td>
		<td><?=$attn['nama'];?></td>
<?php } ?>
		<td><?=$attn['tanggal'];?></td>
		<td><?=$attn['waktu'];?></td>
<?php 
if ($hr_code!=$attn['cabang_asal']) { 
	$attn['cabang_asal'] = $attn['cabang_asal'].' <span style="color:#AA1122;">[DL]</span>';	
?>
		<td style="background-color:#FDD250;"><?=$attn['cabang_asal'];?></td>
<?php } else { ?>
		<td><?=$attn['cabang_asal'];?></td>
<?php } ?>
		<td><?=$attn['finger_print'];?></td>

<?php if ($attn['status_absen']==1) { ?>
		<td class="grd grdA">IN</td>
<?php } else { ?>
		<td class="grd grdE">OUT</td>
<?php } ?>

<?php 
if (($attn['nik']=='BELUM TERDAFTAR') && ($attn['status_proses']==1)) $attn['status_proses']=0;
if ($attn['status_proses']==1) { ?>
		<td class="grd grdA">OK</td>
<?php } else { 
			if ($attn['data_type']==1) {
?>
		<td class="grd grdC">WAITING</td>
<?php 		} else { ?>
		<td class="grd grdF">NOT OK</td>
<?php       } } ?>


  </tr>
  <?php
		$i++;
	endforeach;
endif;
?>
</tbody>
</table>

</body>
