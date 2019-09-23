<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_trend_utility_delete(url, id_trend_utility_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Trend Utility dengan ID "' + id_trend_utility_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('trend_utility/browse_search', $form1);?>
<table width="1150" align="center" class ="table_border_1">
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?> <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?> <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?></td>
      <td width="399">Posting Date From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
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
    <td width="120"><?=form_submit($this->config->item('button_search'), 'Search');?>
    <a href="#" onclick="window.open('<?=base_url();?>help/Trend utility.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
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
<?=form_open('trend_utility/delete_multiple_confirm', $form2);?>
<table width="1180"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="18" class="table_header_1">&nbsp;</td>
	<td width="56" class = "table_header_1"><strong>Action</strong></td>
	<th width="125" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
	<td width="116" class="table_header_1" align="center" >Document No.<br /><?=anchor_image($sort_link['hy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['hz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="116" class="table_header_1" align="center" >Posting Date<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></td>
    <td width="159" class = "table_header_1" align="center" ><strong>KWH Awal<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></strong></td>
    <td width="159" class = "table_header_1" align="center" ><strong>KWH Akhir<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></strong></td>
    <td width="159" class = "table_header_1" align="center" ><strong>KWH Total<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="124" class="table_header_1" align="center"><strong>Jam Pencatatan<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="120" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
	<td width="116" class="table_header_1" align="center" >Document No Cancellation.<br /><?=anchor_image($sort_link['iy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['iz'],'Z-A', 'panahatas.jpg');?></td>

  </tr>
  <?php
if($data['trend_utilitys'] !== FALSE) :
	$i = 1;
	foreach ($data['trend_utilitys']->result_array() as $trend_utility):
		$trend_utility['status_string'] = ($trend_utility['status'] == '2') ? 'Approved' : 'Not Approved';
?>

  <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>
  <td class=""><?=form_checkbox('id_trend_utility_header['.$i.']', $trend_utility['id_trend_utility_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('trend_utility/edit/'.$trend_utility['id_trend_utility_header'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?>
    <?php if($trend_utility['status'] == 1) : ?><a href="#" onClick='confirm_trend_utility_delete("<?=site_url('trend_utility/delete/'.$trend_utility['id_trend_utility_header']);?>", "<?=$trend_utility['id_trend_utility_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<td class="table_content_1" nowrap="nowrap"><?=$trend_utility['plant'].'12';?><?=date("ymd", strtotime($trend_utility['posting_date']));?><?=sprintf("%06d", $trend_utility['id_trend_utility_plant']);?></td>
    <td class = "" align="center"><?=$trend_utility['trend_utility_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($trend_utility['posting_date']));?></td>
    <td class ="" align="right" ><?=number_format($trend_utility['kwh_awal'], 0, '.', ',');?></td>
    <td class ="" align="right"><?=number_format($trend_utility['kwh_akhir'], 0, '.', ',');?></td>
    <td class ="" align="right"><?=number_format($trend_utility['kwh_total'], 0, '.', ',');?></td>
    <td class = "" align="center"><?=$trend_utility['jam_pencatatan'];?></td>
	<td><?=$trend_utility['status_string'];?></td>
    <td class = "" align="center"><?=$trend_utility['material_docno_cancellation'];?></td>

  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="11"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('trend_utility/file_import');?>
<table width="1180" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (XLS Excel File)</strong> </td>
    <td width="330" ><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?> <?=form_submit($this->config->item('button_upload'), 'Upload');?></td>
    <td width="354"  colspan="3" class="space"><?=anchor('trend_utility/input', 'Add New Trend Utility');?></td>
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
