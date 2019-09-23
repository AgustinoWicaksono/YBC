<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('opnd/delete_multiple_execute', $form1);?>
<h3>Apakah Anda setuju untuk menghapus data Master Item Opname Daily di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Periode</th>
	</tr>
<?php
if($data['opnd_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['opnd_headers'] as $opnd_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_opnd_header['.$i.']', $opnd_header['id_opnd_header']);?><?=$opnd_header['id_opnd_header'];?></td>
		<td class="table_content_1"><?=$opnd_header['periode'];?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Konfirmasi penghapusan data Goods Issue to Cost Center di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>
<?=form_close();?>
</table>
