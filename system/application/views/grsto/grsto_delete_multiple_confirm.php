<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grsto/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Transfer In Inter Outlet di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1"><strong>Store Room Request(SR) No</strong></th>
	  <th class="table_header_1">Goods Receipt <br> Stock Transfer No</th>
		<th class="table_header_1">Deliver Outlet</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['grsto_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grsto_headers'] as $grsto_header):
		if($grsto_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_grsto_header['.$i.']', $grsto_header['id_grsto_header']);?><?=$grsto_header['plant'];?><?=date("ymd", strtotime($grsto_header['posting_date']));?><?=sprintf("%06d", $grsto_header['id_grsto_plant']);?></td>
		<td class="table_content_1"><?=$grsto_header['po_no'];?></td>
		<td class="table_content_1"><?=$grsto_header['grsto_no'];?></td>
		<td class="table_content_1"><?=$grsto_header['delivery_plant'];?><?=" - ";?><?=$grsto_header['delivery_plant_name'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($grsto_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Receipt Stock Transfer Antar Outlet di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
