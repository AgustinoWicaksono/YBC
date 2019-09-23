<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('sfgs/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Master Semi Finished Goods (SFG) BOM di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">SFG Item Code</th>
		<th class="table_header_1">SFG Item Description</th>
		<th class="table_header_1">SFG Quantity</th>
	</tr>
<?php
if($data['sfgs_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['sfgs_headers'] as $sfgs_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_sfgs_header['.$i.']', $sfgs_header['id_sfgs_header']);?><?=$sfgs_header['plant'];?><?=date("ymd", strtotime($sfgs_header['posting_date']));?><?=sprintf("%06d", $sfgs_header['id_sfgs_plant']);?></td>
		<td class="table_content_1"><?=$sfgs_header['kode_sfg'];?></td>
		<td class="table_content_1"><?=$sfgs_header['nama_sfg'];?></td>
		<td class="table_content_1"><?=number_format($sfgs_header['quantity_sfg'], 2, '.', '').' '.$sfgs_header['uom_sfg'];?></td>
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
