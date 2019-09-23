<?php
$this->lang->load('g_general', $this->session->userdata('lang_name'));
?>
<table class="table-no-border">
	<tr>
		<td class="column_page_subject"><?=$this->lang->line('redirect');?></td>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
	<tr>
		<td><?=$refresh_text;?><br />
		<?=sprintf($this->lang->line('redirect_error_text'), site_url($refresh_url));?></td>
<?php /*
		<?=sprintf($this->lang->line('redirect_text'), $this->config->item('refresh_time'), site_url($refresh_url));?></td>

*/ ?>
	</tr>
	<tr>
		<td class="space">&nbsp;</td>
	</tr>
</table>
