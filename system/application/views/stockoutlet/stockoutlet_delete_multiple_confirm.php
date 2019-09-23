<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('stockoutlet/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Stock Opname di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Material Doc. No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['stockoutlet_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['stockoutlet_headers'] as $stockoutlet_header):
		if($stockoutlet_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_stockoutlet_header['.$i.']', $stockoutlet_header['id_stockoutlet_header']);?><?=$stockoutlet_header['plant'];?><?=date("ymd", strtotime($stockoutlet_header['posting_date']));?><?=sprintf("%06d", $stockoutlet_header['id_stockoutlet_plant']);?></td>
		<td class="table_content_1"><?=$stockoutlet_header['material_doc_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($stockoutlet_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Stock Opname di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
