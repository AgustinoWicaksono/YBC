<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grpofg/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data GR PO STO & GR FG Pastry/Cookies dr CK di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Delivery Order No</th>
		<th class="table_header_1">Goods Receipt PO No</th>
		<th class="table_header_1">Goods Receipt FG No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['grpofg_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grpofg_headers'] as $grpofg_header):
		if($grpofg_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_grpofg_header['.$i.']', $grpofg_header['id_grpofg_header']);?><?=$grpofg_header['plant'];?><?=date("ymd", strtotime($grpofg_header['posting_date']));?><?=sprintf("%06d", $grpofg_header['id_grpofg_plant']);?></td>
		<td class="table_content_1"><?=$grpofg_header['do_no'];?></td>
		<td class="table_content_1"><?=$grpofg_header['grpo_no'];?></td>
		<td class="table_content_1"><?=$grpofg_header['grfg_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($grpofg_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data GR PO STO & GR FG Pastry/Cookies dr CK di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
