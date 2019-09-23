<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('nonstdstock/file_export', $form1);?>
<h3>Apakah Anda setuju untuk meng-export data Purchase Request (PR) di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Purchase Requesition No.</th>
		<th class="table_header_1">Created Date</th>
	</tr>
<?php
if($data['nonstdstock_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['nonstdstock_headers'] as $nonstdstock_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_nonstdstock_header['.$i.']', $nonstdstock_header['id_nonstdstock_header']);?><?=$nonstdstock_header['plant'];?><?=date("ymd", strtotime($nonstdstock_header['created_date']));?><?=sprintf("%06d", $nonstdstock_header['id_nonstdstock_plant']);?></td>
		<td class="table_content_1"><?=$nonstdstock_header['pr_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($nonstdstock_header['created_date']));?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_save_to_excel'), 'Konfirmasi export data Request untuk Non Standard Stock di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
