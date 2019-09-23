<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grpodlv/file_export', $form1);?>
<h3>Apakah Anda setuju untuk meng-export data Goods Receipt PO From Central Warehouse di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Delivery Order No</th>
		<th class="table_header_1">Goods Receipt No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['grpodlv_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grpodlv_headers'] as $grpodlv_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_grpodlv_header['.$i.']', $grpodlv_header['id_grpodlv_header']);?><?=$grpodlv_header['plant'];?><?=date("ymd", strtotime($grpodlv_header['posting_date']));?><?=sprintf("%06d", $grpodlv_header['id_grpodlv_plant']);?></td>
		<td class="table_content_1"><?=$grpodlv_header['do_no'];?></td>
		<td class="table_content_1"><?=$grpodlv_header['grpodlv_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($grpodlv_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_save_to_excel'), 'Konfirmasi Export data Goods Receipt PO STO di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
