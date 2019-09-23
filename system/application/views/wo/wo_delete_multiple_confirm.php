<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('gisto_dept/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus Retur di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Purchase Order No </th>
		<th class="table_header_1">Retur <br> Stock Transfer No</th>
		<th class="table_header_1">Receiving Outlet</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['gisto_dept_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['gisto_dept_headers'] as $gisto_dept_header):
		if($gisto_dept_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_gisto_dept_header['.$i.']', $gisto_dept_header['id_gisto_dept_header']);?><?=$gisto_dept_header['plant'];?><?=date("ymd", strtotime($gisto_dept_header['posting_date']));?><?=sprintf("%06d", $gisto_dept_header['id_gisto_dept_plant']);?></td>
		<td class="table_content_1"><?=$gisto_dept_header['po_no'];?></td>
		<td class="table_content_1"><?=$gisto_dept_header['gisto_dept_no'];?></td>
		<td class="table_content_1"><?=$gisto_dept_header['receiving_plant'];?><?=" - ";?><?=$gisto_dept_header['receiving_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($gisto_dept_header['posting_date']));?></td>
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
