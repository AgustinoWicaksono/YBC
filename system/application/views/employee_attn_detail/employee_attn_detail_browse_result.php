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
<title>Attendance Detail: <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> (<?=$date_from;?> to <?=$date_to;?>)</title>
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
		"aaSorting": [[2,'asc'],[3,'asc'],[4,'asc']],
		"bJQueryUI": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "sScrollY": "350px",
		  "sScrollX": "100%",
		  "sScrollXInner": "170%",
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
<span style="background-color:#AA1122;color:#FDD250;padding:2px;">Teks</span> &nbsp;: Belum ada shift<br />
<span style="background-color:#FDD250;color:#787878;padding:2px;">Teks</span> &nbsp;: Dinas luar<br />
<em>Data shift yang di-input hari ini, akan tampil besok</em>
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
		<th>Cabang</th>
		<th>NIK</th>
		<th>Nama Karyawan</th>
		<th>Tanggal</th>
		<th>Shift</th>
		<th>Shift In</th>
		<th>Shift Break Out</th>
		<th>Shift Break In</th>
		<th>Shift Out</th>
		<th>Kode Absensi</th>
		<th>In</th>
		<th>Break Out</th>
		<th>Break In</th>
		<th>Out</th>
		<th>Total Break</th>
		<th>Terlambat</th>
		<th>Pulang Cepat</th>
		<th>Jam Kerja</th>
  </tr>
</thead>
<tbody>
<?php
//$attn1 =  $data['attns']->result_array();
//echo '<pre>';
//print_r($attn1);
//echo '</pre>';
function TampilkanKosong($datain){
	if ($datain == '00:00')
	  $datain = '';
	  
	return $datain;
}

if($data['attns'] != FALSE) :
	$i = 1;
	foreach ($data['attns']->result_array() as $attn):
		$attn['cabang']=trim($attn['cabang']);
		if ($attn['data_type']==1) { //data referensi bukan data utama
			$classRef = '';
		} elseif ($attn['data_type']==2) {
			$classRef = ' class="swbRef" ';
			if (($hr_code==$attn['cabang']) && (trim($attn['in'])=='00:00:00') && (trim($attn['out'])=='00:00:00')) {
				continue;
			}

/*
			if (($hr_code==$attn['cabang'])) {
				$attn['cabang']=$attn['cabang'].'*';
			}

*/			
		} elseif ($attn['data_type']==3) {
			$classRef = ' style="background-color:#AA1122;color:#FDD250;" ';
		} else {
			$classRef = '';
		}

//		$nama = $this->m_employee->employee_select_by_nik($attn['nik'], 'nama');
//echo $nama;
		$shift_in_int = strtotime($attn['shift_in']);
		$shift_out_int = strtotime($attn['shift_out']);

   	    $in_int = strtotime($attn['in']);
   		$out_int = strtotime($attn['out']);

		$shift_break_in_int = strtotime($attn['shift_break_in']);
		$shift_break_out_int = strtotime($attn['shift_break_out']);

		$break_in_int = strtotime($attn['break_in']);
		$break_out_int = strtotime($attn['break_out']);
		

		if (($attn['in']!='00:00:00')&&($attn['in']!=''))
			$terlambat_int = ($in_int / 60) - ($shift_in_int / 60);
		else
			$terlambat_int = 0;
		
		
		if (($attn['out']!='00:00:00')&&($attn['out']!=''))
			$pulang_cepat_int = ($shift_out_int / 60) - ($out_int / 60);
		else
			$pulang_cepat_int = 0;
		
		
		$total_break_int = ($break_in_int / 60) - ($break_out_int / 60);

		//TERLAMBAT
		if ($attn['terlambat']==''){
			if (($attn['kd_aktual']=='DT') || ($attn['kd_aktual']=='TC')){
				if(($terlambat_int < 0) || ($attn['kd_shift']=='') || ($attn['kd_shift']=='0'))
					$terlambat_int = 0;
				if ($terlambat_int < 60)
				  $terlambat = '00:'.sprintf('%02d',$terlambat_int);
				else
				  $terlambat = sprintf('%02d',$terlambat_int / 60).':'.sprintf('%02d',fmod($terlambat_int,60));
			} else $terlambat = '00:00';
		} else {
			$terlambat = substr($attn['terlambat'],0,5);
		}
		
		
		//PULANG CEPAT
		
		if ($attn['pulang_cepat']==''){
			if (($attn['kd_aktual']=='PC') || ($attn['kd_aktual']=='TC')){
				if(($pulang_cepat_int < 0) || ($attn['kd_shift']=='') || ($attn['kd_shift']=='0'))
					$pulang_cepat_int = 0;
				if ($pulang_cepat_int < 60)
				  $pulang_cepat = '00:'.sprintf('%02d',$pulang_cepat_int);
				else
				  $pulang_cepat = sprintf('%02d',$pulang_cepat_int / 60).':'.sprintf('%02d',fmod($pulang_cepat_int,60));
			} else $pulang_cepat = '00:00';
		} else {
			$pulang_cepat = substr($attn['pulang_cepat'],0,5);
		}


		//JAM KERJA
		if ($attn['jam_kerja']==''){
			if (($attn['out']!='00:00:00')&&($attn['out']!='') &&($attn['in']!='') &&($attn['in']!='') )
				$jam_kerja_int  = (($out_int - $in_int) / 60) ; // - $total_break_int;
			else
				$jam_kerja_int  = 0;

			if(($jam_kerja_int < 0) || ($attn['in'] == '00:00:00') || ($attn['out'] == '00:00:00'))
				$jam_kerja_int = 0;

			if ($jam_kerja_int < 60)
			  $jam_kerja = '00:'.sprintf('%02d',$jam_kerja_int);
			else
			  $jam_kerja = sprintf('%02d',$jam_kerja_int / 60).':'.sprintf('%02d',fmod($jam_kerja_int,60));
		} else {
			$jam_kerja = substr($attn['jam_kerja'],0,5);
		}

		//BREAK
		if(($total_break_int < 0) || ($total_break_int > 1440))
			$total_break_int = 0;

		if ($total_break_int < 60)
  		  $total_break = '00:'.sprintf('%02d',$total_break_int);
        else
  		  $total_break = sprintf('%02d',$total_break_int / 60).':'.sprintf('%02d',fmod($total_break_int,60));



        $in = substr($attn['in'], 0, 5);
        $break_out = substr($attn['break_out'], 0, 5);
        $break_in = substr($attn['break_in'], 0, 5);
        $out = substr($attn['out'], 0, 5);
		
		if ($in==$break_in) $break_in='';
		if ($out==$break_out) $break_out='';
        $in = TampilkanKosong($in);
        $break_out = TampilkanKosong($break_out);
        $break_in = TampilkanKosong($break_in);
        $out = TampilkanKosong($out);

        $pulang_cepat = TampilkanKosong($pulang_cepat);
        $terlambat = TampilkanKosong($terlambat);
        $total_break = TampilkanKosong($total_break);
        $jam_kerja = TampilkanKosong($jam_kerja);

        $shift_in = substr($attn['shift_in'], 0, 5);
        $shift_break_out = substr($attn['shift_break_out'], 0, 5);
        $shift_break_in = substr($attn['shift_break_in'], 0, 5);
        $shift_out = substr($attn['shift_out'], 0, 5);
		/*
		if (!Empty($attn['kd_shift'])){
			if ($shift_in == '00:00')
			  $shift_in = '';
			if ($shift_break_out == '00:00')
			  $shift_break_out = '';
			if ($shift_break_in == '00:00')
			  $shift_break_in = '';
			if ($shift_out == '00:00')
				$shift_out = '';
		}
		*/
/* //20160331 -- disabled request by Yodi krn kasus Ambar
if ($hr_code!=$attn['cabang']) { 
	if (strpos($attn['cabang'],'SX ') ===0) {
		continue;
	}
}
*/

 if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>

<?php
		$gradeClass=$this->m_employee->employee_UI_kodeabsen($attn['kd_aktual']);
?>
<?php 
if ($attn['data_type']==2){
	$attn['kd_aktual'] = '[REF]';
}

// echo '<hr />#'.$hr_code.'#<hr />#'.$attn['cabang'].'#<hr />';
if ($attn['data_type']==2) { // 20160331 - request by Yodi kasus Ambar
	$attn['kd_aktual'] = '<span style="color:#AA1122;">[DL]</span>';	
?>
		<td <?php echo $classRef; ?>style="background-color:#FDD250;"><?=$attn['cabang'];?></td>
<?php } else { ?>
		<td<?php echo $classRef; ?>><?=$attn['cabang'];?></td>
<?php } ?>
		<td<?php echo $classRef; ?>><?=$attn['nik'];?></td>
		<td<?php echo $classRef; ?>><?=$attn['nama'];?></td>
		<td<?php echo $classRef; ?>><?=$attn['tanggal'];?></td>
		<td<?php echo $classRef; ?>><?=$attn['kd_shift'];?></td>
		<td<?php echo $classRef; ?>><?=$shift_in;?></td>
		<td<?php echo $classRef; ?>><?=$shift_break_out;?></td>
		<td<?php echo $classRef; ?>><?=$shift_break_in;?></td>
		<td<?php echo $classRef; ?>><?=$shift_out;?></td>
		<?php if ($attn['data_type']==2) { ?>
		<td<?php echo str_replace('swbRef','swbRef swbCenter',$classRef); ?>><?=$attn['kd_aktual'];?></td>
		<?php } else { ?>
		<td class="grd <?=$gradeClass;?>"><?=$attn['kd_aktual'];?></td>
		<?php } ?>
		<td<?php echo $classRef; ?> align="center"><?=$in;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$break_out;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$break_in;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$out;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$total_break;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$terlambat;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$pulang_cepat;?></td>
		<td<?php echo $classRef; ?> align="center"><?=$jam_kerja;?></td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?>
</tbody>
</table>

</body>
