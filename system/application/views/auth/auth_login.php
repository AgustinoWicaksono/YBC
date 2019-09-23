<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_auth', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('auth/login', $form);?>
<table class="table-no-border">
	<tr>
		<td colspan="3" class="error"><?=validation_errors('<div class="error">','</div>'); ?></td>
	</tr>
	<tr>
		<td colspan="3" class="column_page_subject"><?=$this->lang->line('auth_login');?></td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('auth_email');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_input('email', $this->input->post('email'), 'class="input_text"');?></td>
	</tr>
	<tr>
		<td class="column_description"><?=$this->lang->line('auth_password');?></td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=form_password('password'), ,'class="input_text"');?></td>
	</tr>
	<tr>
		<td colspan="3" class="space">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="column_description_note"> <?=form_submit('login', $this->lang->line('button_login'));?></td>
	</tr>
</table>
<?=form_close();?>
