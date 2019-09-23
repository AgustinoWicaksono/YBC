<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grnonpo/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Goods Receipt Non PO di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Goods Receipt No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['grnonpo_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grnonpo_headers'] as $grnonpo_header):
		if($grnonpo_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_grnonpo_header['.$i.']', $grnonpo_header['id_grnonpo_header']);?><?=$grnonpo_header['plant'];?><?=date("ymd", strtotime($grnonpo_header['posting_date']));?><?=sprintf("%06d", $grnonpo_header['id_grnonpo_plant']);?></td>
		<td class="table_content_1"><?=$grnonpo_header['grnonpo_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($grnonpo_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Receipt Non PO di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
