<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$page_title;?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space"><a href="javascript:history.go(-1)"><?=$this->lang->line('back');?></a> <?=anchor('perm/group_edit/'.$group_id, $this->lang->line('edit'));?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<td class="column_description"><?=$this->lang->line('perm_group_name');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_input_show('group_name', $data['group_name'], 'class="input_text"');?></td>
				</tr>
<?php if($perms !== FALSE) : ?>
				<tr>
					<td class="column_description"><?=$this->lang->line('perm_perms');?></td>
					<td class="column_colon">:</td>
					<td class="column_input">
<?php
// $i and $j variables used for shown permission category

$i = 0;
foreach ($perms->result_array() as $perm) {

	$j = $perm['cat_id'];
		
	if($j != $i) {
		if($i != 0) echo "<br />";
		echo "<strong>".$this->lang->line('perm_opt_category_'.$perm['category_name'])."</strong>\n<br />";
	}

	if(substr_count($data['group_perms'], $perm['category_code'].sprintf("%02s", $perm['perm_code']))) {
		$perm_content = 1;
	} else {
		$perm_content = 0;
	}

	echo form_checkbox_symbol('perm['.$perm['cat_id'].'_'.$perm['perm_order_id'].']', $perm['category_code'].sprintf("%02d", $perm['perm_code']), $perm_content, $this->lang->line('perm_opt_'.$perm['perm_name']))."<br />";

	$i = $j;
}
?></td>
				</tr>
<?php endif; ?>
			</table>
		</td>
	</tr>
</table>
