<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('employee/file_export', $form1);?>
<h3>Apakah Anda setuju untuk meng-export data Employee di bawah ini?</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Outlet</th>
		<th class="table_header_1">NIK</th>
		<th class="table_header_1">Nama</th>
	</tr>
<?php
if($data['employees'] !== FALSE) :
	$i = 1;
	foreach ($data['employees'] as $employee):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('employee_id['.$i.']', $employee['employee_id']);?><?=$employee['employee_id'];?></td>
		<td class="table_content_1"><?=$employee['outlet'];?></td>
		<td class="table_content_1"><?=$employee['nik'];?></td>
		<td class="table_content_1"><?=$employee['nama'];?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_save_to_excel'), 'Konfirmasi Export data Employee di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
