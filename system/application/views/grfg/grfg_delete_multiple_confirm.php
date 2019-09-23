<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('grfg/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Goods Receipt FG Outlet di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Goods Receipt No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['grfg_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grfg_headers'] as $grfg_header):
		if($grfg_header['status'] != 2) :
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_grfg_header['.$i.']', $grfg_header['id_grfg_header']);?><?=$grfg_header['plant'];?><?=date("ymd", strtotime($grfg_header['posting_date']));?><?=sprintf("%06d", $grfg_header['id_grfg_plant']);?></td>
		<td class="table_content_1"><?=$grfg_header['grfg_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($grfg_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
		endif;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Receipt FG Outlet di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
