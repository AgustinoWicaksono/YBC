<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('employee_shift/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan NIK atau tanggal), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
		<th class="table_header_1">NIK</th>
		<th class="table_header_1">Nama</th>
<?php
if($shift !== FALSE) :
	for($j = 3; $j <= count($shift[1]); $j++) :
?><th class="table_header_1"><?=$shift[1][$j];?></th>
<?php
	endfor;
?>
	</tr>
<?php
	for($i = 2; $i <= $rows; $i++) :
?>
	<tr>
<?php
		for ($j = 1; $j <= count($shift[$i]); $j++) :
?><td class="table_content_1" align="center"><?=$shift[$i][$j];?></td>
<?php
		endfor;
	endfor;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_submit('button[upload]', 'Upload Data');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
