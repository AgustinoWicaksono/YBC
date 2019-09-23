<script language="javascript">
	function confirm_absent_id_delete(url, absent_id) {
		var m = confirm('Apakah Anda setuju untuk menghapus data izin karyawan? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open('employee_absent/browse_search/'.$data['employee']['employee_id'], $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>NIK</strong></td>
		<td class="column_input"><?=form_hidden('employee_id', $data['employee']['employee_id']);?><?=form_hidden('nik', $data['employee']['nik']);?><strong><?=$data['employee']['nik'];?></strong> <?=anchor('employee_absent/enter', '<strong>Pilih ulang Karyawan</strong>');?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Nama</strong></td>
		<td class="column_input"><?=form_hidden('nama', $data['employee']['nama']);?><strong><?=$data['employee']['nama'];?></strong></td>
	</tr>
	<tr>
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
		<td width="272" class="table_field_1">Golongan</td>
		<td class="column_input"><?=$data['employee']['golongan'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Level</td>
		<td class="column_input"><?=$data['employee']['level'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Saldo Cuti</td>
		<td class="column_input"><?=$data['employee']['saldo_cuti'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Saldo PH</td>
		<td class="column_input"><?=$data['employee']['saldo_ph'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Hutang Cuti</td>
		<td class="column_input"><?=$data['employee']['saldo_cutihutang'];?></td>
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
	<tr>
		<td class="table_field_1">&nbsp;</td>
		<td class="column_input"><?=anchor('employee_absent/input/'.$this->uri->segment(3).'/'.$this->uri->segment(4), '<strong>Tambah Izin Karyawan</strong>');?> | <strong>Upload File (XLS Excel File)</strong> <?=form_upload('userfile', $data['userfile'], 'class="input_text"');?> <?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
	</tr>
	<tr>
		<td class="table_field_1">&nbsp;</td>
		<td class="column_input">&nbsp;</td>
	</tr>
</table>
<?=form_close();?>
<?=form_open('employee/delete_multiple_confirm', $form2);?>
<table width="1038" border="0">
	<tr>
		<td colspan="5" class="table_field_1"><h2><strong>Lihat Izin Karyawan dari <?=$data['date_from'];?> s/d <?=$data['date_to'];?></strong></h2></td>
	</tr>
	<tr>
		<td colspan="5" align="center"><!--Jumlah data: <?=$total_rows;?>--></td>
	</tr>
	<tr>
		<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
	</tr>
	<tr class="table_header_1">
<!--		<th width="20">&nbsp;</th>-->
		<th width="20" class = "table_header_1">Action</th>
		<th width="100" class="table_header_1">Tanggal<br /><?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
		<th width="100" class = "table_header_1">Jenis Izin</th>
		<th width="150" class = "table_header_1">Keterangan</th>
  </tr>
<?php
if($data['employee_absents'] !== FALSE) :
	$i = 1;
	
	foreach ($data['employee_absents']->result_array() as $absent):

?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
<!--		<td align="center"><?=form_checkbox('absent_id['.$i.']', $absent['absent_id'], FALSE);?></td> -->
<?php if ($absent['absent_eod_lock']==1) { ?>
		<td align="center" nowrap="nowrap"><img src="<?=base_url().'images/';?>lock.png" height="20" width="20" /></td>
<?php } else { ?>
		<td align="center" nowrap="nowrap"><?php if($absent['absent_endofday'] == '0') : ?><a title="Hapus izin" href="#" onClick='confirm_absent_id_delete("<?=site_url('employee_absent/delete/'.$absent['absent_id']);?>", "<?=$absent['absent_id'];?>")'><img title="Hapus izin" src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
<?php } ?>
		<td><?=$absent['absent_date'];?></td>
		<td><?=$this->m_employee_absent->type_name_select($absent['absent_type']);?></td>
		<td><?=$absent['absent_note'];?></td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><!--<tr><td class="table_content_1" colspan="11"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?>--></td>
</tr>
</table>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center"><!--Jumlah data: <?=$total_rows;?>--></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
<?=form_close();?>

<script language="javascript">
	function selectAll(){
//		t=document.form2.length;
//		document.write(t);
		//for(i=1; i<t-1; i++)
		for(i=0; i < <?=$i;?>; i++)
			document.form2[i].checked=document.form2[<?=$i;?>].checked;
	}

/*
	function selectAll(){
//		t=document.form2.length;
//		document.write(t);
		//for(i=1; i<t-1; i++)
		for(i=0; i < <?=$total_rows;?>; i++)
			document.form2[i].checked=document.form2[<?=$total_rows;?>].checked;
	}
		x=document.form2.length;
		document.write("Data = " + x);
*/
</script>
