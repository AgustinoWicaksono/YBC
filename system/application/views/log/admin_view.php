<?php
$uri_segment2 = $this->uri->segment(2);
$uri_segment3 = $this->uri->segment(3);
?>
<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('admin[admin_id]', $this->uri->segment(3));?>
<table class="table-no-border">
	<tr>
		<td colspan="4" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('admin_username');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=$data['admin']['admin_username'];?></td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('admin_realname');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_input_show('admin[admin_realname]', $data['admin']['admin_realname'], 'class="input_text"');?> <?=$this->lang->line('note1');?></td>
	</tr>
<?php if($perm_groups !== FALSE) : ?>
	<tr>
		<td class="column_description"><?=$this->lang->line('perm_group_name');?></td>
		<td class="column_colon">:</td>
		<td class="column_input">
<?php
//if($uri_segment3 == 1) {
//	echo $this->lang->line('all');
//} else {
	$i = 1; // number of permission group
	//$number = count($data['perm_group_ids']); // number of member_perm_group_id

	foreach ($perm_groups->result_array() as $perm_group) {
		$perm_content[$i] = FALSE;
		if($data['perm_group_id']) {
			foreach($data['perm_group_id'] as $perm_group_id) {
				if($perm_group['group_id'] == $perm_group_id) {
					$perm_content[$i] = TRUE;
					break;
				}
			}
		}
		
		echo form_checkbox_symbol('perm_group_id['.$i.']', $perm_group['group_id'], $perm_content[$i], $perm_group['group_name']."<br />");
		$i++;	
	}
//}
?></td>
	</tr>
<?php endif; ?>
	<tr>
		<td colspan="4" class="space"><?=$this->lang->line('note1');?> <?=$this->lang->line('note_required');?><br /><?php if($uri_segment2 == 'input') echo $this->lang->line('note2').' '.$this->lang->line('note_password');?></td>
	</tr>
	<tr>
		<td colspan="4" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="column_description_note"><?=form_submit($this->config->item('button_submit'), $this->lang->line($this->config->item('button_submit')));?> <?=form_reset('button[reset]', $this->lang->line('button_reset'));?> &nbsp;<?=form_button($this->config->item('button_cancel'), $this->lang->line('button_cancel'), "onclick=\"window.location='".site_url('log/browse')."'\"");?></td>
	</tr>
</table>
<?=form_close();?>