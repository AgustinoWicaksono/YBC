<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('gisto/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Goods Issue Stock Transfer Antar Plant di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Purchase Order No (PO STO)</th>
		<th class="table_header_1">Goods Issue <br> Stock Transfer No</th>
		<th class="table_header_1">Receiving Plant</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['gisto_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['gisto_headers'] as $gisto_header):
		if($gisto_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_gisto_header['.$i.']', $gisto_header['id_gisto_header']);?><?=$gisto_header['plant'];?><?=date("ymd", strtotime($gisto_header['posting_date']));?><?=sprintf("%06d", $gisto_header['id_gisto_plant']);?></td>
		<td class="table_content_1"><?=$gisto_header['po_no'];?></td>
		<td class="table_content_1"><?=$gisto_header['gisto_no'];?></td>
		<td class="table_content_1"><?=$gisto_header['receiving_plant'];?><?=" - ";?><?=$gisto_header['receiving_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($gisto_header['posting_date']));?></td>
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
