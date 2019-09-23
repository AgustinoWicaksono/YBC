<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table border="0" align="center">
<?=form_open('prstodlvgr/browse_search', $form1);?>
  <tr>
    <td align="center"><strong>Report Date <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});
        </script>
        Number Go Days <?=form_dropdown('backdays', $backdays, $data['backdays'], 'class="input_text"');?>
        </strong>
    </td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <tr>
  <td align="center">
  <strong>Display Rows which DO vs GR Qtys bigger than 0 Only <?=form_dropdown('dovsgrfilter', $dovsgrfilter, $data['dovsgrfilter'], 'class="input_text"');?></strong>
  </td>
  </tr>
</table>
