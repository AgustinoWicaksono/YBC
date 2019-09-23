<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_admin', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript" type="text/javascript">
<!--
function toggle_visibility(id) {
	var e = document.getElementById(id);
		if(e.style.display == '')
			e.style.display = 'none';
		else
			e.style.display = '';
}

function confirm_admin_delete(url, username) {
	var m = confirm('<?=$this->lang->line('admin_delete_confirm');?> "' + username + '"?');
	if(m) {
		location.href=url;
	}
}
//-->
</script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table align="center" class="table-no-border">
<?=form_open('log/browse_search', $form1);?>
	<tr>
    <td colspan="3"><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?> <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?> <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?> Records per page : <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?> <?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <?=form_close();?>

	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="space">[<?=anchor('log/input', $this->lang->line('admin_add'));?>]</td>
	</tr>
	<tr>
		<td>
        <table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
			<table class="table-browse">
				<tr>
					<th width="10" class="table_header_1">#</th>
					<th class="table_header_1"><?=$this->lang->line('admin_username');?></th>
					<th class="table_header_1"><?=$this->lang->line('admin_realname');?></th>
					<th class="table_header_1"><?=$this->lang->line('perm_group_name');?></th>
					<th class="table_header_1"><?=$this->lang->line('action');?></th>
			</tr>
<?php
if($data['admins'] !== FALSE) :
	$i = $this->uri->segment(8) + 1; // counter of admin data
	$j = 1; // counter for detail of group permission
	foreach ($data['admins']->result_array() as $admin):

?>
				<tr>
					<td class="table_content_1" width="10" align="right" valign="top"><?=$i++;?></td>
					<td class="table_content_1" width="150" valign="top"><?=$admin['admin_username'];?></td>
					<td class="table_content_1" width="150" valign="top"><?=$admin['admin_realname'];?></td>
<?php
			$perm_groups = $this->m_perm->admin_perm_groups_select($admin['admin_id']);
?>
					<td class="table_content_1" width="150" valign="top">
<?php
			foreach($perm_groups as $perm_group) :
				if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) :
?>
<a href="#header[<?=$j;?>]" onclick="toggle_visibility('detail[<?=$j;?>]');"><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/arrow_down.png" title="<?=$this->lang->line('show_detail');?>" alt="<?=$this->lang->line('show_detail');?>" width="15" /></a>
<?php
				endif;
?> <?=$perm_group['group_name'];?> <br />
<?php
				if( ($perm_group['group_id'] != 1) && ($perm_group['group_id'] != 2) ) :
?>
<div id="detail[<?=$j;?>]" style="display:none"><?=$this->l_auth->perm_group_detail_show($perm_group['group_id']);?></div>
<?php
					$j++;
				endif;

			endforeach;
?>
</td>
					<td class="table_content_1" width="*" valign="top">
<?php

				echo anchor_image('log/profile_edit/'.$admin['admin_id'], $this->lang->line('admin_profile_edit'), 'edit.png', 'height="20" width="20"');

				echo " ";
				echo anchor_image('log/password_edit/'.$admin['admin_id'], $this->lang->line('admin_password_edit'), 'password.png', 'height="20" width="20"');
/*
			if( $this->l_auth->is_have_perm($perm_codes['edit']['group_perm']) ) {
				echo " ";
				echo anchor_image('user/perm_group_edit/'.$admin['admin_id'], $this->lang->line('admin_perm_group_edit'), 'folder.png', 'height="20" width="20"');
			}
*/
			if( ($this->session->userdata['ADMIN']['admin_id'] != $admin['admin_id']) ) {

					echo " ";
//				echo anchor_image('#', $this->lang->line('admin_perm_group_edit'), 'delete.png', "height=\"20\" width=\"20\" onClick='confirm_admin_delete(\"".site_url('user/delete/'.$admin['admin_id'])."\", \"".$admin['admin_realname']."\")')");
?>
<a href="#" onClick='confirm_admin_delete("<?=site_url('log/delete/'.$admin['admin_id']);?>", "<?=$admin['admin_username'];?>")'><img src="<?=base_url();?>images/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/delete.png" title="<?=$this->lang->line('delete');?>" height="20" width="20" /></a>
<?php
			}
?></td>
				</tr>

<?php
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
