<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td class="table_field_1">Jenis Outlet</td>
		<td class="column_input"><?=form_dropdown('plant_type', $plant_type, $data['plant_type'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
</table>
<?=form_close();?>