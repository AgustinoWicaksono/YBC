<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('trend_utility/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Trend Utility (Usage) di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">KWH Awal</th>
		<th class="table_header_1">KWH Akhir</th>
		<th class="table_header_1">KWH Total</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['trend_utility_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['trend_utility_headers'] as $trend_utility_header):
		if($trend_utility_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_trend_utility_header['.$i.']', $trend_utility_header['id_trend_utility_header']);?><?=$trend_utility_header['plant'];?><?=date("ymd", strtotime($trend_utility_header['posting_date']));?><?=sprintf("%06d", $trend_utility_header['id_trend_utility_plant']);?></td>
		<td class="table_content_1"><?=$trend_utility_header['kwh_awal'];?></td>
		<td class="table_content_1"><?=$trend_utility_header['kwh_akhir'];?></td>
		<td class="table_content_1"><?=$trend_utility_header['kwh_total'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($trend_utility_header['posting_date']));?></td>
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
