<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
//$this->load->model('m_general');
$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
	<?php
	 $whs=$this->session->userdata['ADMIN']['storage_location'];
	 
    $mysqlcon = mysql_connect("192.168.0.55",$user_mysql,$pass_mysql);
	mysql_select_db($db_mysql,$mysqlcon);
	mysql_query("DELETE FROM m_mpaket_detail_temp WHERE whs='$whs'",$mysqlcon);
	//mysql_query("TRUNCATE TABLE m_mpaket_detail_temp");
	$br=mysql_fetch_array(mysql_query("SELECT branch FROM m_outlet WHERE OUTLET ='$whs'",$mysqlcon));
	$branch=$br['branch'];
	//echo '{'.$branch.'}';
//$gr=mysql_query("SELECT kode_paket,nama_paket FROM m_mpaket_header WHERE plant='$whs' AND (BRANCH='$branch' OR BRANCH='') AND kode_paket IN (SELECT MATNR FROM m_item)");
$gr=mysql_query("SELECT kode_paket,nama_paket FROM m_mpaket_header WHERE plant='WMSIASST' 
			    AND kode_paket IN (SELECT MATNR FROM m_item WHERE m_item.MATNR = m_mpaket_header.kode_paket)",$mysqlcon);

$kode_paket[0]='';
while($r=mysql_fetch_array($gr))
		{
			$kode_paket[$r['kode_paket']] = $r['kode_paket'].' - '.$r['nama_paket'];
		}
		//print_r($item);
	?>
 
  <tr>
    <td class="table_field_1"><strong>Item Produksi</strong></td>
		<td class="column_input"><?=form_dropdown('kode_paket', $item, $data['kode_paket'], ' data-placeholder="Pilih item..." class="chosen-select input_text" onChange="document.form1.submit();"');?></td>
	</tr>
    <?php
    if (!empty($data['kode_paket']))
	{
	?>
    <tr>
		<td class="table_field_1"><strong> Quantity</strong></td>
        <td class = "column_input" >
		<?php
		$b=sqlsrv_connect($host_sap,array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));
		
		$qty=sqlsrv_fetch_array(sqlsrv_query($b,"SELECT Qauntity as quantity_paket FROM OITT where Code = '$data[kode_paket]'"));
		//echo "{".$qty['quantity_paket']."}";
		//$data['produksi_header']['quantity_paket']=$qty['quantity_paket'];
		//echo $qty['quantity_paket']."(SELECT quantity_paket FROM m_mpaket_header WHERE plant='$whs' AND kode_paket = '$data[kode_paket]')";
		sqlsrv_close($b);
		mysql_close($mysqlcon);
		if(!empty($error) && in_array("produksi_header[quantity_paket]", $error)) {
  			echo form_input("produksi_header[quantity_paket]" ,$qty['quantity_paket'], 'class="error_number" onChange="document.form1.submit();" size="8"').' '.$uom_paket;
  		} else {
  			echo form_input("produksi_header[quantity_paket]",$qty['quantity_paket'], 'class="input_number" onChange="document.form1.submit();" size="8"').' '.$uom_paket;
  		}
	
		?><b><?php echo "Suggest Qty : ".$qty['quantity_paket'];?></b>
        </td>
	</tr>
	<?php } ?>
</table>
<?=form_close();?>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>