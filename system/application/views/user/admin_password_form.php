<?=form_open($this->uri->uri_string(), $form);?>
<?=form_hidden('admin_id', $this->uri->segment(3));?>
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
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
<?php
$pass = $this->session->userdata('password');
if(!empty($pass)) :
?>
	<tr>
		<td colspan="3" class="error"><?=$this->lang->line('admin_password_edit_criteria'); ?></td>
	</tr>
<?php
endif;
?>
	<tr>
		<td colspan="3" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td>
			<table class="table-section">
				<tr>
					<td class="column_description"><?=$this->lang->line('admin_username');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=$data['admin_username'];?> <?=form_hidden('admin_username', $data['admin_username']);?></td>
				</tr>
<?php
if (!$this->l_auth->is_have_perm('admin_password_edit_all')) :
?>
				<tr>
					<td class="column_description"><?=$this->lang->line('admin_password_old');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_password('admin_password_old', '', 'class="input_text"');?></td>
				</tr>
<?php
endif;
?>
				<tr>
					<td class="column_description"><?=$this->lang->line('admin_password_new');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_password('admin_password', '', 'class="input_text"');?></td>
				</tr>
				<tr>
					<td class="column_description"><?=$this->lang->line('admin_password_new_confirm');?></td>
					<td class="column_colon">:</td>
					<td class="column_input"><?=form_password('admin_password_confirm', '', 'class="input_text"');?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note">
        <?=form_submit($this->config->item('button_submit_save'), $this->lang->line($this->config->item('button_submit')));?>
        <?=form_reset('reset', $this->lang->line('button_reset'));?>
        </td>
	</tr>
</table>
<?=form_close();?>
