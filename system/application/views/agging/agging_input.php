<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('id_posisi', $this->uri->segment(3));?>
<table class="table-no-border">
	<tr>
		<td colspan="4" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td>
			<table class="table-section">
<!--
				<tr>
					<td class="column_description">Employee Position Code</td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_input('id_posisi', $data['id_posisi'], 'class="input_text"');?></td>
				</tr>
//-->
				<tr>
					<td class="column_description">Employee Position</td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_input('posisi', $data['posisi'], 'class="input_text"');?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4" class="column_description_note"><?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?>  <?=form_reset('button[reset]', $this->lang->line('button_reset'));?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
</table>
<?=form_close();?>