<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('sfgs/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">SFG Item No</th>
        <th class="table_header_1">SFG Item Description</th>
        <th class="table_header_1">SFG Quantity</th>
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


if($sfgs_headers !== FALSE) :
	$i = 1;
	foreach ($sfgs_headers as $sfgs_header) :
?>
	<tr>
		<td class="table_content_1"><?=$sfgs_header['kode_sfg'];?></td>
	   	<td class="table_content_1"><?=$sfgs_header['nama_sfg'];?></td>
        <td class="table_content_1"><?=number_format($sfgs_header['quantity_sfg'], 2, '.', '').' '.$sfgs_header['uom_sfg'];?></td>
	   	<td class="table_content_1"><?=$sfgs_header['plant'];?></td>
	</tr>
<?php
		$j = 1;
		foreach ($sfgs_details[$i] as $sfgs_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$sfgs_detail[$i]['material_no'];?></td>
		<td class="table_row_2"><?=$sfgs_detail[$i]['material_desc'];?></td>
		<td class="table_row_2"><?=$sfgs_detail[$i]['quantity'];?></td>
		<td class="table_row_2"><?=$sfgs_detail[$i]['uom'];?></td>
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
