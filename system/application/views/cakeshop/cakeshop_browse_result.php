<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant = $this->session->userdata['ADMIN']['plant'];
$plant2=substr($plant,4);
$plant_name = $this->session->userdata['ADMIN']['plant_name'];
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
    <?=$plant;?> 
    - 
    <?=$plant_name;?>
    <br />
    Tanggal </p>
<?=$date_from.' sampai '.$date_to;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
$transit='T.'.$plant;
$row_count_to_show_header = 30;
$temp_cake="SELECT cake,otd_code,TRANSIT FROM m_outlet WHERE OUTLET ='$plant'";
$re=mysql_fetch_array(mysql_query($temp_cake));
$trans_plant=$re['cake'];
$otd_code=$re['otd_code'];
$plant1=$re['TRANSIT'];
/*$swbQuery = "SELECT * FROM OITW WHERE (ItemCode like '%PRT%' OR ItemCode like '%ICS%' or ItemCode like '%PR%' or ItemCode like '%ICK%' or ItemCode like '%HP%' or ItemCode='1MC0009' or ItemCode='1MM0008' OR ItemCode like '%PRT%' OR ItemCode like '%CD%') and WhsCode = '$plant'";*/
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
//echo '{'.$grup_kode.'}';
$swbQuery = "select a.itemcode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock,
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
 and c.U_cakeshop=1

group by a.ItemCode,a.LocCode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock";

}
else
{

$swbQuery = "select a.itemcode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock,
sum(a.inqty-a.outqty)onhand,
(select sum(b.inqty-b.outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate < convert(datetime, '$date_from', 120) ) stock_awal, 
(select sum(b.inqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.transtype = '67' and b.InQty <> 0 and  b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120) ) InQty,
(select sum(b.OutQty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120) ) outqty,
(select sum(inqty-outqty) from oivl b where a.itemcode=b.ItemCode and b.LocCode=a.LocCode and b.DocDate<=  convert(datetime, '$date_to', 120) ) stock_akhir
 from  oivl a , oitm c,OITW d
 where a.LocCode = '$plant'
 and a.ItemCode=c.ItemCode
 and a.ItemCode=d.ItemCode
 and a.LocCode = d.WhsCode
 and c.U_cakeshop=1

group by a.ItemCode,a.LocCode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock";
}
//echo $swbQuery;
//$swbQuery = "SELECT * FROM OITW WHERE  WhsCode = '$plant' AND OnHand > 0";
//$item="SELECT * FROM OITM WHERE ItmsGrpCod=129 or ItmsGrpCod=127 or ItmsGrpCod=101  or ItmsGrpCod=125  or ItmsGrpCod=108  or ItmsGrpCod=134";
$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Cake Shop</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="1749" border="1" align="center" class="table">
  <tr>
    <td width="23" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="46" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="223" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td width="75" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Beginning Stock</span></strong></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Request 1</span></strong></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Delivery Outlet</span></strong></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Pickup Outlet</span></strong></td>
    <td width="70" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="80" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Sold POS</span></strong></td>
    <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Return</span></strong></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Delivery Outlet</span></strong></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Pickup Outlet</span></strong></td>
    <td width="54" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Ending Stock</span></strong></td>
    <td width="79" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Physical Ending</span></strong></td>
    <td width="109" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Variance</span></strong></td>
    <td width="94" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Remarks</span></strong></td>
  </tr>
  <tr>
    <td width="51" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">No Return</span></strong></td>
    <td width="59" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Qty</span></strong></td>
  </tr>
  <tr>
    <td width="48" align="center" bgcolor="#999999"><strong><span class="style5">No SR</span></strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong><span class="style5">Qty</span></strong></td>
    <td width="69" align="center" bgcolor="#999999"><strong><span class="style5">No COF </span></strong></td>
<td width="69" align="center" bgcolor="#999999"><strong><span class="style5">Qty </span></strong></td>
 <td width="69" align="center" bgcolor="#999999"><strong><span class="style5">No Pick Up</span></strong></td>
<td width="69" align="center" bgcolor="#999999"><strong><span class="style5">Qty </span></strong></td>
<td width="75" align="center" bgcolor="#999999"><strong><span class="style5">No COF </span></strong></td>
<td width="69" align="center" bgcolor="#999999"><strong><span class="style5">Qty </span></strong></td>
<td width="69" align="center" bgcolor="#999999"><strong><span class="style5">No Pick Up </span></strong></td>
<td width="69" align="center" bgcolor="#999999"><strong><span class="style5">Qty </span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
?>
  <tr>
    <td align="center">
    <span class="style5">
      <?=$no++;?>
    </span>
    <td><span class="style5">
    <?=$r['itemcode'];?>
    </span></td>
    <td><span class="style5">
      <?=$r['ItemName'];?>
    </span></td>
    <td align="center"><span class="style5">
      <?=$r['stock_awal'];?>
    &nbsp;</span></td>
    <td><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp5=mssql_query("
	select a.docnum no_sr from owtq a,wtq1 b,oitm e 
	where  a.docentry = b.DocEntry 
	and e.itemcode = b.ItemCode 
	and e.itemcode ='$item'
	and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
	and a.ToWhsCode='$transit'
");
	while ($r5=mssql_fetch_array($temp5))
	{
	echo $r5['no_sr'].', ';
	}
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp6=mssql_query("
select sum(b.Quantity) In_sr from owtq a,wtq1 b,oitm e 
	where  a.docentry = b.DocEntry 
	and e.itemcode = b.ItemCode 
	and e.itemcode ='$item'
	and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
	and a.ToWhsCode='$transit'
");
 //substr($r6['In_sr'],0,-4);
	$r6=mssql_fetch_array($temp6);
	echo substr($r6['In_sr'],0,-4);
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5"><?php $onhand=$r['stock_awal']+$r6['In_sr'];
	echo $onhand; ?></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp7=mssql_query("
select distinct b.docnum no_retur from  owtr b, wtr1 c,oivl d, oitm e
where  d.BASE_REF=c.DocEntry
and  b.docentry=c.DocEntry
and d.transtype = '67'
and d.OutQty <> 0
and e.itemcode = d.ItemCode
and c.U_Retur =1
and e.U_cakeshop =1
and d.ItemCode='$item'
and d.LocCode = '$plant' 
and d.DocDate <=  convert(datetime, '$date_to', 120) AND d.DocDate >=  convert(datetime, '$date_from', 120)
order by b.Docnum
");
	while ($r7=mssql_fetch_array($temp7))
	{
	echo $r7['no_retur'].', ';
	}
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    &nbsp;</span></td>
    <td align="center"><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp9=mssql_query("
select sum(d.OutQty) qty_out from  owtr b, wtr1 c,oivl d, oitm e
where d.BASE_REF=c.DocEntry
and b.docentry=c.DocEntry
and d.transtype = '67'
and d.OutQty <> 0
and e.itemcode = d.ItemCode
and c.U_Retur =1
and e.U_cakeshop =1
and d.ItemCode='$item'
and d.LocCode = '$plant' 
and d.DocDate <=  convert(datetime, '$date_to', 120) AND d.DocDate >=  convert(datetime, '$date_from', 120)
");
$r9=mssql_fetch_array($temp9);
	echo substr($r9['qty_out'],0,-4);	
	?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">
      <?=$ending_stock=$onhand-$r9['qty_out'];
	  ?>
    </span></td>
    <td align="center"><span class="style5">
      <?PHP $temp15=mssql_query("SELECT str(SUM(CountQty)) as count FROM IQR1 WHERE ItemCode='$item' AND WhsCode ='$plant' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
	$r15=mssql_fetch_array($temp15);
	
	echo $r15['count'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?>
    </span></td>
    <td align="center"><span class="style5">&nbsp;</span><span class="style5">
      <?php
	$variance=$r15['count']-$ending_stock;
    echo $variance;
	?>
    </span></td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  
</body>

</html>