<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('opname/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Request Tambahan  di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Store Room Request (SR)  No.</th>
	  <th class="table_header_1">Request Reason</th>
		<th class="table_header_1">Delivery Date</th>
		<th class="table_header_1">Created Date</th>
	</tr>
<?php
if($data['opname_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['opname_headers'] as $opname_header):
		if($opname_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_opname_header['.$i.']', $opname_header['id_opname_header']);?><?=$opname_header['plant'];?><?=date("ymd", strtotime($opname_header['created_date']));?><?=sopnameintf("%06d", $opname_header['id_opname_plant']);?></td>
		<td class="table_content_1"><?=$opname_header['opname_no'];?></td>
		<td class="table_content_1"><?=$opname_header['request_reason'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($opname_header['delivery_date']));?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($opname_header['created_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Request Tambahan untuk Standard Stock di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
