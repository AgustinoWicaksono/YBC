<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('retin/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Goods Receipt From Department di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Retur Out No</th>
	  <th class="table_header_1">Retur In No</th>
	  <th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['retin_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['retin_headers'] as $retin_header):
		if($retin_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_retin_header['.$i.']', $retin_header['id_retin_header']);?><?=$retin_header['plant'];?><?=date("ymd", strtotime($retin_header['posting_date']));?><?=sprintf("%06d", $retin_header['id_retin_plant']);?></td>
		<td class="table_content_1"><?=$retin_header['do_no'];?></td>
		<td class="table_content_1"><?=$retin_header['retin_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($retin_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Receipt PO di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
