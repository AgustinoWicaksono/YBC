<?php
// die('Saat ini input waste ditutup untuk sementara hingga proses perbaikan data di kantor pusat selesai. <FORM><INPUT TYPE="button" VALUE="Kembali" onClick="history.go(-1);return true;"> </FORM>');

$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<?=form_open('waste/file_export', $form1);?>
<h3>Apakah Anda setuju untuk meng-export data Spoiled / Breakage / Lost di bawah ini beserta data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.</h3>
<table class="table-browse">
	<tr>
		<th class="table_header_1">ID</th>
		<th class="table_header_1">Material Document No</th>
		<th class="table_header_1">Posting Date</th>
	</tr>
<?php
if($data['waste_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['waste_headers'] as $waste_header):
?>
	<tr>
		<td class="table_content_1"><?=form_hidden('id_waste_header['.$i.']', $waste_header['id_waste_header']);?><?=$waste_header['plant'];?><?=date("ymd", strtotime($waste_header['posting_date']));?><?=sprintf("%06d", $waste_header['id_waste_plant']);?></td>
		<td class="table_content_1"><?=$waste_header['material_doc_no'];?></td>
		<td class="table_content_1" align="center"><?=date("d-m-Y", strtotime($waste_header['posting_date']));?></td>
	</tr>
<?php
			$i++;
	endforeach;
endif;
?>
	<tr>
		<td colspan="6" align="center"><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_save_to_excel'), 'Konfirmasi export data Waste Material di atas');?> <?=form_button($this->config->item('button_back'), $this->lang->line('button_back'), 'onclick="javascript:history.go(-1)"');?></td>
	</tr>				
<?=form_close();?>
</table>
