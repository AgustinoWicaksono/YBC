<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));

// print_r($this->session->userdata);
?>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table border="0" align="center">
<?=form_open('delstockopname/browse_search', $form1);?>
  <tr>
		<td align="center"><strong>Date <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> 
		<script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});
			</script></strong>

    </td>
    <td width="95"><?=form_submit($this->config->item('button_delete'), 'Delete');?></td>
  </tr>
</table>
