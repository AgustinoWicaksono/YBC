&nbsp;<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_grsto_delete(url, id_grsto_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Goods Receipt Antar Outlet dengan ID "' + id_grsto_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('grsto/browse_search', $form1);?>
<table width="1150" align="center" class ="table_border_1">
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
    <td width="120"><?=form_submit($this->config->item('button_search'), 'Search');?></td>
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
<?=form_open('grsto/delete_multiple_confirm', $form2);?>
<table width="1250"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="18" class="table_header_1">&nbsp;</td>
	<td width="56" class = "table_header_1"><strong>Action</strong></td>
	<th width="100" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="110" class = "table_header_1" align="center"><strong>Transfer In No<br />
     <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="100" class = "table_header_1" align="center" ><strong>Store Room Request(SR) No<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="110" class="table_header_1" align="center"><strong>Transfer Slip No<br />
     <?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="140" class="table_header_1" align="center"><strong>Delivery Outlet <br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<th width="60" class="table_header_1" >Delivery Date<br /><?=anchor_image($sort_link['hy'],'A-Z', 'panahbawah.jpg');?> <?=anchor_image($sort_link['hz'],'Z-A', 'panahatas.jpg');?></th>
    <td width="60" class="table_header_1" align="center" ><strong>Posting Date<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="80" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['gy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['gz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
	
    <td width="100" class ="table_header_1" align="center"><strong>User<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="100" class ="table_header_1" align="center"><strong>Approved by<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="150" class ="table_header_1" align="center"><strong>Last Modified<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
  <td width="40" class ="table_header_1" align="center"><strong>Cancel</strong></td>
  </tr>
  <?php
if($data['grsto_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['grsto_headers']->result_array() as $grsto_header):
		$grsto_header['status_string'] = ($grsto_header['status'] == '2') ? 'Approved' : 'Not Approved';
        if($this->m_grsto->grsto_is_data_cancelled($grsto_header['id_grsto_header']))
           $grsto_header['cancel_status'] = 'Y';
        else
           $grsto_header['cancel_status'] = 'N';
?>

  <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>
  <td class=""><?=form_checkbox('id_grsto_header['.$i.']', $grsto_header['id_grsto_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('grsto/printpdf/'.$grsto_header['id_grsto_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?><?=anchor_image('grsto/edit/'.$grsto_header['id_grsto_header'], $this->lang->line('edit'), 'edit.png', 'height="20" width="20"');?> <?php  if($grsto_header['status'] == 1) : ?><a href="#" onClick='confirm_grsto_delete("<?=site_url('grsto/delete/'.$grsto_header['id_grsto_header']);?>", "<?=$grsto_header['id_grsto_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<!--td class="table_content_1" nowrap="nowrap"><?//=$grsto_header['plant'].'05';?><?//=date("ymd", strtotime($grsto_header['posting_date']));?><?//=sprintf("%06d", $grsto_header['id_grsto_plant']);?></td-->
    <td class =""><?=$grsto_header['id_grsto_header'];?></td>
    <td class =""><?=$grsto_header['grsto_no'];?></td>
    <td class = ""><?=$grsto_header['po_no'];?></td>
	<td class = ""><?=$grsto_header['no_doc_gist'];?></td>
	<td class = ""><?=$grsto_header['delivery_plant'];?><?=" - ";?><?=$grsto_header['delivery_plant_name'];?></td>
	<td><?php if(!empty($grsto_header['delivery_date'])) : ?><?=$this->l_general->sqldate_to_date($grsto_header['delivery_date']);?><?php endif; ?></td>
    <td class = ""><?=date("d-m-Y", strtotime($grsto_header['posting_date']));?></td>
	<td><?=$grsto_header['status_string'];?></td>
	
    <?php
	$id=$grsto_header['id_user_input'];
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	?>
    <td ><?php echo $name;?></td>
	<td ><?php if ($grsto_header['status']== 2){
	$id=$grsto_header['id_user_approved'];
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
    echo $name; } else {echo "-";}?></td>
    <td ><?=$grsto_header['lastmodified'];?></td>
	<td align="center"><?php $log=$grsto_header['back'];
		$po=$grsto_header['grsto_no'];
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
?><tr><td class="table_content_1" colspan="14"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('grsto/file_import');?>
<table width="1250" align="center" class ="table_border_1">
  <tr>
    <td width="220" >&nbsp;</td>
    <td width="330" >&nbsp;</td>
    <td width="354"  colspan="3" class="space"><?=anchor('grsto/input', 'Add New Goods Receipt');?></td>
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
