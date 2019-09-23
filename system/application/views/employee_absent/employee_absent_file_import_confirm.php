<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('employee_absent/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#AA1122"><b>PERHATIAN:</b> Harap cek bagian yang diberi warna merah, karena NIK tersebut tidak terdaftar di sistem HRD.</font></p>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan NIK, tanggal, atau Kode Jenis Izin), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">NIK</th>
		<th class="table_header_1">Nama</th>
		<th class="table_header_1">Tanggal</th>
		<th class="table_header_1">Kode Jenis Izin</th>
		<th class="table_header_1">Nama Jenis Izin</th>
		<th class="table_header_1">Keterangan</th>
	</tr>
<?php


if($absent !== FALSE) :
	$i = 1;
	$noerror = true;
	foreach ($absent as $abs) :
		$swbStyle='';
		if ($abs['note']=='DATA SALAH!') { $swbStyle=' style="background:#E74E5E;" '; $noerror=false; }
		elseif (strpos('###'.$abs['note'],'CUTI TIDAK DAPAT DIAMBIL')>0) { $swbStyle=' style="background:#FDD250;" ';$noerror=false; }
		elseif (strpos('###'.$abs['note'],'CUTI HUTANG TIDAK DAPAT DIAMBIL')>0) { $swbStyle=' style="background:#FDD250;" ';$noerror=false; }
?>
	<tr>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['nik'];?></td>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['nama'];?></td>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['date_from'];?> sampai <?=$abs['date_to'];?></td>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['type_code'];?></td>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['type_name'];?></td>
		<td class="table_content_1"<?php echo $swbStyle; ?>><?=$abs['note'];?></td>
	</tr>
<?php
		$i++;

	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?php if ($noerror) { ?> <?=form_submit('button[upload]', 'Upload Data');?> <?php } ?><?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
	<?php if (!$noerror) { ?>
	<tr> <td colspan="6" align="left" style="color:#aa1122;font-weight:bold;">Silahkan cek kembali file Excel Anda, karena ada beberapa kesalahan yang harus diperbaiki terlebih dulu sebelum melakukan upload</td></tr>
	<?php } ?>
<?=form_close();?>
</table>
