<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
    header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=Audit.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant1 = $this->session->userdata['ADMIN']['plant'];
$plant2=substr($plant1,4);
$plant_name = $this->session->userdata['ADMIN']['plant_name'];

$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<style type="text/css">
<!--
.style5 {font-size: 9px}
-->
</style>
<?php if(!empty($page['page_name'])) : ?>
<title><?=$this->lang->line('page_'.$page['page_name']);?> - <?=$this->m_config->content_select('main_sitename');?></title>
<?php else : ?>
<title><?=$this->m_config->content_select('main_sitename');?></title>
<?php endif; ?>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<!-- Start of menu and main CSS //-->
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/cssplay.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/<?=$this->session->userdata('template');?>/<?=$this->session->userdata('lang_name');?>/main.css" />
<style type="text/css">
<!--
.style11 {	font-size: 27px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div align="center" class="page_title">
  <p align="left"><span class="style11"><u>THE HARVEST </u></span><br />
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="style5">Partisier &amp; Chocolatier</span> </p>
  <p>
    <?=$page_title;?>
    <br />
    Outlet 
    <?=$plant1;?> 
    - 
    <?=$plant_name;?>
    <br />
    Tanggal </p>
<?=$date_from.' - '.$date_to.' - '.$item_group_code.' - '.$WhsCode;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

$temp_cake="SELECT cake,otd_code,TRANSIT FROM m_outlet WHERE OUTLET ='$plant1'";
$re=sqlsrv_fetch_array(sqlsrv_query($temp_cake));
$trans_plant=$re['cake'];
$otd_code=$re['otd_code'];
$plant=$re['TRANSIT'];
$c=sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));

$row_count_to_show_header = 30;
$cekG=sqlsrv_fetch_array(sqlsrv_query($c,"SELECT OnHand FROM OITW WHERE OnHand > 0"));
$transit='T.'.$plant;
$grup_item=$cekG['ItmsGrpCod'];

if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "SELECT a.itemcode,c.ItemName,c.U_Small,c.BVolume BVolume,c.InvntryUom,d.MinStock,d.MaxStock, 
sum(a.inqty-a.outqty)onhand, 
(select sum(b.inqty-b.outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate < convert(datetime, '$date_from', 120) ) stock_awal, 
(select sum(b.inqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) inqty, 
(select sum(b.OutQty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) outqty, 
(select sum(inqty-outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate<= convert(datetime, '$date_to', 120) ) stock_akhir 
from oivl a , oitm c,OITW d
where a.LocCode = '$plant1' 
and a.ItemCode=c.ItemCode 
and a.ItemCode=d.ItemCode 
and a.LocCode = d.WhsCode 
and   LEFT(a.LocCode,2)!='T.'
GROUP BY a.ItemCode,a.LocCode,c.ItemName,c.BVolume,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock";
//echo "abc";
}
else
{
	$swbQuery = "SELECT a.itemcode,c.ItemName,c.U_Small,c.BVolume BVolume,c.InvntryUom,d.MinStock,d.MaxStock, 
sum(a.inqty-a.outqty)onhand, 
(select sum(b.inqty-b.outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate < convert(datetime, '$date_from', 120) ) stock_awal, 
(select sum(b.inqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) inqty, 
(select sum(b.OutQty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) outqty, 
(select sum(inqty-outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate<= convert(datetime, '$date_to', 120) ) stock_akhir 
from oivl a , oitm c,OITW d
where a.LocCode = '$plant1' 
and a.ItemCode=c.ItemCode 
and a.ItemCode=d.ItemCode 
and a.LocCode = d.WhsCode 
and   LEFT(a.LocCode,2)!='T.'
GROUP BY a.ItemCode,a.LocCode,c.ItemName,c.BVolume,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock";
//echo "dfg";
}

$tmp=sqlsrv_query($c,"SELECT a.itemcode,c.ItemName,c.U_Small,c.BVolume BVolume,c.InvntryUom,d.MinStock,d.MaxStock, 
sum(a.inqty-a.outqty)onhand, 
(select sum(b.inqty-b.outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate < convert(datetime, '$date_from', 120) ) stock_awal, 
(select sum(b.inqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) inqty, 
(select sum(b.OutQty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <= convert(datetime, '$date_to', 120) AND b.DocDate >= convert(datetime, '$date_from', 120) ) outqty, 
(select sum(inqty-outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate<= convert(datetime, '$date_to', 120) ) stock_akhir 
from oivl a , oitm c,OITW d
where a.LocCode = '$plant1' 
and a.ItemCode=c.ItemCode 
and a.ItemCode=d.ItemCode 
and a.LocCode = d.WhsCode 
and   LEFT(a.LocCode,2)!='T.'
GROUP BY a.ItemCode,a.LocCode,c.ItemName,c.BVolume,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock");
//echo $swbQuery;
?>

	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>PASTRY</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="2158" border="1" align="center" class="table">
  <tr id="myHeader" class="header">
    <td width="22" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="45" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="215" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td width="27" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Unit</span></strong></td>
    <td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Beginning Stock</span></strong></td>
    <td colspan="7" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
	<td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total In</span></strong></td>
<!--    <td width="57" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="42" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Out</span></strong></td>
    <td width="49" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Int</span></strong></td>
    <td width="42" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Stock After Cutting</span></strong></td>
    <td width="69" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's In Convertion</span></strong></td>
    <td width="79" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's Out Convertion</span></strong></td>
    <td width="72" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Counting </span></strong></td>-->
    <td colspan="5" align="center" bgcolor="#999999"><strong><span class="style5">QTY OUT</span></strong></td>
    <td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total Out</span></strong></td>
    <td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Subtotal</span></strong></td>
    <!-- <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Closing Stock</span></strong></td>
    <td width="73" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Inventory </span></strong></td>
    <td width="49" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS</span></strong></td>
    <td width="63" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Sales</span></strong></td>
    <td width="53" rowspan="2" align="center" bgcolor="#999999" ><strong><span class="style5">Remark</span></strong></td>
    <td width="53" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS VDINE</span></strong></td>
    <td width="97" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance POS</span></strong></td> -->
  </tr>
  <tr>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR from ck</span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR PO</span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR From Outlet </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR Production </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR Whole Cake </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR Non PO  </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR return </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE Transfer Outlet </span></strong></td>
    <td width="50" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE Production</span></strong></td>
    <td width="33" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE whole cake</span></strong></td>
    <td width="85" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE waste material</span></strong></td>
    <td width="85" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE Return Out</span></strong></td>
  </tr>
  <!--<tr>
    <td width="26" align="center" bgcolor="#999999"><strong><span class="style5">No TF</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong><span class="style5">No Return</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
  </tr>-->
  <?php
  $no=1;
	while($r=sqlsrv_fetch_array($tmp))
	{
?>
  <tr> 
    <td align="center"><span class="style5"><?=$no++;?></span></td>
    <td align="left"><span class="style5"><?=$r['itemcode'];?></span></td>
    <td><span class="style5"><?=$r['ItemName'];?></span></td>
    <td align="center"><span class="style5"><?=$r['InvntryUom'];?></span></td>
    <td align="left"><span class="style5">
      <?php
	$item=$r['itemcode'];
	/*$temp1=sqlsrv_query($c,"select a.itemcode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock,
	sum(a.inqty-a.outqty)onhand,
	(select sum(b.inqty-b.outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate < convert(datetime, '$date_from', 120) ) stock_awal, 
	(select sum(b.inqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and  b.transtype = '67' and  b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120) ) inqty,
	(select sum(b.OutQty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120) ) outqty,
	(select sum(inqty-outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate<=  convert(datetime, '$date_to', 120) ) stock_akhir
	 from  oivl a , oitm c,OITW d
	 where a.LocCode = '$plant'
	 and a.ItemCode=c.ItemCode
	 and a.ItemCode=d.ItemCode
	 and a.LocCode = d.WhsCode
	 

	group by a.ItemCode,a.LocCode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock
	");
	/*echo "select c.gr_quantity from t_grpodlv_header b, t_grpodlv_detail c 
	where b.do_no is not null and c.grpodlv_no is not null
	and where b.do_no not like '%C%' and c.grpodlv_no not like '%C%'
	and b.posting_date <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)";
	*/
	/*	while ($r1=sqlsrv_fetch_array($temp1))
		{
			echo $r1['stock_awal'];
		}*/
		echo $r['stock_awal'];
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	 $item=$r['itemcode'];
    $temp1=mysql_query("select SUM(c.gr_quantity) qty_ck 
	from 
	t_grpodlv_header b
	join t_grpodlv_detail c on b.id_grpodlv_header = c.id_grpodlv_header
	where b.do_no !=''  and b.grpodlv_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.do_no not like '%C%' and b.grpodlv_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
/*echo "select c.gr_quantity from t_grpodlv_header b, t_grpodlv_detail c 
where b.do_no is not null and c.grpodlv_no is not null
and where b.do_no not like '%C%' and c.grpodlv_no not like '%C%'
and b.posting_date <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)";
*/
	$r1=mysql_fetch_array($temp1);
		echo $r1['qty_ck'];
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp2=mysql_query("
	select SUM(c.gr_quantity) qty_po 
	from 
	t_grpo_header b
	join t_grpo_detail c on b.id_grpo_header = c.id_grpo_header
	where b.po_no !=''  and b.grpo_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.po_no not like '%C%' and b.grpo_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);

	$r2=mysql_fetch_array($temp2);
			echo $r2['qty_po'];
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp3=mysql_query("
	select SUM(c.gr_quantity) qty_fo 
	from 
	t_grsto_header b
	join t_grsto_detail c on b.id_grsto_header = c.id_grsto_header
	where b.po_no !=''  and b.grsto_no !='' and b.no_doc_gist !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.po_no not like '%C%' and b.grsto_no not like '%C%' and b.no_doc_gist not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r3=mysql_fetch_array($temp3);
		echo $r3['qty_fo'];
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp4=mysql_query("
	select SUM(b.qty_paket) qty_produc 
	from 
	t_produksi_header b
	where b.produksi_no !='' and b.kode_paket='$item' and b.plant ='$plant1'
	and b.produksi_no not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r4=mysql_fetch_array($temp4);
		echo $r4['qty_produc'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp5=mysql_query("
	select SUM(c.quantity) qty_wc 
	from 
	m_twtsnew_header b
	join m_twtsnew_detail c on b.id_twtsnew_header = c.id_twtsnew_header
	where b.gr_no !=''  and b.gi_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.gr_no not like '%C%' and b.gi_no not like '%C%' 
	and b.last_update>='$date_from' AND b.last_update<='$date_to'
", $mysqlcon);
	$r5=mysql_fetch_array($temp5);
		echo $r5['qty_wc'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp6=mysql_query("
	select SUM(c.quantity) qty_nonpo
	from 
	t_grnonpo_header b
	join t_grnonpo_detail c on b.id_grnonpo_header = c.id_grnonpo_header
	where b.grnonpo_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.grnonpo_no not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r6=mysql_fetch_array($temp6);
		echo $r6['qty_nonpo'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp7=mysql_query("
	select SUM(c.gr_quantity) qty_retin
	from 
	t_retin_header b
	join t_retin_detail c on b.id_retin_header = c.id_retin_header
	where b.retin_no !='' and b.do_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.retin_no not like '%C%' and b.do_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r7=mysql_fetch_array($temp7);
			echo $r7['qty_retin'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
		<?php $total_in=$r1['qty_ck']+$r2['qty_po']+$r3['qty_fo']+$r4['qty_produc']+$r5['qty_wc']+ $r6['qty_nonpo']+$r7['qty_retin'];
			echo $total_in;
		?>
	</span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp8=mysql_query("
	select SUM(c.gr_quantity) qty_to 
	from 
	t_gistonew_out_header b
	join t_gistonew_out_detail c on b.id_gistonew_out_header = c.id_gistonew_out_header
	where b.po_no !='' and b.gistonew_out_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.po_no not like '%C%' and b.gistonew_out_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r8=mysql_fetch_array($temp8);
		echo $r8['qty_to'];	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp9=mysql_query("
	select SUM(c.qty) qty_produc 
	from 
	t_produksi_header b
	join t_produksi_detail c on b.id_produksi_header = c.id_produksi_header
	where b.produksi_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.produksi_no not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r9=mysql_fetch_array($temp9);
		echo $r9['qty_produc'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp10=mysql_query("
	select SUM(b.quantity_paket) qty_wc 
	from 
	m_twtsnew_header b
	where b.gr_no !=''  and b.gi_no !='' and b.kode_paket='$item' and b.plant ='$plant1'
	and b.gr_no not like '%C%' and b.gi_no not like '%C%' 
	and b.last_update>='$date_from' AND b.last_update<='$date_to'
", $mysqlcon);
	$r10=mysql_fetch_array($temp10);
		echo $r10['qty_wc'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp11=mysql_query("
	select SUM(c.quantity) qty_waste 
	from 
	t_waste_header b
	join t_waste_detail c on b.id_waste_header = c.id_waste_header
	where b.material_doc_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.material_doc_no  not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r11=mysql_fetch_array($temp11);
		echo $r11['qty_waste'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp12=mysql_query("
	select SUM(c.gr_quantity) qty_ro 
	from 
	t_gisto_dept_header b
	join t_gisto_dept_detail c on b.id_gisto_dept_header = c.id_gisto_dept_header
	where b.gisto_dept_no !='' and b.po_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.gisto_dept_no not like '%C%' and b.po_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r12=mysql_fetch_array($temp12);
		echo $r12['qty_ro'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
		
	<td align="center"><span class="style5">
		<?php $total_out=$r8['qty_to']+$r9['qty_produc']+$r10['qty_wc']+$r11['qty_waste']+$r12['qty_ro'];
			echo $total_out;
		?>
	</span></td>
	<td align="center"><span class="style5">
		<?php $subtotal=$r['stock_awal']+$total_in-$total_out;
			echo $subtotal;
		?>
	</span></td>

<!--     <td align="center"><span class="style5"> 
<?PHP  $ending_stock=$onhandaftercutting-$r16['qty_outtocshop']-$r17['qty_outtoother']-$r20['qty_spoiled'];
	echo $ending_stock;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $temp17=sqlsrv_query($c,"SELECT CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant1' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
$r17=sqlsrv_fetch_array($temp17);
	sqlsrv_close($c);
	echo $r17['CountQty'];
	?></span></td>
    <td align="center"><span class="style5"><?php
	$variance=$r17['CountQty']-$ending_stock;
    echo $variance;
	?></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td> -->
  </tr>
  <?php }
	mysql_close($mysqlcon);
  
  ?>

  </table>
  
</body>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

</html>