<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('twts/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Trans No.</th>
        <th class="table_header_1">Outlet From</th>
		<th class="table_header_1">Storage Location</th>
		<th class="table_header_1">Status</th>
	</tr>
	<tr>
		<th class="table_header_1">No.</th>
		<th class="table_header_1">GI Material No.</th>
		<th class="table_header_1">GI Material Desc.</th>
		<th class="table_header_1">GI Quantity</th>
		<th class="table_header_1">GI Uom</th>
		<th class="table_header_1">Konv. Quantity</th>
		<th class="table_header_1">GR Material No.</th>
		<th class="table_header_1">GR Material Desc.</th>
		<th class="table_header_1">GR Quantity</th>
		<th class="table_header_1">GR Uom</th>
	</tr>
<?php


if($twts_headers !== FALSE) :
	$i = 1;
	foreach ($twts_headers as $twts_header) :
?>
	<tr>
		<td class="table_content_1"><?=$twts_header['gi_no'];?></td>
	   	<td class="table_content_1"><?=$twts_header['plant'];?></td>
		<td class="table_content_1"><?=$twts_header['storage_location'];?></td>
		<td class="table_content_1">Unapproved</td>
	</tr>
<?php
		$j = 1;		
		foreach ($twts_details[$i] as $twts_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['material_no'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['material_desc'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['quantity'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['uom'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['konv_qty'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['material_no_gr'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['material_desc_gr'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['quantity_gr'];?></td>
		<td class="table_row_2"><?=$twts_detail[$i]['uom_gr'];?></td>
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
