<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_stdstock_delete(url, id_stdstock_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Goods Receipt PO from Vendor dengan ID "' + id_stdstock_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="1000" align="center" class ="table_border_1">
<?=form_open('stdstock/browse_search', $form1);?>
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?> <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?> <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?>    </td>
    <td width="399"><strong>Delivery Date Form  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_from'
					});
				
		</script> To <?=form_input('date_to', $data['date_to'], 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'date_to'
					});
				
					</script>
    </td>
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <tr>
    <td colspan="40" ><strong>Status</strong>      
             <?=form_dropdown('status', $status, $data['status'], 'class="input_text"');?> Records per page : <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?></td>
  </tr>
	<?=form_close();?>
</table>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>

<table width="1000"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="18" class="table_header_1">&nbsp;</td>
	<td width="56" class = "table_header_1"><strong>Action</strong></td>
	<th width="116" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="160" class = "table_header_1" align="center"><strong>Purchase Requesition No<br /> <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="159" class = "table_header_1" align="center" ><strong>Created Date<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></strong></td>
	
    <td width="116" class="table_header_1" align="center" ><strong>Delivery Date<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></td>
    <td width="116" class="table_header_1" align="center" ><strong>Request Reason<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></td>
	<td width="100" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
  <td> PRINT </td>

  </tr>
  <?=form_open('stdstock/delete_multiple_confirm', $form2);?>
  <?php
if($data['stdstock_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['stdstock_headers']->result_array() as $stdstock_header):
		$stdstock_header['status_string'] = ($stdstock_header['status'] == '2') ? 'Approved' : 'Not Approved';
?>

  <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>
  <td class=""><?=form_checkbox('id_stdstock_header['.$i.']', $stdstock_header['id_stdstock_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('stdstock/printpdf/'.$stdstock_header['id_stdstock_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?><?=anchor_image('stdstock/edit/'.$stdstock_header['id_stdstock_header'].'/'.$stdstock_header['request_reason'].'/'.$stdstock_header['item_group_code'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> <?=anchor_image('stdstock/edit/'.$stdstock_header['id_stdstock_header'].'/'.$stdstock_header['request_reason'].'/'.$stdstock_header['item_group_code'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?> <?php if($stdstock_header['status'] == 1) : ?><a href="#" onClick='confirm_stdstock_delete("<?=site_url('stdstock/delete/'.$stdstock_header['id_stdstock_header']);?>", "<?=$stdstock_header['id_stdstock_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<td class="table_content_1" nowrap="nowrap"><?=$stdstock_header['plant'];?><?=date("ymd", strtotime($stdstock_header['delivery_date']));?><?=sprintf("%06d", $stdstock_header['id_stdstock_plant']);?></td>
    <td class = ""><?=$stdstock_header['pr_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($stdstock_header['created_date']));?></td>
    <td class = ""><?=date("d-m-Y", strtotime($stdstock_header['delivery_date']));?></td>
    <td class = ""><?=$stdstock_header['request_reason'];?></td>
	<td><?=$stdstock_header['status_string'];?></td>
	<td><?=anchor_image('stdstock/printpdf/'.$stdstock_header['id_stdstock_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?> </td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="9"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
<?=form_close();?>

</table>
<table width="1000" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (Xls Excel File)</strong> </td>
	<?=form_open_multipart($this->uri->uri_string());?>
    <td width="312" ><?=form_upload('file', $data['file'], 'class="input_text"');?> <input type="button" value="Upload" /></td>
	<?=form_close();?>
    <td width="354"  colspan="3" class="space"><?=anchor('stdstock/input', 'Add New Request Tambahan untuk Standard Stock');?></td>
  </tr>
</table>
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
</table>
<table class="table-browse" width="100%" align="center">
<tr>
<td>
<?=anchor('home/home', $this->lang->line('button_back'));?>
</td>
</tr>
</table>