<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('uploadrptvariance/file_import');?>
<table align="center" class ="table_border_1">
  <tr>
    <td align="center"><strong>Date From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': '',
						// input name
						'controlname': 'date_from'
					});

		</script> To <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': '',
						// input name
						'controlname': 'date_to'
					});

					</script></strong>
    </td><td align="center"><?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
  </tr>
</table>
