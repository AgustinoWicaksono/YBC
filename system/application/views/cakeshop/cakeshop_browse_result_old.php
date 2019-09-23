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
if ($date_to=="")
{
$date_to2=$date_from;
$date_from='2017-01-01';
}else
{
$date_to2=$date_to;
}

$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
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
$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
B.BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant' AND A.OnHand > 0 AND AC.ItmsGrpCod='$grup_kode' AND B.U_cakeshop =1";

}
else
{
	//echo "xxxxxxx";
//	$swbQuery = "SELECT * FROM OITW WHERE  WhsCode = '$plant' AND OnHand > 0";
$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
B.BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant' AND A.OnHand > 0  AND B.U_cakeshop =1";
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
      <?=$r['ItemCode'];?>
    </span></td>
    <td><span class="style5"><?php
    $item=$r['ItemCode'];
	$temp1=mssql_query("SELECT ItemName,U_Small,IUoMEntry FROM OITM WHERE ItemCode ='$item'");
	$r1=mssql_fetch_array($temp1);
	echo $r1['ItemName'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td align="center"><span class="style5">&nbsp;
    <?php
   $temp4=mssql_query("SELECT str(SUM(InQty)) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r4=mssql_fetch_array($temp4);
	echo $r4['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ";
	?>
    </span></td>
    <td><span class="style5">
      <?PHP $temp9=mssql_query("SELECT DocEntry FROM WTQ1 WHERE ItemCode ='$item' AND WhsCode ='$plant1'  AND FromWhsCod  LIKE '%$plant2%' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while($r9=mssql_fetch_array($temp9))
	{
	echo $r9['DocEntry'].', ';
	}
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?PHP $temp10=mssql_query("SELECT str(SUM(Quantity)) as Qty_In1 FROM WTQ1 WHERE ItemCode ='$item' AND WhsCode ='$plant1'  AND FromWhsCod  LIKE '%$plant2%' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r10=mssql_fetch_array($temp10);
	
	echo $r10['Qty_In1'];
	?>
    </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">&nbsp;
    <?PHP
    $total_onhand=$r4['bgn']+$r10['Qty_In1'];
	echo $total_onhand;
	?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">&nbsp;
      <?php
    $temp4=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant' AND U_Retur = 1  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while ($r4=mssql_fetch_array($temp4))
	{
	echo $r4['DocEntry'].', ';
	}
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5"><?php
    $temp5=mssql_query("SELECT str(SUM(Quantity)) as qty_ret FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant' AND U_Retur = 1  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r5=mssql_fetch_array($temp5);
	echo $r5['qty_ret'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">
      <?PHP
    $ending_stock=$total_onhand-$r5['qty_ret'];
	echo $ending_stock;
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