<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<style type="text/css">
<!--
.style2 {font-size: 8px}
-->
</style>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="661" border="0" align="center">
<?=form_open('userdelete/browse_search', $form1);?>
  <tr>
    <td width="285" align="left"><strong>Dari Tanggal <span class="style2">(YYYY-MM-DD)</span> 
      <?=form_input('date', $data['date'], 'class="input_text" size="10"');?> 
        <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});
				
		</script>
    </strong></td>
    <td width="291" align="left"><strong>Sampai Tanggal <span class="style2">(YYYY-MM-DD)</span> 
      <?=form_input('to', $data['to'], 'class="input_text" size="10"');?> 
        <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});
				
		</script>
    </strong></td>
    
    <td width="71"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
