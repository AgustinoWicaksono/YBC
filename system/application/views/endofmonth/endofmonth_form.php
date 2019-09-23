<div align="center" class="page_title"><?=$page_title;?></div>
<?=form_open('endofmonth/enter2', $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<td class="column_description">Periode</td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_dropdown('periode', $periodes, $data['periode'], 'class="input_text"');?>
		</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note">
			<?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  
			<a href="javascript:document.form1.reset()" title="Reset"><img src="<?php echo base_url();?>images/jbtnreset.png" border="0" alt="Reset"></a> 
		</td>
	</tr>
</table>
<?=form_close();?>
