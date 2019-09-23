<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('gitcc/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Goods Issue No.</th>
        <th class="table_header_1">Plant</th>
		<th class="table_header_1">Storage Location</th>
		<th class="table_header_1">Status</th>
	</tr>
	<tr>
		<th class="table_header_2">No.</th>
		<th class="table_header_2">Material No.</th>
		<th class="table_header_2">Material Desc.</th>
		<th class="table_header_2">Quantity</th>
		<th class="table_header_2">Uom</th>
       	<th class="table_header_2">Text</th>
	</tr>
<?php


if($gitcc_headers !== FALSE) :
	$i = 1;
	foreach ($gitcc_headers as $gitcc_header) :
?>
	<tr>
		<td class="table_content_1"><?=$gitcc_header['gitcc_no'];?></td>
	   	<td class="table_content_1"><?=$gitcc_header['plant'];?></td>
		<td class="table_content_1"><?=$gitcc_header['storage_location'];?></td>
		<td class="table_content_1">Unapproved</td>
	</tr>
<?php
		$j = 1;		
		foreach ($gitcc_details[$i] as $gitcc_detail[$i]) :
?>
	<tr>
		<td class="table_content_2"><?=$j;?></td>
		<td class="table_content_2"><?=$gitcc_detail[$i]['material_no'];?></td>
		<td class="table_content_2"><?=$gitcc_detail[$i]['material_desc'];?></td>
		<td class="table_content_2"><?=$gitcc_detail[$i]['quantity'];?></td>
		<td class="table_content_2"><?=$gitcc_detail[$i]['uom'];?></td>
		<td class="table_content_2"><?=$gitcc_detail[$i]['text'];?></td>
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
