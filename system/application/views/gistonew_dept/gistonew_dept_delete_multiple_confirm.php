<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('gistonew_dept/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Transfer Out Inter Department di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1"><strong>Store Room Request (SR) Number</strong>)</th>
	  <th class="table_header_1">Transfer Slip Number</th>
		<th class="table_header_1">Transfer Out to Outlet</th>
	  <th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['gistonew_dept_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['gistonew_dept_headers'] as $gistonew_dept_header):
		if($gistonew_dept_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_gistonew_dept_header['.$i.']', $gistonew_dept_header['id_gistonew_dept_header']);?><?=$gistonew_dept_header['plant'];?><?=date("ymd", strtotime($gistonew_dept_header['posting_date']));?><?=sprintf("%06d", $gistonew_dept_header['id_gistonew_dept_plant']);?></td>
		<td class="table_content_1"><?=$gistonew_dept_header['po_no'];?></td>
		<td class="table_content_1"><?=$gistonew_dept_header['gistonew_dept_no'];?></td>
		<td class="table_content_1"><?=$gistonew_dept_header['receiving_plant'];?><?=" - ";?><?=$gistonew_dept_header['receiving_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($gistonew_dept_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Issue Stock Transfer Antar Plant di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
