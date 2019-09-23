<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('twtsnew/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">BOM Item No</th>
        <th class="table_header_1">BOM Item Description</th>
        <th class="table_header_1">BOM Quantity</th>
        <th class="table_header_1">Outlet</th>
	</tr>
	<tr>
		<th class="table_header_4">No.</th>
		<th class="table_header_4">Material No.</th>
		<th class="table_header_4">Material Desc.</th>
		<th class="table_header_4">Quantity</th>
		<th class="table_header_4">Uom</th>
	</tr>
<?php


if($twtsnew_headers !== FALSE) :
	$i = 1;
	foreach ($twtsnew_headers as $twtsnew_header) :
?>
	<tr>
		<td class="table_content_1"><?=$twtsnew_header['kode_paket'];?></td>
	   	<td class="table_content_1"><?=$twtsnew_header['nama_paket'];?></td>
        <td class="table_content_1"><?=number_format($twtsnew_header['quantity_paket'], 2, '.', '').' '.$twtsnew_header['uom_paket'];?></td>
	   	<td class="table_content_1"><?=$twtsnew_header['plant'];?></td>
	</tr>
<?php
		$j = 1;
		foreach ($twtsnew_details[$i] as $twtsnew_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$twtsnew_detail[$i]['material_no'];?></td>
		<td class="table_row_2"><?=$twtsnew_detail[$i]['material_desc'];?></td>
		<td class="table_row_2"><?=$twtsnew_detail[$i]['quantity'];?></td>
		<td class="table_row_2"><?=$twtsnew_detail[$i]['uom'];?></td>
	</tr>
<?php
			$j++;
		endforeach;

		$i++;

	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_submit('button[upload]', 'Upload Data');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
