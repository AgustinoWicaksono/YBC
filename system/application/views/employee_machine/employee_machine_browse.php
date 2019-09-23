<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('employee_machine/browse_search', $form1);?>
<table>
	<tr>
		<td width="200"><b>Cabang</b></td>
		<td><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
<?php 

if (count($divisi)>2) { ?>
	<tr>
		<td><b>Divisi</b></td>
		<td><?=form_dropdown('divisi', $divisi, $data['divisi'], 'class="input_text"');?></td>
	</tr>
<?php } else { ?>	
	<input type="hidden" name="divisi" id="divisi" value="ALL" />
<?php } ?>
	<tr>
	<td colspan="2" style="padding:1em;border:#ABABAB 1px solid;margin:0.5em;">
	<b>Filter:</b>
		<table>
		<tr>
			<td>Filter berdasarkan:<br /><b>Nama Karyawan</b></td>
			<td><br /><?=form_dropdown('employee_id', $employee, $data['employee_id'], 'class="input_text"');?></td>
		</tr>
		<tr>
			<td>Atau:<br /><b>Status Finger ID</b></td>
			<td><br /><?=form_dropdown('finger_status', $finger_status, $data['finger_status'], 'class="input_text"');?></td>
		</tr>
		</table>
	</td>
	</tr>
  <tr>
    <td><strong>Tanggal</strong></td>
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
		<td><b>Urut berdasarkan</b></td>
		<td><?=form_dropdown('order', $order, $data['order'], 'class="input_text"');?></td>
	</tr>
	<tr>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
</table>
<?=form_close();?>
