<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_twtsnew_delete(url, id_twtsnew_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Master Paket  dengan ID "' + id_twtsnew_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('twtsnew/browse_search', $form1);?>
<table width="1200" align="center" class ="table_border_1">
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?>
      <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?>
      <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?>
    </td>
    <td width="130"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
  </tr>
   <tr>
    <td colspan="40" >
	<strong>Status</strong><?=form_dropdown('status', $status, $data['status'], 'class="input_text"');?> 
		Records per page : <?=form_input('limit', $data['limit'], 'class="input_text" size="2"');?></td>
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
<?=form_open('twtsnew/delete_multiple_confirm', $form2);?>
<table width="1200"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="10" class="table_header_1">&nbsp;</td>
	<td width="30" class = "table_header_1"><strong>Action</strong></td>
	<td width="30" class = "table_header_1"><strong>ID</strong><br /> <?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="80" class="table_header_1" align="center" ><strong> Date</strong><br /> <?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></td>
    <td width="150" class = "table_header_1" align="center"><strong> Item No<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="250" class="table_header_1" align="center" ><strong> Item Description<br /><?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'],'Z-A', 'panahatas.jpg');?></strong></td>
    <td width="80" class="table_header_1" align="center" ><strong> Quantity</strong></td>
    <td width="250" class="table_header_1" align="center" ><strong> Status<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></strong></td>
     <!--td width="150" class = "table_header_1" align="center"><strong>Paket Batch Number </strong></td-->
    <th width="150" class="table_header_1" align="center" >Created By</th>
    <th width="150" class="table_header_1" align="center" >Approved by</th>
      <th width="100" class="table_header_1">Receipt Number</th>
      <th width="100" class="table_header_1">Issue Number</th>
	<td width="80" class="table_header_1" align="center" ><strong> Log</strong></td>
  </tr>
  <?php
if($data['twtsnew_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['twtsnew_headers']->result_array() as $twtsnew_header):
	$twtsnew_header['status_string'] = ($twtsnew_header['status'] == '2') ? 'Approved' : 'Not Approved';
        if($this->m_twtsnew->twtsnew_is_data_cancelled($twtsnew_header['id_grpodlv_header']))
           $twtsnew_header['cancel_status'] = 'Y';
        else
           $twtsnew_header['cancel_status'] = 'N';
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>

    <td class=""><?=form_checkbox('id_twtsnew_header['.$i.']', $twtsnew_header['id_twtsnew_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap">
    <?=anchor_image('twtsnew/edit/'.$twtsnew_header['id_twtsnew_header'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?>
    <?=anchor_image('twtsnew/edit/'.$twtsnew_header['id_twtsnew_header'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?> 
	<?php if($twtsnew_header['status'] == 1) : ?>
    <a href="#" onClick='confirm_twtsnew_delete("<?=site_url('twtsnew/delete/'.$twtsnew_header['id_twtsnew_header']);?>", "<?=$twtsnew_header['id_twtsnew_header'];?>")'>
    <img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?>
    </td>
	<td class = ""><?=$twtsnew_header['id_twtsnew_header'];?></td>
	<td class = ""><?=$twtsnew_header['last_update'];?></td>
	<td class = ""><?=$twtsnew_header['kode_paket'];?></td>
    <td class = ""><?=$twtsnew_header['nama_paket'];?></td>
    <td class = ""><?=number_format($twtsnew_header['quantity_paket'], 2, '.', '').' '.$twtsnew_header['uom_paket'];?></td>
	<td><?=$twtsnew_header['status_string'];?></td>
	<?php
			$id=$twtsnew_header['id_user_input'];
			$r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
			$name=$r['admin_realname'];
		?>
		<td ><?php echo $name;?></td>
		<td ><?php if ($twtsnew_header['status']== 2){
		  $id=$twtsnew_header['id_user_approved'];
		  $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
		  $name=$r['admin_realname'];
		  echo $name; }
          else {echo "-";}?></td>
	<td align="center"><?= $twtsnew_header['gr_no'];?></td>
	<td align="center"><?= $twtsnew_header['gi_no'];?></td>
    <!--td class=""><?=$twtsnew_header['num'];?> </td-->
	<td align="center"><?php $log=$twtsnew_header['back'];
		$po=$twtsnew_header['gr_no'];
		$pi=$twtsnew_header['gi_no'];
		if ($log==0 && $po !='' && $po !='C')
		{
			echo "Integrated";
		}else if ($log==1 && ($po =='' || $po =='C' || $pi=''))
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
?><tr><td class="table_content_1" colspan="13"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('twtsnew/file_import');?>
<table width="1200" align="center" class ="table_border_1">
  <tr>
    <td width="220" bgcolor="#FFCC00"><strong>Upload File (XLS Excel File)</strong> </td>
    <td width="330" ><?=form_upload('userfile', $data['userfile'], 'class="input_text"');?></td>
    <td width="354"  colspan="4" class="space"><?=anchor('twtsnew/input', 'Add New Whole to Slice');?></td>
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
