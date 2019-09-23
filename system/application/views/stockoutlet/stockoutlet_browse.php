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
	function confirm_stockoutlet_delete(url, id_stockoutlet_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Stock Opname dengan ID "' + id_stockoutlet_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="1000" align="center" class ="table_border_1">
<?=form_open('stockoutlet/browse_search', $form1);?>
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?> <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?> <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?>    </td>
    <td width="399"><strong>Posting Date From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
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
    <td width="130"><?=form_submit($this->config->item('button_search'), 'Search');?>
    <a href="#" onclick="window.open('<?=base_url();?>help/Stock Opname.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
    <img src="<?=base_url();?>images/help.png"></a></td>
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
    <td width="40" class="table_header_1">&nbsp;</td>
	<td width="90" class = "table_header_1"><strong>Action</strong></td>
	<th width="250" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="230" class = "table_header_1" align="center"><strong>Material Doc No<br /> <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="200" class="table_header_1" align="center" ><strong>Posting Date<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="200" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>

  </tr>
  <?=form_open('stockoutlet/delete_multiple_confirm', $form2);?>
  <?php
if($data['stockoutlet_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['stockoutlet_headers']->result_array() as $stockoutlet_header):
		$stockoutlet_header['status_string'] = ($stockoutlet_header['status'] == '2') ? 'Approved' : 'Not Approved';
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>

    <td class=""><?=form_checkbox('id_stockoutlet_header['.$i.']', $stockoutlet_header['id_stockoutlet_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('stockoutlet/edit/'.$stockoutlet_header['id_stockoutlet_header'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?> <?php if($stockoutlet_header['status'] == 1) : ?><a href="#" onClick='confirm_stockoutlet_delete("<?=site_url('stockoutlet/delete/'.$stockoutlet_header['id_stockoutlet_header']);?>", "<?=$stockoutlet_header['id_stockoutlet_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<td class="table_content_1" nowrap="nowrap"><?=$stockoutlet_header['plant'].'03';?><?=date("ymd", strtotime($stockoutlet_header['posting_date']));?><?=sprintf("%06d", $stockoutlet_header['id_stockoutlet_plant']);?></td>
        <td class = ""><?=$stockoutlet_header['material_doc_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($stockoutlet_header['posting_date']));?></td>
	<td><?=$stockoutlet_header['status_string'];?></td>

  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="9"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?>
<?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?>
<?=form_submit($this->config->item('button_save_to_excel'), 'Export data yang dipilih');?>
</td>
</tr>
</table>
<?=form_close();?>
<?php 
$tglakhirposting = $this->m_general->posting_date_select_max();
$tglposting=strtotime($tglakhirposting);

$swbipaddress=@$_SERVER['REMOTE_ADDR'];
$islocal=false;
if ((strpos("###".$swbipaddress,"192.168.")>0)||(strpos("###".$swbipaddress,"172.16.")>0)) $islocal=true;


if (($islocal==TRUE)||(date('N',$tglposting)==7)||(date("Y-m-t",$tglposting)==date('Y-m-d',$tglposting))){
?>
<?=form_open_multipart('stockoutlet/file_import');?>
<table width="1000" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (XLS Excel File)</strong> </td>
	<td width="330" ><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?>
     <?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
	 <td width="354"  colspan="3" class="space">
      <?=anchor('stockoutlet/input', 'Add New Stock Opname');?>
     </td>
  </tr>
</table>
<?php } else { 
	echo "<p style=\"text-align:center;color:#778899;\"><b>Info:</b> Fasilitas upload Excel otomatis akan tersedia saat <i>Weekly Opname</i>.<br />Sedangkan untuk <i>Daily Opname</i>, mohon gunakan fasilitas dari Web untuk mempercepat pemrosesan data di dalam sistem.</p>";
}

?>
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
