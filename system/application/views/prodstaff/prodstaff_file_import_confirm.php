<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('prodstaff/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data yang akan di-import yang bersumber dari file yang Anda upload.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<p><font color="#FF0000">Jika ada item yang tidak muncul di sini (yang mungkin disebabkan karena kesalahan kode), maka tidak akan dimasukkan ke dalam database.</font></p>
<table class="table-browse">
	<tr>
        <th class="table_header_1">Prodstaff No.</th>
        <th class="table_header_1">Plant</th>
		<th class="table_header_1">Status</th>
	</tr>
	<tr>
		<th class="table_header_1">No.</th>
		<th class="table_header_1">Position.</th>
		<th class="table_header_1">Employee Status .</th>
		<th class="table_header_1">Sum of Empoyee
( Attendance )</th>
		<th class="table_header_2">Total Working Hour </th>
       	</tr>
<?php


if($prodstaff_headers !== FALSE) :
	$i = 1;
	foreach ($prodstaff_headers as $prodstaff_header) :
?>
	<tr>
        <td class="table_content_1"><?=$prodstaff_header['prodstaff_no'];?></td>
	   	<td class="table_content_1"><?=$prodstaff_header['plant'];?></td>
	   	<td class="table_content_1">Unapproved</td>
	</tr>
<?php
		$j = 1;
		foreach ($prodstaff_details[$i] as $prodstaff_detail[$i]) :
?>
	<tr>
		<td class="table_row_2"><?=$j;?></td>
		<td class="table_row_2"><?=$prodstaff_detail[$i]['posisi'];?></td>
		<td class="table_row_2"><?=$prodstaff_detail[$i]['status'];?></td>
		<td class="table_row_2"><?=$prodstaff_detail[$i]['jml_karyawan'];?></td>
		<td class="table_row_2"><?=$prodstaff_detail[$i]['total_jam'];?></td>

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
