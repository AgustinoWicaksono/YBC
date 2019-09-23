<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
?>
<script language="javascript">
	function confirm_gistonew_dept_delete(url, id_gistonew_dept_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Goods Issue Antar Department  dengan ID "' + id_gistonew_dept_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('gistonew_dept/browse_search', $form1);?>
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

<?=form_open('gistonew_dept/delete_multiple_confirm', $form2);?>
<table width="1540"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="18" class="table_header_1">&nbsp;</td>
	<td width="80" class = "table_header_1"><strong>Action</strong></td>
	<th width="130" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="150" class = "table_header_1" align="center"><strong>Transfer Slip Number <br /> <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="154" class = "table_header_1" align="center" ><strong>Store Room Request (SR) Number<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></strong></td>
	<td width="116" class="table_header_1" align="center" >Posting Date<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="150" class="table_header_1" align="center" ><strong>Transfer Out To  Outlet</strong><br />
    <?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></td>
	<td width="100" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <th width="150" class="table_header_1">Created By</th>
    <th width="150" class="table_header_1">Approved by</th>
	<td width="60" class ="table_header_1" align="center"><strong>Cancel</strong></td>
    <th width="100" class="table_header_1">Last Modified</th>
    
  </tr>
  <?php
if($data['gistonew_dept_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['gistonew_dept_headers']->result_array() as $gistonew_dept_header):
		$gistonew_dept_header['status_string'] = ($gistonew_dept_header['status'] == '2') ? 'Approved' : 'Not Approved';
        if($this->m_gistonew_dept->gistonew_dept_is_data_cancelled($gistonew_dept_header['id_gistonew_dept_header']))
           $gistonew_dept_header['cancel_status'] = 'Y';
        else
           $gistonew_dept_header['cancel_status'] = 'N';
?>

   <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>
  <tr class="table_row_2">

<?php endif; ?>
<?php
$outlet=$gistonew_dept_header['receiving_plant'];
$re=mysql_fetch_array(mysql_query("SELECT OUTLET,OUTLET_NAME1 FROM m_outlet where TRANSIT='$outlet'"));

?>
    <td class=""><?=form_checkbox('id_gistonew_dept_header['.$i.']', $gistonew_dept_header['id_gistonew_dept_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('gistonew_dept/printpdf/'.$gistonew_dept_header['id_gistonew_dept_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?><?=anchor_image('gistonew_dept/edit/'.$gistonew_dept_header['id_gistonew_dept_header'].'/'.$gistonew_dept_header['receiving_plant'].'/'.$gistonew_dept_header['item_group_code'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> <?=anchor_image('gistonew_dept/edit/'.$gistonew_dept_header['id_gistonew_dept_header'].'/'.$gistonew_dept_header['receiving_plant'].'/'.$gistonew_dept_header['item_group_code'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?> <?php if($gistonew_dept_header['status'] == 1) : ?><a href="#" onClick='confirm_gistonew_dept_delete("<?=site_url('gistonew_dept/delete/'.$gistonew_dept_header['id_gistonew_dept_header']);?>", "<?=$gistonew_dept_header['id_gistonew_dept_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<td class="table_content_1" nowrap="nowrap"><?=$gistonew_dept_header['plant'].'04';?><?=date("ymd", strtotime($gistonew_dept_header['posting_date']));?><?=sprintf("%06d", $gistonew_dept_header['id_gistonew_dept_plant']);?></td>
    <td class =""><?=$gistonew_dept_header['gistonew_dept_no'];?></td>
    <td class = ""><?=$gistonew_dept_header['po_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($gistonew_dept_header['posting_date']));?></td>
	<td class = ""><?=$re['OUTLET'];?>-<?=$re['OUTLET_NAME1'];?></td>
	<td><?=$gistonew_dept_header['status_string'];?></td>
		<?php
			$id=$gistonew_dept_header['id_user_input'];
			$r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
			$name=$r['admin_realname'];
		?>
		<td ><?php echo $name;?></td>
		<td ><?php if ($gistonew_dept_header['status']== 2){
		  $id=$gistonew_dept_header['id_user_approved'];
		  $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
		  $name=$r['admin_realname'];
		  echo $name; }
          else {echo "-";}?></td>
	<td align="center"><?=$gistonew_dept_header['cancel_status'];?></td>
	<td><?=$gistonew_dept_header['lastmodified'];?></td>
	
  </tr>
  <?php
		$i++;
	endforeach;
endif;
?><tr><td class="table_content_1" colspan="13"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?><?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?></td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('gistonew_dept/file_import');?>
<table width="1200" align="center" class ="table_border_1">
  <tr>
    <td width="220" >&nbsp;</td>
    <td width="330" >&nbsp;</td>
    <td width="354"  colspan="3" class="space"><?=anchor('gistonew_dept/input', 'Add New Goods Issue');?></td>
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
