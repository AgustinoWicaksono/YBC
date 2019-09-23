<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));

// print_r($this->session->userdata);
?>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table border="0" align="center">
<?=form_open('stockstatus/browse_search', $form1);?>
  <tr>
		<td align="center">
			<strong>Month <?=form_dropdown('input_month', $input_month, $data['input_month'], 'class="input_text"');?> 
				<?=form_dropdown('input_year', $input_year, $data['input_year'], 'class="input_text"');?>

    </td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
