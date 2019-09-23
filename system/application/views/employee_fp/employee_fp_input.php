<div align="center" class="page_title"><?=$page_title;?></div>
<?php
$form1 = array('id' => 'frmFP', 'name' => 'frmFP');
?>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<?=form_hidden('nik', $this->uri->segment(3));?>
<?=form_hidden('fnik', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1">NIK</td>
		<td class="column_input"><?=$data['nik'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Nama</td>
		<td class="column_input"><?=$data['nama'];?></td>
	</tr>
<?php
//echo "<pre>";
//print_r($data['fingerprint_id']);
//echo "</pre>";
//echo $data['kode_cabang'];
if($data['fingers'] !== FALSE) :
?>
	<tr>
		<td width="272" class="table_field_1" valign="top">Data Fingerprint sekarang</td>
		<td class="column_input">
			<table>
				<tr>
					<th class="table_field_1">Cabang</th>
					<th class="table_field_1">Fingerprint ID</th>
				</tr>
<?php
	$i = 1;
	foreach ($data['fp'] as $fp):
?>
				<tr>
					<td class="column_input"><?=$fp['kode_cabang'];?></td>
					<td class="column_input"><?=$fp['fingerprint_id'];?></td>
				</tr>
<?php
	endforeach;
?>
			</table>
		</td>
	</tr>
<?php
endif;
?>
	<tr>
		<td width="272" class="table_field_1">Kode Cabang</td>
		<td class="column_input"><?=form_hidden('kode_cabang', $data['kode_cabang']);?><?=form_input('kode_cabang', $data['kode_cabang'], 'size="35" class="input_text" disabled="disabled"');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1">Fingerprint ID</td>
		<td class="column_input"><?=form_input('fingerprint_id', $data['fingerprint_id'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td colspan="2" class="column_description_note">
		<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?> 
		<a href="javascript:document.frmFP.reset()" title="Reset"><img src="<?php echo base_url();?>images/jbtnreset.png" border="0" alt="Reset"></a> 
		</td>
	</tr>
</table>
<?=form_close();?>