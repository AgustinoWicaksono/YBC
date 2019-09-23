<?php
// die('Saat ini input tpaket ditutup untuk sementara hingga proses perbaikan data di kantor pusat selesai. <FORM><INPUT TYPE="button" VALUE="Kembali" onClick="history.go(-1);return true;"> </FORM>');

$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('tpaket/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Transaksi Paket di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Goods Receipt No</th>
		<th class="table_header_1">Goods Issue No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['tpaket_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['tpaket_headers'] as $tpaket_header):
		if($tpaket_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_tpaket_header['.$i.']', $tpaket_header['id_tpaket_header']);?><?=$tpaket_header['plant'];?><?=date("ymd", strtotime($tpaket_header['posting_date']));?><?=sprintf("%06d", $tpaket_header['id_tpaket_plant']);?></td>
		<td class="table_content_1"><?=$tpaket_header['material_doc_no'];?></td>
		<td class="table_content_1"><?=$tpaket_header['material_doc_no_out'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($tpaket_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Transaksi Paket di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>