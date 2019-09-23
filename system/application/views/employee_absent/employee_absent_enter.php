<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open('employee_absent/enter_search', $form1);?>
<table width="1038" border="0" align="center">
<?php /* //disabled with new combobox
	<tr>
		<td width="272" class="table_field_1"><strong>NIK</strong></td>
		<td class="column_input"><?=form_dropdown('nik', $nik, $data['nik'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
*/ ?>
	<tr>
		<td class="table_field_1"><strong>Nama / NIK</strong> <em style="font-weight:normal;">(Silahkan ketik nama atau NIK di kotak pencarian)</em></td>
  	<td class="column_input"><?=form_dropdown('nama', $nama, $data['nama'], ' data-placeholder="Pilih karyawan..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');?></td>
	</tr>
<?=form_close();?>
	<tr><td colspan="2">ATAU</td></tr>
<?=form_open_multipart('employee_absent/file_import');?>
	<tr>
		<td><strong>Upload File<br />(XLS Excel File)</strong></td>
		<td><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?> <?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
	</tr>
</table>
<?=form_close();?>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>