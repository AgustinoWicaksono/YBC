<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('produksi/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus Retur di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Purchase Order No </th>
		<th class="table_header_1">Retur <br> Stock Transfer No</th>
		<th class="table_header_1">Transfer Out to Outlet</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['produksi_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['produksi_headers'] as $produksi_header):
		if($produksi_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_produksi_header['.$i.']', $produksi_header['id_produksi_header']);?><?=$produksi_header['plant'];?><?=date("ymd", strtotime($produksi_header['posting_date']));?><?=sprintf("%06d", $produksi_header['id_produksi_plant']);?></td>
		<td class="table_content_1"><?=$produksi_header['po_no'];?></td>
		<td class="table_content_1"><?=$produksi_header['produksi_no'];?></td>
		<td class="table_content_1"><?=$produksi_header['receiving_plant'];?><?=" - ";?><?=$produksi_header['receiving_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($produksi_header['posting_date']));?></td>
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
