<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('posinc/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data End Of Day di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Posting Date</th>
		<th class="table_header_1">Total Remintance</th>
	</tr>
<?php
if($data['posinc_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['posinc_headers'] as $posinc_header):
		if($posinc_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_posinc_header['.$i.']', $posinc_header['id_posinc_header']);?><?=$posinc_header['plant'];?><?=date("ymd", strtotime($posinc_header['posting_date']));?><?=sprintf("%06d", $posinc_header['id_posinc_plant']);?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($posinc_header['posting_date']));?></td>
		<td class="table_content_1"><?=$posinc_header['total_remintance'];?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data End Of Day di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
