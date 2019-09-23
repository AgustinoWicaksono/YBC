<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_mpaket_delete(url, id_mpaket_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Master Paket  dengan ID "' + id_mpaket_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('mpaket/browse_search', $form1);?>
<table width="800" align="center" class ="table_border_1">
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?>
      <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?>
      <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?>
    </td>
    <td width="130"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <tr>
    <td colspan="2" align="left"><strong>Records per page : </strong><?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?></td>
    <td colspan="2" align="right">Jumlah data: <?=$total_rows;?></td>
  </tr>
</table>
<?=form_close();?>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
<?=form_open('mpaket/delete_multiple_confirm', $form2);?>
<table width="800"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="10" class="table_header_1">&nbsp;</td>
	<td width="30" class = "table_header_1"><strong>Action</strong></td>
    <td width="150" class = "table_header_1" align="center"><strong>BOM Item No<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="250" class="table_header_1" align="center" ><strong>BOM Item Description<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></strong></td>
     <!--td width="150" class = "table_header_1" align="center"><strong>Paket Batch Number </strong></td-->
    <td width="80" class="table_header_1" align="center" ><strong>BOM Quantity</strong></td>
  </tr>
  <?php
if($data['mpaket_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['mpaket_headers']->result_array() as $mpaket_header):
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>

    <td class=""><?=form_checkbox('id_mpaket_header['.$i.']', $mpaket_header['id_mpaket_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap">
    <?=anchor_image('mpaket/edit/'.$mpaket_header['id_mpaket_header'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?>
    <?=anchor_image('mpaket/edit/'.$mpaket_header['id_mpaket_header'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?>
    <!--a href="#" onClick='confirm_mpaket_delete("<?=site_url('mpaket/delete/'.$mpaket_header['id_mpaket_header']);?>", "<?=$mpaket_header['id_mpaket_header'];?>")'>
    <img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a-->
    </td>
    <td class = ""><?=$mpaket_header['kode_paket'];?></td>
    <td class = ""><?=$mpaket_header['nama_paket'];?></td>
    <!--td class=""><?php //$mpaket_header['num'];?> </td-->
    <td class = ""><?=number_format($mpaket_header['quantity_paket'], 2, '.', '').' '.$mpaket_header['uom_paket'];?></td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="9"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?php //echo form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('mpaket/file_import');?>
<table width="800" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (XLS Excel File)</strong> </td>
    <td width="330" ><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?></td>
    <td width="354"  colspan="3" class="space"><?=anchor('mpaket/input', 'Add New Paket');?></td>
  </tr>
</table>
<?=form_close();?>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>

<script language="javascript">
	function selectAll(){ 
//		t=document.form2.length;
//		document.write(t); 
		//for(i=1; i<t-1; i++)
		for(i=0; i < <?=$i;?>; i++)
			document.form2[i].checked=document.form2[<?=$i;?>].checked;
	}

/*	
	function selectAll(){
//		t=document.form2.length;
//		document.write(t); 
		//for(i=1; i<t-1; i++)
		for(i=0; i < <?=$total_rows;?>; i++)
			document.form2[i].checked=document.form2[<?=$total_rows;?>].checked;
	} 
		x=document.form2.length;
		document.write("Data = " + x); 
*/	
</script>
<table class="table-browse" width="100%" align="center">
<tr>
<td>
<?=anchor('home/home', $this->lang->line('button_back'));?>
</td>
</tr>
</table>
