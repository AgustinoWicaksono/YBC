<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('trend_utility/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
        <th class="table_header_1">Document No.</th>
		<th class="table_header_1">Kwh Awal</th>
		<th class="table_header_1">Kwh Akhir</th>
		<th class="table_header_1">Kwh Total</th>
		<th class="table_header_1">Plant</th>
	   	<th class="table_header_1">Status</th>
	</tr>

<?php


if($trend_utility_headers !== FALSE) :
	$i = 1;
	foreach ($trend_utility_headers as $trend_utiility_header) :
    ?>

	<tr>
        <td class="table_content_1"><?=$trend_utiility_header['trend_utility_no'];?></td>
		<td class="table_content_1"><?=$trend_utiility_header['kwh_awal'];?></td>
		<td class="table_content_1"><?=$trend_utiility_header['kwh_akhir'];?></td>
		<td class="table_content_1"><?=$trend_utiility_header['kwh_total'];?></td>
         <td class="table_content_1"><?=$trend_utiility_header['plant'];?></td>
		<td class="table_content_1">Unapproved</td>
	</tr>
	<tr>

<?
		$i++;

	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_submit('button[upload]', 'Upload Data');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
