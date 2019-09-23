<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('gistonew_out/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Goods Issue Antar Department di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1"><strong>Store Room Request (SR) Number</strong>)</th>
		<th class="table_header_1"><strong>Transfer Slip Number</strong></th>
	  <th class="table_header_1"><strong>Transfer Out To  Outlet</strong></th>
	  <th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['gistonew_out_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['gistonew_out_headers'] as $gistonew_out_header):
		if($gistonew_out_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_gistonew_out_header['.$i.']', $gistonew_out_header['id_gistonew_out_header']);?><?=$gistonew_out_header['plant'];?><?=date("ymd", strtotime($gistonew_out_header['posting_date']));?><?=sprintf("%06d", $gistonew_out_header['id_gistonew_out_plant']);?></td>
		<td class="table_content_1"><?=$gistonew_out_header['po_no'];?></td>
		<td class="table_content_1"><?=$gistonew_out_header['gistonew_out_no'];?></td>
		<td class="table_content_1"><?=$gistonew_out_header['receiving_plant'];?><?=" - ";?><?=$gistonew_out_header['receiving_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($gistonew_out_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Transfer Out Inter Outlet di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
