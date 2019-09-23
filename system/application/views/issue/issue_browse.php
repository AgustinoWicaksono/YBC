<?php
// die('Saat ini input issue ditutup untuk sementara hingga proses perbaikan data di kantor pusat selesai. <FORM><INPUT TYPE="button" VALUE="Kembali" onClick="history.go(-1);return true;"> </FORM>');

$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_issue_delete(url, id_issue_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Spoiled / Breakage / Lost dengan ID "' + id_issue_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('issue/browse_search', $form1);?>
<table width="1000" align="center" class ="table_border_1">
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
    <td width="130"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <tr>
    <td colspan="40" ><strong>Status</strong>      
             <?=form_dropdown('status', $status, $data['status'], 'class="input_text"');?> Records per page : <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?></td>
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
<?=form_open('issue/delete_multiple_confirm', $form2);?>
<table width="1000"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="30" class="table_header_1">&nbsp;</td>
	<td width="100" class = "table_header_1"><strong>Action </strong></td>
	<th width=200 class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="250" class = "table_header_1" align="center"><strong>Issue No<br /> <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="300" class="table_header_1" align="center" ><strong>Posting Date<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="150" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
	 <td width="30" class="table_header_1">Log</td>
  </tr>
  <?php
 
if($data['issue_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['issue_headers']->result_array() as $issue_header):
		$issue_header['status_string'] = ($issue_header['status'] == '2') ? 'Approved' : 'Not Approved';
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>
 
    <td class=""><?=form_checkbox('id_issue_header['.$i.']', $issue_header['id_issue_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('issue/printpdf/'.$issue_header['id_issue_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?><?=anchor_image('issue/edit/'.$issue_header['id_issue_header'].'/'.$issue_header['item_group_code'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> <?=anchor_image('issue/edit/'.$issue_header['id_issue_header'].'/'.$issue_header['item_group_code'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?> <?php if($issue_header['status'] != "2") : ?><a href="#" onClick='confirm_issue_delete("<?=site_url('issue/delete/'.$issue_header['id_issue_header']);?>", "<?=$issue_header['id_issue_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	   <td class = ""><?=$issue_header['id_issue_header'];?></td>
	   <td class = ""><?=$issue_header['material_doc_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($issue_header['posting_date']));?></td>
	<td><?=$issue_header['status_string'];?></td>
    <td align="center"><?php $log=$issue_header['back'];
		$po=$issue_header['material_doc_no'];
		if ($log==0 && $po !='' && $po !='C')
		{
			echo "Integrated";
		}else if ($log==1 && ($po =='' || $po =='C'))
		{
			echo "Not Integrated";
		}else if ($log==0 &&  $po =='C')
		{
			echo "Close Document";
		}
		?></td>
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
<?=form_open_multipart('issue/file_import');?>
<table width="1000" align="center" class ="table_border_1">
  <tr>
    <td width="220">&nbsp;</td>
    <td width="330" >&nbsp;</td>
    <td width="354"  colspan="3" class="space"><?=anchor('issue/input', 'Add New Good Issue');?></td>
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
