<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
<?php
/*
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
*/
?>
<?=validation_errors('<tr><td colspan="2" class="error">','</td></tr>');?>
	<tr>
		<td width="272" class="table_field_1">Cabang</td>
		<td class="column_input"><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Standard Employee</td>
		<td class="column_input"><?=$data['outlet_employee']['STANDARD_EMPLOYEE'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Current Employee</td>
		<td class="column_input"><?=$data['outlet_employee']['CURRENT_EMPLOYEE'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Request</td>
		<td class="column_input"><?=date('d-m-Y');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Divisi</td>
		<td class="column_input"><?=$data['employee']['divisi'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Department</td>
		<td class="column_input"><?=$data['employee']['department'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Bagian</td>
		<td class="column_input"><?=$data['employee']['bagian'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Jabatan</td>
		<td class="column_input"><?=$data['employee']['jabatan'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><b>Requester</b></td>
		<td class="column_input"><b><?=$data['employee']['nama'];?></b></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Status Kerja</td>
		<td class="column_input"><?=form_dropdown('req[req_status_kerja]', $work_status, $data['req']['req_status_kerja'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Jumlah</td>
		<td class="column_input"><?=form_input('req[req_jumlah]', $data['req']['req_jumlah'], 'class="input_text" width="3"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Request Type</td>
		<td class="column_input"><?=form_dropdown('req[req_type]', $req_type, $data['req']['req_type'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td class="table_field_h" colspan="2">Add. Req.</td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Start to Work</td>
		<td class="column_input"><?=form_input('start_date', $data['start_date'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'start_date'
					});

		</script></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Status Sipil</td>
		<td class="column_input"><?=form_dropdown('req[req_marital]', $marital, $data['req']['req_marital'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Jenis Kelamin</td>
		<td class="column_input"><?=form_dropdown('req[req_kelamin]', $req_kelamin, $data['req']['req_kelamin'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Pendidikan</td>
		<td class="column_input"><?=form_dropdown('req[req_education]', $education, $data['req']['req_education'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Umur</td>
		<td class="column_input"><?=form_input('req[req_umur]', $data['req']['req_umur'], 'class="input_text" size="2" onkeydown="validateNumber(event);"');?> tahun</td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Pengalaman</td>
		<td class="column_input"><?=form_input('req[req_pengalaman]', $data['req']['req_pengalaman'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Others</td>
		<td class="column_input"><?=form_textarea('req[req_others]', $data['req']['req_others'], 4, 30, 'class="input_text"');?></td>
	</tr>

	<tr>
		<td colspan="2" class="column_description_note"><?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  <?=form_reset('button[reset]', $this->lang->line('button_reset'));?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
</table>
<?=form_close();?>