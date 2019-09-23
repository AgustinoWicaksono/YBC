<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_perm', $this->session->userdata('lang_name'));
$this->lang->load('g_admin', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script type="text/javascript">
<!--
/*
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
*/
function toggle_visibility(id) {
	var e = document.getElementById(id);
		if(e.style.display == '')
			e.style.display = 'none';
		else
			e.style.display = '';
}

function confirm_perm_group_delete(url, group_name) {
	var m = confirm('<?=$this->lang->line('perm_group_delete_confirm');?> "' + group_name + '"?');
	if(m) {
		location.href=url;
	}
}
//-->
</script>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="column_page_subject"><?=$this->lang->line('perm_group_perm');?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space"><?=anchor('perm/group_add', $this->lang->line('perm_group_perm_add'));?></td>
	</tr>
	<tr>
		<td>
			<table class="table-browse">
				<tr>
					<th width="10" class="table_header_1">#</th>
<!--					<th class="table_header_1"><?=$this->lang->line('change_order');?></th> //-->
					<th class="table_header_1"><?=$this->lang->line('perm_group_name');?></th>
<!--					<th class="table_header_1"><?=$this->lang->line('perm_group_grant');?></th> //-->
					<th class="table_header_1"><?=$this->lang->line('perm_group_admins');?></th>
					<th class="table_header_1"><?=$this->lang->line('action');?></th>
				</tr>
<?php
if($data['perm_groups'] !== FALSE) :
	$i = 1;
	foreach ($data['perm_groups']->result_array() as $perm_group):
		// if admin only have access to see his own permission group
		//if($perm_group['group_id'] != $this->m_perm->perm_group_id_select())
			//continue;
?>
				<tr id="header[<?=$i;?>]">
					<td class="table_content_1" width="10" align="right"><?=$i;?></td>
<!--					<td class="table_content_1" width="10" align="right">&nbsp;</td> //-->
					<td class="table_content_1" width="200"><?php if( ($perm_group['group_id'] == 1) || ($perm_group['group_id'] == 2) ) : echo ''; else : ?><a href="#header[<?=$i;?>]" onclick="toggle_visibility('detail[<?=$i;?>]');"><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/arrow_down.png" title="<?=$this->lang->line('show_detail');?>" alt="<?=$this->lang->line('show_detail');?>" width="15" /></a><?php endif; ?> <?=$perm_group['group_name'];?></td>
					<td class="table_content_1" width="100" align="left">
<?php					
		if($admins = $this->m_perm->perm_group_admins_select($perm_group['group_id'])) :
?>
						<a href="#header[<?=$i;?>]" onclick="toggle_visibility('admins[<?=$i;?>]');"><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/arrow_down.png" title="<?=$this->lang->line('show_detail');?>" alt="<?=$this->lang->line('show_detail');?>" width="15" /></a> <span id="admins[<?=$i;?>]" style="display:none">
<?php
			foreach($admins->result_array() as $admin) {
				echo anchor('user/profile_edit/'.$admin['admin_id'], $admin['admin_username']).' ';
			}
?>
						</span>
<?php
		else :
			echo "&nbsp;";
		endif;
?>
					</td>
					<td class="table_content_1" width="*"><?php
			if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) {
				echo anchor_image('perm/group_view/'.$perm_group['group_id'], $this->lang->line('view'), 'view.png', 'height="20" width="20"');
			}

			if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) {
				echo " ";
				echo anchor_image('perm/group_edit/'.$perm_group['group_id'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');
			}

			if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) && (!$this->m_perm->check_group_id_exist($perm_group['group_id'])) ) {
				echo " ";
?><a href="#header[<?=($i-1);?>]" onClick='confirm_perm_group_delete("<?=site_url('perm/group_delete/'.$perm_group['group_id']);?>", "<?=$perm_group['group_name'];?>")'><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/delete.png" title="<?=$this->lang->line('delete');?>" height="20" width="20" /></a>
<?php	
			}
/*			
			if( $this->l_auth->is_have_perm($perm_codes['grant']) && ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) {
				echo " ";
				echo anchor_image('perm/group_grant/'.$perm_group['group_id'], $this->lang->line('perm_group_grant'), 'folder.png', 'height="20" width="20"');
			}
*/
?></td>
				</tr>
<?php
		if ( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) :
?>
				<tr id="detail[<?=$i;?>]" style="display:none">
					<td class="table_content_1" width="10" align="right">&nbsp;</td>
<!--					<td class="table_content_1" width="10" align="right">&nbsp;</td> //-->
					<td class="table_content_1" align="left" colspan="3"><?=$this->l_auth->perm_group_detail_show($perm_group['group_id']);?></td>
				</tr>							
<?php
		endif;

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
