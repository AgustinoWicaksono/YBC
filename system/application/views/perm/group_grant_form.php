<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('group_id', $this->uri->segment(3));?>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space"><a href="javascript:history.go(-1)"><?=$this->lang->line('back');?></a></td>
	</tr>
<?php
if(!empty($_POST)) :
?>
	<tr>
		<td colspan="3"><?=validation_errors('<div><font color="#FF0000">','</font></div>'); ?></td>
	</tr>
<?php
endif;
?>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<td class="column_description"><?=$this->lang->line('group_name');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_input_show('group_name', $data['group']['group_name'], '', 'class="input_text"');?> <?=form_hidden('group_name', $data['group']['group_name']);?></td>
				</tr>
<?php if($perm_groups !== FALSE) : ?>
				<tr>
					<td class="column_description"><?=$this->lang->line('perm_group_name');?></td>
					<td class="column_colon">:</td>
					<td class="column_input">
<?php
$i = 1; // number of permission group
$number = count($data['admin_perm_group_ids']); // number of admin_perm_group_id

foreach ($perm_groups->result_array() as $perm_group) {
	for($j = 0; $j < $number; $j++) {
		$perm_content[$i] = 0;

		if($perm_group['group_id'] == $data['admin_perm_group_ids'][$j]) {
			$perm_content[$i] = 1;
			break;
		}
	}
	echo form_checkbox('perm_group_id['.$i.']', $perm_group['group_id'], $perm_content[$i], $perm_group['group_name']."<br />");
	$i++;	
}
?></td>
				</tr>
<?php endif; ?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note"><?=form_submit('submit', $this->lang->line('button_save'));?> <?=form_reset('reset', $this->lang->line('button_reset'));?> <?=form_button('cancel', $this->lang->line('button_cancel'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
</table>
<?=form_close();?>
