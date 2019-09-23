<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('employee_attn_detail/browse_search', $form1);?>
<table>
	<tr>
		<td width="200"><b>Cabang</b></td>
		<td><?=form_dropdown('cabang', $cabang, $data['cabang'], 'class="input_text"');?></td>
	</tr>
	<tr>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
<?=form_close();?>
