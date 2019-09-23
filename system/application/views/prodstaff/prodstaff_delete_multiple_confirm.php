<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('prodstaff/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Trend Utility (Usage) di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['prodstaff_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['prodstaff_headers'] as $prodstaff_header):
		if($prodstaff_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_prodstaff_header['.$i.']', $prodstaff_header['id_prodstaff_header']);?><?=$prodstaff_header['plant'];?><?=date("ymd", strtotime($prodstaff_header['posting_date']));?><?=sprintf("%06d", $prodstaff_header['id_prodstaff_plant']);?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($prodstaff_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Trend Utility (Usage) di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
