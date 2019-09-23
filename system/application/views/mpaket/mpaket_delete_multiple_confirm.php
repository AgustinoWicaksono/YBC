<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('mpaket/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Master BOM di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">BOM Item Code</th>
		<th class="table_header_1">BOM Item Description</th>
		<th class="table_header_1">BOM Quantity</th>
	</tr>
<?php
if($data['mpaket_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['mpaket_headers'] as $mpaket_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_mpaket_header['.$i.']', $mpaket_header['id_mpaket_header']);?><?=$mpaket_header['plant'];?><?=date("ymd", strtotime($mpaket_header['posting_date']));?><?=sprintf("%06d", $mpaket_header['id_mpaket_plant']);?></td>
		<td class="table_content_1"><?=$mpaket_header['kode_paket'];?></td>
		<td class="table_content_1"><?=$mpaket_header['nama_paket'];?></td>
		<td class="table_content_1"><?=number_format($mpaket_header['quantity_paket'], 2, '.', '').' '.$mpaket_header['uom_paket'];?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Issue to Cost Center di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
