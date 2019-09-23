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
		<td><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
	<tr>
		<td><b>Standard Employee</b></td>
		<td><?=$data['outlet_employee']['STANDARD_EMPLOYEE'];?></td>
	</tr>
	<tr>
		<td><b>Current Employee</b></td>
		<td><?=$data['outlet_employee']['CURRENT_EMPLOYEE'];?></td>
	</tr>
  <tr>
    <td><strong>Date</strong></td>
		<td>From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});

		</script> To <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});

				</script>
    </td>
	</tr>
	<tr>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
<?=form_close();?>
