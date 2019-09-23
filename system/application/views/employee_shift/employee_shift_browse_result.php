 <?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table>
<?=form_open('employee_shift/browse_search', $form1);?>
	<tr>
		<td><strong>Cabang</strong></td>
		<td colspan="2"><?php echo $this->session->userdata['ADMIN']['plant_name'];?> / <?php echo $this->session->userdata['ADMIN']['storage_location_name'];?> / <?php echo $this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
  <tr>
    <td><strong>Tanggal</strong></td>
		<td><?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});

		</script> s/d <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});

					</script>
    </td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'View');?></td>
  </tr>
<?=form_close();?>
	<tr><td colspan="3">ATAU</td></tr>
<?=form_open_multipart('employee_shift/file_import');?>
	<tr>
		<td><strong>Upload File<br />(XLS Excel File)</strong></td>
		<td><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?></td>
		<td width="95"><?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
	</tr>
</table>
<?=form_close();?>
<?php
$uri_segment3 = $this->uri->segment(3);
$uri_segment4 = $this->uri->segment(4);

if(!empty($uri_segment3) || !empty($uri_segment4)) :
?>
<p></p>
<?=form_open('employee_shift/browse_result', $form2);?>
<table border="0">
	<tr class="table_header_1">
		<th class="table_header_1">NIK <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
		<th class="table_header_1">Nama <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></th>
<?php

	$dc['year'] = substr($uri_segment3, 0, 4);
	$dc['month'] = substr($uri_segment3, 4, 2);
	$dc['day'] = substr($uri_segment3, 6, 2);

	$date[1] = strtotime($dc['year'].'-'.$dc['month'].'-'.$dc['day']);

	for($j = 1; $j <= $days; $j++) :

?>
		<th class = "table_header_1"><?=date('d-m-Y', $date[$j]);?></th>
<?php

		$date[$j+1] = $date[$j] + 86400;

	endfor;
?>
	</tr>
<?php

	if($data['employees'] !== FALSE) :
		$i = 1;
		foreach ($data['employees']->result_array() as $employee):
?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
		<td><?=$employee['nik'];?></td>
		<td><?=$employee['nama'];?></td>
<?php
			for($j = 1; $j <= $days; $j++) :

//				$date_string[$j] = date('Y-m-d', $date[$j]);

				if(!empty($data['shift'][$employee['employee_id']][$date[$j]])) {
					$data['shift_code'] = $data['shift'][$employee['employee_id']][$date[$j]];
				} else if ($data['shift'][$employee['employee_id']][$date[$j]] === '0') {
					$data['shift_code'] = '0';
				} else {
					$data['shift_code'] = '';
				}
				
				$data_lock = intval($data['lock'][$employee['employee_id']][$date[$j]]);
				// $data['lock'] = $data['lock'][$employee['employee_id']][$date[$j]];
				
				
				/*
				echo strtotime('2013-07-05');
				echo 'Shift';print_r( $data['shift']);
				echo '<hr />Shiftcode=';
				print_r( $data['shift_code']);
				*/
				// echo $data['shift_code'].' #'.$data['lock'].'#<hr />';
				
				if (($this->m_employee_shift->employee_shift_check_eom($date[$j],$employee['employee_id'])) && ($data_lock==0)){

?>
		<td><?=form_dropdown('shift['.$employee['employee_id'].']['.$date[$j].']', $shift_code, $data['shift_code'], 'class="input_text"');?></td>
<?php
				} else {
?>				
		<td class="grd" nowrap><?php echo '<img src="'.base_url().'images/lock.png" height="15" width="15" /> '.$shift_code[$data['shift_code']];?></td>
<?php
				}
			endfor;
?>
  </tr>
<?php
		endforeach;
	endif;
?>
</table>
<table class="table-browse">
<tr>
	<td align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td><?=form_submit($this->config->item('button_submit'), $this->lang->line('button_save'));?></td>
</tr>
</table>
<?=form_close();?>
<?php
endif;
?>