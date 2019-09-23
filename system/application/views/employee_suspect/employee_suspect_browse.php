<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p><p>Report ini hanya digunakan untuk analisa ketidakwajaran yang bisa jadi terdapat potensi <em>cheating</em>. Mengingat report ini cukup konfidensial, harap data di report ini hanya digunakan oleh team HRD.</p>
<?=form_open('employee_suspect/browse_search', $form1);?>
<table>
	<tr>
			<td width="300"><b>Jenis Ketidakwajaran Data</b></td>
			<td><?=form_dropdown('finger_status', $finger_status, $data['finger_status'], 'class="input_text"');?></td>
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
