<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('mwts/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Whole Item No</th>
        <th class="table_header_1">Whole Item Description</th>
        <th class="table_header_1">Plant</th>
	</tr>
	<tr>
		<th class="table_header_4">No.</th>
		<th class="table_header_4">Material No.</th>
		<th class="table_header_4">Material Desc.</th>
		<th class="table_header_4">Quantity</th>
		<th class="table_header_4">Uom</th>
	</tr>
<?php


if($mwts_headers !== FALSE) :
	$i = 1;
	foreach ($mwts_headers as $mwts_header) :
?>
	<tr>
		<td class="table_content_1"><?=$mwts_header['kode_whi'];?></td>
	   	<td class="table_content_1"><?=$mwts_header['nama_whi'];?></td>
	   	<td class="table_content_1"><?=$mwts_header['plant'];?></td>
	</tr>
<?php
		$j = 1;
		foreach ($mwts_details[$i] as $mwts_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$mwts_detail[$i]['material_no'];?></td>
		<td class="table_row_2"><?=$mwts_detail[$i]['material_desc'];?></td>
		<td class="table_row_2"><?=$mwts_detail[$i]['quantity'];?></td>
		<td class="table_row_2"><?=$mwts_detail[$i]['uom'];?></td>
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
