<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_perm', $this->session->userdata('lang_name'));
$this->lang->load('g_admin', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script type="text/javascript">
<!--
function toggle_visibility(id) {
	var e = document.getElementById(id);
	if(navigator.appName == 'Microsoft Internet Explorer') {
		if(e.style.display == 'block')
			e.style.display = 'none';
		else
			e.style.display = 'block';
	} else {
		if(e.style.display == 'table-row')
			e.style.display = 'none';
		else
			e.style.display = 'table-row';
	}	
}
//-->
</script>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$this->lang->line('perm_perm');?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
<?php if($this->l_auth->is_have_perm($perm_codes['add'])) : ?>
	<tr>
		<td colspan="3" class="space"><?=anchor('perm/group_add', $this->lang->line('perm_group_perm_add'));?></td>
	</tr>
<?php endif; ?>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<th width="10" class="table_header_1">#</th>
<!--					<th class="table_header_1"><?=$this->lang->line('change_order');?></th> //-->
					<th class="table_header_1"><?=$this->lang->line('perm_group_name');?></th>
					<th class="table_header_1"><?=$this->lang->line('perm_group_grant');?></th>
<?php if($this->l_auth->is_have_perm($perm_codes2)) : ?>
					<th class="table_header_1"><?=$this->lang->line('action');?></th>
<?php endif; ?>
				</tr>
<?php
if($data['perm_groups'] !== FALSE) :
	$i = 1;
	foreach ($data['perm_groups']->result_array() as $perm_group):
		// if admin only have access to see his own permission group
		if(!$this->l_auth->is_have_perm($perm_codes['own']))
			if($perm_group['group_id'] != $this->m_perm->perm_group_id_select())
				continue;
?>
				<tr id="header[<?=$i;?>]">
					<td class="table_content_1" width="10" align="right"><?=$i;?></td>
<!--					<td class="table_content_1" width="10" align="right">&nbsp;</td> //-->
					<td class="table_content_1" width="200"><a href="#header[<?=$i;?>]" onclick="toggle_visibility('detail[<?=$i;?>]');"><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/arrow_down.png" title="<?=$this->lang->line('show_detail');?>" alt="<?=$this->lang->line('show_detail');?>" width="15" /></a> <?=$perm_group['group_name'];?></td>
					<td class="table_content_1" width="100" align="right">&nbsp;</td>
<?php
		if($this->l_auth->is_have_perm($perm_codes2)) :
?>
					<td class="table_content_1" width="*"><?php
			if( $this->l_auth->is_have_perm($perm_codes['view']) && ($perm_group['group_id'] != 2) ) {
				echo anchor_image('perm/group_view/'.$perm_group['group_id'], $this->lang->line('view'), 'view.png', 'height="20" width="20"');
			}

			if( $this->l_auth->is_have_perm($perm_codes['edit']) && ($perm_group['group_id'] != 2) ) {
				echo " ";
				echo anchor_image('perm/group_edit/'.$perm_group['group_id'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');
			}

			if( $this->l_auth->is_have_perm($perm_codes['delete']) && ($perm_group['group_id'] != 2) ) {
				echo " ";
				echo anchor_image('perm/group_delete/'.$perm_group['group_id'], $this->lang->line('delete'), 'delete.png', 'height="20" width="20"');
			}

			if( $this->l_auth->is_have_perm($perm_codes['grant']) && ($perm_group['group_id'] != 2) ) {
				echo " ";
				echo anchor_image('perm/group_grant/'.$perm_group['group_id'], $this->lang->line('perm_group_grant'), 'folder.png', 'height="20" width="20"');
			}
?></td>
<?php
		endif;
?>
				</tr>
				<tr id="detail[<?=$i;?>]" style="display:none">
					<td class="table_content_1" width="10" align="right">&nbsp;</td>
<!--					<td class="table_content_1" width="10" align="right">&nbsp;</td> //-->
					<td class="table_content_1" align="left" colspan="3"><?php
$j = 0;
foreach ($perms->result_array() as $perm) {

	$k = $perm['cat_id'];
		
	if($k != $j) {
		if ($k != 0)
			echo "<br />";
		echo "<strong>".$this->lang->line('perm_opt_category_'.$perm['category_name'])."</strong>\n<br />";
	}

	if(substr_count($perm_group['group_perms'], $perm['category_code'].sprintf("%02s", $perm['perm_code']))) {
		echo $this->lang->line('perm_opt_'.$perm['perm_name'])."<br />";
	}

	if($k != $j && $k != 0) {
			echo "<br />";
	}
	
	$j = $k;
}
?></td>
				</tr>							
<?php
		$i++;
	endforeach;
endif;
?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
</table>
