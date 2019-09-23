<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table border="0" align="center">
<?=form_open('varianceoutlet/browse_search', $form1);?>
  <tr>
    <td align="center"><strong>Select Period <?=form_dropdown('periode', $periode, $data['periode'], 'class="input_text"');?>
    </strong></td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
