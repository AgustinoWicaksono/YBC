<?php
$uri_segment2 = $this->uri->segment(2);
?>
<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('admin_id', $this->uri->segment(3));?>
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
		<td class="column_description"><?=$this->lang->line('admin_username');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_input('admin[admin_username]', $data['admin']['admin_username'], 'class="input_text"');?> <?=$this->lang->line('note1');?></td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('admin_realname');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_input('admin[admin_realname]', $data['admin']['admin_realname'], 'class="input_text"');?> <?=$this->lang->line('note1');?></td>
	</tr>
<?php if($uri_segment2 == 'input') : ?>
	<tr>
		<td class="column_description"><?=$this->lang->line('admin_password');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_password('admin_password', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('admin_password_confirm');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_password('admin_password_confirm', '', 'class="input_text"');?> <?=$this->lang->line('note2');?></td>
	</tr>
<?php endif; // if($uri_segment2 == 'input') : ?>
<?php if($perm_groups !== FALSE) : ?>
	<tr>
		<td class="column_description"><?=$this->lang->line('perm_group_name');?></td>
		<td class="column_colon">:</td>
		<td class="column_input">
<?php
$i = 1; // number of permission group
$number = count($data['admin_perm_group_ids']); // number of member_perm_group_id

foreach ($perm_groups->result_array() as $perm_group) {
	$perm_content[$i] = FALSE;
	for($j = 0; $j < $number; $j++) {
		if($perm_group['group_id'] == $data['admin_perm_group_ids'][$j]) {
			$perm_content[$i] = TRUE;
			break;
		}
	}
	echo form_checkbox('admin_perm_group_id['.$i.']', $perm_group['group_id'], $perm_content[$i], $perm_group['group_name']."<br />");
	$i++;	
}
?></td>
	</tr>
<?php endif; ?>
	<tr>
		<td colspan="4" class="space"><?=$this->lang->line('note1');?> <?=$this->lang->line('note_required');?><br /><?=$this->lang->line('note2');?> <?=$this->lang->line('note_password');?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="column_description_note"><?=form_submit($this->config->item('button_submit'), $this->lang->line($this->config->item('button_submit')));?> <?=form_reset('button[reset]', $this->lang->line('button_reset'));?> &nbsp;<?=form_button($this->config->item('button_cancel'), $this->lang->line('button_cancel'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
</table>
<?=form_close();?>