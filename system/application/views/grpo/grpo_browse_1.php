<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_grpo_delete(url, id_grpo_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Goods Receipt PO from Vendor dengan ID "' + id_grpo_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<table width="1150" border="0" align="center">
<?=form_open('grpo/browse_search', $form1);?>
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
    <td width="95"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
  <tr>
    <td colspan="40" ><strong>Status</strong>
             <?=form_dropdown('status', $status, $data['status'], 'class="input_text"');?> Records per page : <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?></td>
  </tr>
	<?=form_close();?>
<table class="table-browse" width="100%" align="center">
<tr>
	<td colspan="5" align="center">Jumlah data: <?=$total_rows;?></td>
</tr>
<tr>
	<td colspan="5" align="center"><?=$this->pagination->create_links();?></td>
</tr>
</table>
</table>
<table width="1150" border="0" align="center">
	<tr class="table_header_1">
		<th>&nbsp;</th>
		<th width="70" class = "table_header_1">Action</th>
		<th width="200" class="table_header_1">ID<br /><?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
		<th width="400" class = "table_header_1">Goods Receipt  No.<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?></th>
			<th width="400" class = "table_header_1">Purchase Order No.<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="300" class="table_header_1">Vendor Code<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></th>
			<th width="480" class ="table_header_1">Vendor Name<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></th>
			<th width="250" class="table_header_1" >Posting Date<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="180" class ="table_header_1">Status<br /><?=anchor_image($sort_link['gy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['gz'],'Z-A', 'panahatas.jpg');?></th>
		<th width="40" class ="table_header_1">Cancel</th>
  </tr>
<?=form_open('grpo/delete_multiple_confirm', $form2);?>
<?php
if($data['grpo_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grpo_headers']->result_array() as $grpo_header):
		$grpo_header['status_string'] = ($grpo_header['status'] == '2') ? 'Approved' : 'Not Approved';
        if($this->m_grpo->grpo_is_data_cancelled($grpo_header['id_grpo_header']))
           $grpo_header['cancel_status'] = 'Y';
        else
           $grpo_header['cancel_status'] = 'N';
?>
<?php if($i % 2) : ?>
  <tr class="table_row_1">
<?php else : ?>
  <tr class="table_row_2">
<?php endif; ?>
		<td><?=form_checkbox('id_grpo_header['.$i.']', $grpo_header['id_grpo_header'], FALSE);?></td>
		<td align="left" nowrap="nowrap"><?=anchor_image('grpo/edit/'.$grpo_header['id_grpo_header'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?> <?php if($grpo_header['status'] == 1) : ?><a href="#" onClick='confirm_grpo_delete("<?=site_url('grpo/delete/'.$grpo_header['id_grpo_header']);?>", "<?=$grpo_header['id_grpo_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
		<td class="table_content_1" nowrap="nowrap"><?=$grpo_header['plant'];?><?=date("ymd", strtotime($grpo_header['posting_date']));?><?=sprintf("%06d", $grpo_header['id_grpo_plant']);?></td>
		<td><?=$grpo_header['grpo_no'];?></td>
		<td><?=$grpo_header['po_no'];?></td>
		<td><?=$grpo_header['kd_vendor'];?></td>
		<td><?=$grpo_header['nm_vendor'];?></td>
		<td><?=date("d-m-Y", strtotime($grpo_header['posting_date']));?></td>
		<td><?=$grpo_header['status_string'];?></td>
		<td align="center"><?=$grpo_header['cancel_status'];?></td>
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="10"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
<?=form_close();?>
<?=form_open_multipart('grpo/file_import');?>
<table width="1150" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (Xls Excel File)</strong> </td>
	<?=form_open_multipart($this->uri->uri_string());?>
    <td width="312" ><?=form_upload('file', $data['file'], 'class="input_text"');?> <input type="button" value="Upload" /></td>
	<?=form_close();?>
    <td width="354" colspan="3" class="space"><?=anchor('grpo/input', 'Add New Goods Receipt');?></td>
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
