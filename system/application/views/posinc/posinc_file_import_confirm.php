<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('trend_utiility/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Total Remintance</th>
		<th class="table_header_1">Status</th>
	</tr>
	
<?php


if($posinc_headers !== FALSE) :
	$i = 1;
	foreach ($posinc_headers as $posinc_header) :
    ?>
    print_r($posinc_headers);
	<tr>
		<td class="table_content_1"><?=$posinc_header['total_remintance'];?></td>
		<td class="table_content_1">Unapproved</td>
	</tr>
	<tr>
		
<?		
		$i++;

	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_submit('button[upload]', 'Upload Data');?> <?=form_button('button[back]', $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
