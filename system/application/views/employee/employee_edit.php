<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('employee_id', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
		<td width="272" class="table_field_1">NIK</td>
		<td class="column_input"><?=$data['nik'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Nama</td>
		<td class="column_input"><?=$data['nama'];?></td>
	</tr>
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
		<td width="272" class="table_field_1">ID Fingerprint</td>
		<td class="column_input"><?=form_input('fingerprint_id', $data['fingerprint_id'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Status Kerja</td>
		<td class="column_input"><?=$data['status_kerja'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Masuk</td>
		<td class="column_input"><?=$data['tanggal_masuk'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Akhir Kontrak</td>
		<td class="column_input"><?=$data['tanggal_akhir'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Tanggal Keluar</td>
		<td class="column_input"><?=$data['tanggal_keluar'];?></td>
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
		<td width="272" class="table_field_1">Agama</td>
		<td class="column_input"><?=$data['agama'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Jenis Kelamin</td>
		<td class="column_input"><?=$data['kelamin'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Marital Status</td>
		<td class="column_input"><?=$data['marital'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Nomor Kartu Jamsostek</td>
		<?php if (trim($data['kartu_jamsostek'])=='') { ?>
		<td class="column_input"><?=form_input('kartu_jamsostek', $data['kartu_jamsostek'], 'class="input_text"');?> <br /><i style="color:#aa1122;font-size:90%;">Catatan: Harap isi dengan akurat karena hanya bisa diisi satu kali. Kesalahan pengisian data tanggung jawab dari SM dan MOD.</i></td>
		<?php } else { ?>
		<td class="column_input"><b><?=$data['kartu_jamsostek'];?></b> &nbsp; &nbsp;<i style="font-size:90%;color:#797979;">Catatan: Jika nomor kartu salah, harap buat BA dan hubungi HRD</i></td>
		<?php } ?>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Nomor Kartu Peserta Kesehatan</td>
		<?php if (trim($data['kartu_kesehatan'])=='') { ?>
		<td class="column_input"><?=form_input('kartu_kesehatan', $data['kartu_kesehatan'], 'class="input_text"');?> <br /><i style="color:#aa1122;font-size:90%;">Catatan: Harap isi dengan akurat karena hanya bisa diisi satu kali. Kesalahan pengisian data tanggung jawab dari SM dan MOD.</i></td>
		<?php } else { ?>
		<td class="column_input"><b><?=$data['kartu_kesehatan'];?></b> &nbsp; &nbsp;<i style="font-size:90%;color:#797979;">Catatan: Jika nomor kartu salah, harap buat BA dan hubungi HRD</i></td>
		<?php } ?>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Nomor Kartu NPWP</td>
		<td class="column_input"><b><?=$data['kartu_npwp'];?></b> &nbsp; &nbsp;<i style="font-size:90%;color:#797979;">Catatan: Jika nomor kartu salah, harap buat BA dan hubungi HRD</i></td>
	</tr>
	<tr>
		<td colspan="2" class="column_description_note">
		<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  
		<div style="float:right;">
		<a href="javascript:document.form1.reset()" title="Reset"><img src="<?php echo base_url();?>images/jbtnreset.png" border="0" alt="Reset"></a> 
		<a href="#" onClick="history.go(-1);return true;"><img src="<?php echo base_url();?>images/jbtnback.png" alt="Back" title="Back" border="0" /></a>
		</div>
		<br />&nbsp;
		</td>
	</tr>
</table>
<?=form_close();?>