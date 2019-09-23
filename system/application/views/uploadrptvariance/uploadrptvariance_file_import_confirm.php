<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('uploadrptvariance/file_import_execute', $form1);?>
<h3>Data berikut ini adalah data report yang akan di-upload yang bersumber dari Report SAP.  Silakan cek kembali data di bawah ini. Jika benar, klik tombol <b>Upload Data</b>.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">Outlet</th>
		<th class="table_header_1">Period</th>
		<th class="table_header_1">Start Period</th>
		<th class="table_header_1">End Period</th>
		<th class="table_header_1">Material</th>
		<th class="table_header_1">UoM</th>
		<th class="table_header_1">Retur</th>
		<th class="table_header_1">Actual</th>
		<th class="table_header_1">Standard</th>
		<th class="table_header_1">Variance</th>
	</tr>
<?php


if($uploadrptvariance_datas !== FALSE) :
	$i = 1;
	foreach ($uploadrptvariance_datas as $uploadrptvariance_data) :
       if($i==2) {
         echo form_hidden('date_from',$uploadrptvariance_data['S_PERIODE']);
         echo form_hidden('date_to', $uploadrptvariance_data['E_PERIODE']);
       }
?>
	<tr>
		<td class="table_content_1"><?=$uploadrptvariance_data['OUTLET'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['PERIODE'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['S_PERIODE'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['E_PERIODE'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['MATERIAL'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['UOM'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['RETUR'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['ACTUAL'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['STANDART'];?></td>
		<td class="table_content_1"><?=$uploadrptvariance_data['VARIANCE'];?></td>
	</tr>
<?php
		$i++;

	endforeach;
else :
?>
	<tr>
		<td align="center" colspan="10"><strong>Tidak ada data dari report SAP yang dapat di upload. Silakan Pilih Periode yang lain.</strong></td>
     </tr>
<?php
endif;
?>
	<tr>
		<td colspan="6" align="center">
<?php
  if($i>1) :
?>
        <?=form_submit('button[upload]', 'Upload Data');?>
<?php
  endif;
?>
        <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
