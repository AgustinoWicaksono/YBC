<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grnonpo/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Goods Receipt No.</th>
        <th class="table_header_1">Plant</th>
		<th class="table_header_1">Storage Location</th>
		<th class="table_header_1">Status</th>
	</tr>
	<tr>
		<th class="table_header_1">No.</th>
		<th class="table_header_1">Material No.</th>
		<th class="table_header_1">Material Desc.</th>
		<th class="table_header_1">Quantity</th>
		<th class="table_header_1">Uom</th>
       	<th class="table_header_1">Text</th>
	</tr>
<?php


if($grnonpo_headers !== FALSE) :
	$i = 1;
	foreach ($grnonpo_headers as $grnonpo_header) :
?>
	<tr>
		<td class="table_content_1"><?=$grnonpo_header['grnonpo_no'];?></td>
	   	<td class="table_content_1"><?=$grnonpo_header['plant'];?></td>
		<td class="table_content_1"><?=$grnonpo_header['storage_location'];?></td>
		<td class="table_content_1">Unapproved</td>
	</tr>
<?php
		$j = 1;
		foreach ($grnonpo_details[$i] as $grnonpo_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$grnonpo_detail[$i]['material_no'];?></td>
		<td class="table_row_2"><?=$grnonpo_detail[$i]['material_desc'];?></td>
		<td class="table_row_2"><?=$grnonpo_detail[$i]['quantity'];?></td>
		<td class="table_row_2"><?=$grnonpo_detail[$i]['uom'];?></td>
		<td class="table_row_2"><?=$grnonpo_detail[$i]['additional_text'];?></td>
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
