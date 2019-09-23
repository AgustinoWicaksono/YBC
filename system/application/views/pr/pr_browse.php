<?php
$this->load->helper('form');
$this->load->library('l_pagination');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
$con=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));

?>
<script language="javascript">
	function confirm_pr_delete(url, id_pr_header) {
		var m = confirm('Apakah Anda setuju untuk menghapus data Store Room Requition (SR) dengan ID "' + id_pr_header + '" dan data item-item barang di dalamnya? Data yang sudah dihapus tidak bisa dimunculkan kembali.');
		if(m) {
			location.href=url;
		}
	}
</script>


<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open('pr/browse_search', $form1);?>
<table width="1000" align="center" class ="table_border_1">
  <tr>
    <td width="490" ><strong>Search by</strong>
      <?=form_dropdown('field_name', $field_name, $data['field_name'], 'class="input_text"');?> <?=form_dropdown('field_type', $field_type, $data['field_type'], 'class="input_text"');?> <?=form_input('field_content', $data['field_content'], 'class="input_text" size="10"');?>    </td>
    <td width="420"><strong>Delivery Date From  <?=form_input('date_from', $data['date_from'], 'class="input_text" size="10"');?> <script language="JavaScript">
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
    <td width="140">
    <?=form_submit($this->config->item('button_search'), 'Search');?></td>
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
<?=form_open('pr/delete_multiple_confirm', $form2);?>
<table width="1200"  align="center" class ="table_border_1">
  <tr bgcolor="#999999">
    <td width="18" class="table_header_1">&nbsp;</td>
	<td width="80" class = "table_header_1"><strong>Action</strong></td>
	<th width="160" class="table_header_1"> ID<br /> <?=anchor_image($sort_link['ay'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['az'],'Z-A', 'panahatas.jpg');?></th>
    <td width="160" class = "table_header_1" align="center"><strong>Purchase Request (PR) No<br /> <?=anchor_image($sort_link['by'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['bz'], 'Z-A','panahatas.jpg');?> </strong></td>
    <td width="159" class = "table_header_1" align="center" ><strong>Created Date<br /><?=anchor_image($sort_link['cy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['cz'],'Z-A', 'panahatas.jpg');?></strong></td>

    <td width="116" class="table_header_1" align="center" ><strong>Delivery Date<br /><?=anchor_image($sort_link['dy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['dz'],'Z-A', 'panahatas.jpg');?></td>
    <td width="116" class="table_header_1" align="center" ><strong>Request Reason<br /><?=anchor_image($sort_link['ey'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['ez'],'Z-A', 'panahatas.jpg');?></td>
	<td width="100" class ="table_header_1" align="center"><strong>Status<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="150" class ="table_header_1" align="center"><strong>Created By<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="150" class ="table_header_1" align="center"><strong>Approved by<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="230" class ="table_header_1" align="center"><strong>Last Modified<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
	<td width="230" class ="table_header_1" align="center"><strong>PO Print<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
	<td width="230" class ="table_header_1" align="center"><strong>PO<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
    <td width="230" class ="table_header_1" align="center"><strong>Log<br /><?=anchor_image($sort_link['fy'],'A-Z', 'panahbawah.jpg');?><?=anchor_image($sort_link['fz'],'Z-A', 'panahatas.jpg');?></strong> <strong></strong></td>
  </tr>
  <?php
if($data['pr_headers'] !== FALSE) :
	$i = 1;
	foreach ($data['pr_headers']->result_array() as $pr_header):
		$pr_header['status_string'] = ($pr_header['status'] == '2') ? 'Approved' : 'Not Approved';
?>

  <?php if($i % 2) : ?>

  <tr class="table_row_1">

<?php else : ?>

  <tr class="table_row_2">

<?php endif; ?>
  <td class=""><?=form_checkbox('id_pr_header['.$i.']', $pr_header['id_pr_header'], FALSE);?></td>
	<td class="" align="left" nowrap="nowrap"><?=anchor_image('pr/printpdf/'.$pr_header['id_pr_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?><?=anchor_image('pr/edit/'.$pr_header['id_pr_header'].'/'.$pr_header['request_reason'].'/'.$pr_header['item_group_code'].'/1', 'Ubah dengan Item berdasarkan ID', 'edit.png', 'height="20" width="20"');?> <?=anchor_image('pr/edit/'.$pr_header['id_pr_header'].'/'.$pr_header['request_reason'].'/'.$pr_header['item_group_code'].'/2', 'Ubah dengan Item berdasarkan Nama', 'view.png', 'height="20" width="20"');?> <?php if($pr_header['status'] == 1) : ?><a href="#" onClick='confirm_pr_delete("<?=site_url('pr/delete/'.$pr_header['id_pr_header']);?>", "<?=$pr_header['id_pr_header'];?>")'><img src="<?=base_url().'images/'.$this->session->userdata('template').'/'.$this->session->userdata('lang_name').'/';?>delete.png" height="20" width="20" /></a><?php endif; ?></td>
	<!--td class="table_content_1" nowrap="nowrap"><?//=$pr_header['plant'].'09';?><?//=date("ymd", strtotime($pr_header['created_date']));?><?//=sprintf("%06d", $pr_header['id_pr_plant']);?></td-->
    <td class = ""><?=$pr_header['id_pr_header'];?></td>
    <td class = ""><?=$pr_header['pr_no'];?></td>
	<td class = ""><?=date("d-m-Y", strtotime($pr_header['created_date']));?></td>
    <td class = ""><?=date("d-m-Y", strtotime($pr_header['delivery_date']));?></td>
    <td class = ""><?=$pr_header['request_reason'];?></td>
	<td><?=$pr_header['status_string'];?></td>
     <?php
	$id=$pr_header['id_user_input'];
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	?>
    <td ><?php echo $name;?></td>
	<td ><?php if ($pr_header['status']== 2){
	$id=$pr_header['id_user_approved'];
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	echo $name; } else {echo "-";}?></td>
    <td ><?=$pr_header['lastmodified'];?></td>
	<td class = ""><?=anchor_image('pr/printpdfPO/'.$pr_header['id_pr_header'], 'Print Transaksi', 'print.png', 'height="20" width="20"');?></td>
 <td ><?php 
 
 $rq=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT A.DocEntry FROM POR1 A
JOIN PRQ1 B ON A.BaseRef=B.DocEntry
WHERE B.DocEntry='$pr_header[pr_no]'"));
//$DOC=mssql_fetch_array($QUERY);
	sqlsrv_close($con);

echo $rq['DocEntry'];
 ?></td>
  <td align="center"><?php $log=$pr_header['back'];
		$po=$pr_header['pr_no'];
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
?><tr><td class="table_content_1" colspan="14"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', --$i);?>
<?=form_submit($this->config->item('button_delete'), 'Hapus data yang dipilih');?>
<?=form_submit($this->config->item('button_save_to_excel'), 'Export data yang dipilih');?>
</td>
</tr>
</table>
<?=form_close();?>
<?=form_open_multipart('pr/file_import');?>
<table width="1000" align="center" class ="table_border_1">
  <tr>
    <td width="220" >&nbsp;</td>
    <td width="330" >&nbsp;</td>
    <td width="354"  colspan="3" class="space"><?=anchor('pr/input', 'Add New PR');?></td>
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
