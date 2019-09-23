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
<title>Data Tidak Wajar: <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> (<?=$date_from;?> to <?=$date_to;?>)</title>
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
<p></p><p>Report ini hanya digunakan untuk analisa ketidakwajaran yang bisa jadi terdapat potensi <em>cheating</em>. Mengingat report ini cukup konfidensial, harap data di report ini hanya digunakan oleh team HRD.</p>
<div style="font-size:90%;float:right;margin:10px;padding:10px;border:#DEDEDE 1px solid;">
<p>Keterangan <b>Status Mesin</b>:<br />
<span class="grdA">&nbsp;IN&nbsp;</span> &nbsp;: Absen kondisi IN</br>
<span class="grdE">&nbsp;OUT&nbsp;</span> &nbsp;: Absen kondisi OUT</p>

<p>Keterangan <b>Tipe Anomali</b>:<br />
<span class="grdE">&nbsp;JAM MAJU&nbsp;</span> &nbsp;: Jam mesin dimajukan<br />
<span class="grdF">&nbsp;JAM MUNDUR&nbsp;</span> &nbsp;: Jam mesin dimundurkan</p>

</div>
<table>
  <tr>
    <td width="200"><strong>Tanggal</strong></td>
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
		<th>Cabang Asal</th>
		<th>Cabang Mesin</th>
		<th>Finger ID</th>
		<th>Status Mesin</th>
		<th>Tipe Anomali</th>
		<th>Waktu Seharusnya</th>
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

		<td><?=$attn['nik'];?></td>
		<td><?=$attn['nama'];?></td>
		<td><?=$attn['tanggal'];?></td>
		<td><?=$attn['waktu'];?></td>
		<td><?=$attn['cabang_asal'];?></td>
<?php 
if ($attn['cabang_asal']!=$attn['cabang_mesin']) { 
	$attn['cabang_mesin'] = $attn['cabang_mesin'].' <span style="color:#AA1122;">[DL]</span>';	
?>
		<td style="background-color:#FDD250;"><?=$attn['cabang_mesin'];?></td>
<?php } else { ?>
		<td><?=$attn['cabang_mesin'];?></td>
<?php } ?>
		<td><?=$attn['finger_print'];?></td>

<?php if ($attn['status_absen']==1) { ?>
		<td class="grd grdA">IN</td>
<?php } else { ?>
		<td class="grd grdE">OUT</td>
<?php } ?>

<?php 
if ($attn['anomali_type']==1) { ?>
		<td class="grd grdF">JAM MUNDUR</td>
<?php } else { 
?>
		<td class="grd grdE">JAM MAJU</td>
<?php } ?>
		<td><?=$attn['waktu_seharusnya'];?></td>

  </tr>
  <?php
		$i++;
	endforeach;
endif;
?>
</tbody>
</table>

</body>
