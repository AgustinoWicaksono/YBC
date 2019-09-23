<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open('employee_absent/browse_search/'.$data['employee_id'], $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>NIK</strong></td>
		<td class="column_input"><?=form_hidden('employee_id', $data['employee_id']);?><?=form_hidden('nik', $data['nik']);?><strong><?=$data['nik'];?></strong> <?=anchor('employee_absent/enter', '<strong>Pilih ulang Karyawan</strong>');?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Nama</strong></td>
		<td class="column_input"><?=form_hidden('nama', $data['nama']);?><strong><?=$data['nama'];?></strong></td>
	</tr>
	<tr>
	<tr>
		<td width="272" class="table_field_1">Divisi</td>
		<td class="column_input"><?=$data['divisi'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Department</td>
		<td class="column_input"><?=$data['department'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Bagian</td>
		<td class="column_input"><?=$data['bagian'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Jabatan</td>
		<td class="column_input"><?=$data['jabatan'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Golongan</td>
		<td class="column_input"><?=$data['golongan'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Level</td>
		<td class="column_input"><?=$data['level'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Saldo Cuti</td>
		<td class="column_input"><?=$data['saldo_cuti'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Saldo PH</td>
		<td class="column_input"><?=$data['saldo_ph'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Hutang Cuti</td>
		<td class="column_input"><?=$data['saldo_cutihutang'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Masuk</td>
		<td class="column_input"><?=date("d-m-Y", strtotime($data['tanggal_masuk']));?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Resign</td>
		<td class="column_input"><?=$data['tanggal_keluar'];?></td>
	</tr>
  <tr>
    <td width="272" class="table_field_1"><strong>Tanggal</strong></td>
		<td class="column_input"><?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});

		</script> s/d <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});

					</script> <?=form_submit($this->config->item('button_search'), 'View');?></td>
  </tr>
<?=form_close();?>
<?=form_open($this->uri->uri_string(), $form2);?>
	<tr>
		<td colspan="2" class="table_field_1"><h2><strong>Tambah Izin Karyawan</strong></h2><?=form_hidden('new[absent_emp_id]', $data['new']['absent_emp_id']);?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal</td>
		<td class="column_input"><?=form_input('absent_date_1', $data['absent_date_1'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form2',
						// input name
						'controlname': 'absent_date_1'
					});

		</script> </td>
	</tr>
<?php
/*
	<tr>
		<td width="272" class="table_field_1">Jenis Izin</td>
		<td class="column_input"><?=form_input('new[absent_type]', $data['new']['absent_type'], 'class="input_text"');?></td>
	</tr>
*/
?>
	<tr>
		<td width="272" class="table_field_1">Jenis Izin</td>
		<td class="column_input"><?=form_hidden('saldo_cuti', $data['saldo_cuti']);?><?=form_hidden('saldo_ph', $data['saldo_ph']);?><?=form_dropdown('new[absent_type]', $type, $data['new']['type'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Keterangan</td>
		<td class="column_input"><?=form_input('new[absent_note]', $data['new']['absent_note'], 'class="input_text"');?></td>
	</tr>
  <tr>
    <td colspan="2" class="table_field_1"><?=form_submit($this->config->item('button_submit'), 'Submit');?></td>
  </tr>
</table>
<?=form_close();?>