<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>NIK</strong></td>
<?php if(isset($data['nik']) || isset($data['nama'])) : ?>
		<td class="column_input"><?=form_hidden('nik', $data['nik']);?><?=form_dropdown('nik', $nik, $data['nik'], 'class="input_text" disabled="disabled"');?>
    <?php if(!empty($_POST)) : echo anchor('employee_absent/input', '<strong>Pilih ulang Karyawan</strong>'); endif;?></td>
<?php else : ?>
		<td class="column_input"><?=form_dropdown('nik', $nik, $data['nik'], 'class="input_text" onChange="document.form1.submit();"');?></td>
<?php endif; ?>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Nama</strong></td>
<?php if(isset($data['nik']) || isset($data['nama'])) : ?>
		<td class="column_input"><?=form_hidden('nama', $data['nama']);?><?=form_dropdown('nama', $nama, $data['nama'], 'class="input_text" disabled="disabled"');?></td>
	</tr>
<?php else : ?>
  	<td class="column_input"><?=form_dropdown('nama', $nama, $data['nama'], 'class="input_text" onChange="document.form1.submit();"');?></td>
<?php endif; ?>
	</tr>
<?php if(!empty($data['nik']) && !empty($data['nama'])) : ?>
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
<?php endif; ?>
<?php if(!empty($data['nik']) && !empty($data['nama'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
<?php endif; ?>
</table>
<?=form_close();?>