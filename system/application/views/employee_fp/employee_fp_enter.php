<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?php
$form1 = array('id' => 'frmFP', 'name' => 'frmFP');
?>
<?=form_open('employee_fp/enter2', $form1);?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
		<td width="272" class="table_field_1">NIK</td>
		<td class="column_input"><?=form_input('nik', $data['nik'], 'class="input_text"');?></td>
	</tr>
	<tr>
		<td colspan="2" class="column_description_note">
			<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  
			<a href="javascript:document.frmFP.reset()" title="Reset"><img src="<?php echo base_url();?>images/jbtnreset.png" border="0" alt="Reset"></a> 
		
		</td>
	</tr>
</table>
<?=form_close();?>
