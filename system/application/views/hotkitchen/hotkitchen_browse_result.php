<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant = $this->session->userdata['ADMIN']['plant'];
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
mysql_select_db("sap_php2");
$outlet=mysql_fetch_array(mysql_query("SELECT TRANSIT FROM m_outlet WHERE OUTLET='$plant'"));
$plant1=$outlet['TRANSIT'];
$row_count_to_show_header = 30;
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];

$row_count_to_show_header = 30;
if ($grup_item != "")
{
$swbQuery = "SELECT ItemCode FROM OITM 
WHERE ItemCode IN (SELECT ItemCode FROM OITW WHERE OnHand > 0 AND WhsCode='$plant')
AND ItmsGrpCod='$grup_item' 
";
}
else
{
$swbQuery = "SELECT * FROM OITW 
WHERE WhsCode = '$plant'  AND OnHand > 0 ";
}
$store='0501'.substr($plant,4);
$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Hot Kitchen</strong></h3></td>
  </tr>
</table>
<table width="1032" style="border-collapse:collapse;" border="1" align="center" class="table">
  <tr>
    <td width="81" align="center" bgcolor="#999999"><strong><strong><span class="style5"><strong>Item</span></strong></td>
    <td width="190" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="80" align="center" bgcolor="#999999"><strong><span class="style5">Beginning</span></strong></td>
    <td width="67" align="center" bgcolor="#999999"><strong><span class="style5">Uom</span></strong></td>
    <td width="67" align="center" bgcolor="#999999"><strong><span class="style5">Store</span></strong></td>
    <td width="67" align="center" bgcolor="#999999"><strong><span class="style5">No Req</span></strong></td>
    <td width="51" align="center" bgcolor="#999999"><strong><span class="style5">Qty Req</span></strong></td>
    <td width="53" align="center" bgcolor="#999999"><strong><span class="style5">Fisik Opening</span></strong></td>
    <td width="64" align="center" bgcolor="#999999"><strong><span class="style5">Fisik Closing</span></strong></td>
    <td width="64" align="center" bgcolor="#999999"><strong><span class="style5">Lost / Breakage</span></strong></td>
    <td width="86" align="center" bgcolor="#999999"><strong><span class="style5">Physical Ending</span></strong></td>
    <td width="86" align="center" bgcolor="#999999"><strong><span class="style5">Remarks</span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
?>
  <tr>
  
    <td><span class="style5"><?=$r['ItemCode'];?></span></td>
    <td><span class="style5"><?php
    $item=$r['ItemCode'];
	$temp1=mssql_query("SELECT ItemName,IUoMEntry FROM OITM WHERE ItemCode ='$item' ");
	$r1=mssql_fetch_array($temp1);
	echo $r1['ItemName'];
	?></span></td>
    <td><span class="style5"><?php
   $temp4=mssql_query("SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r4=mssql_fetch_array($temp4);
	echo $r4['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td><span class="style5">
      <?php
	$uom=$r1['IUoMEntry'];
    $temp2=mssql_query("SELECT UomCode FROM OUOM WHERE UomEntry ='$uom' ");
	$r2=mssql_fetch_array($temp2);
	echo $r2['UomCode'];
	?>
    </span></td>
    <td><span class="style5"><?PHP $temp13=mssql_query("SELECT SUM(Quantity) as qty_store FROM WTR1 WHERE WhsCode ='$plant1' AND FromWhsCod='$store' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r13=mssql_fetch_array($temp13);
	//echo "SELECT SUM(Quantity) as qty_store FROM WTR1 WHERE WhsCode ='$plant1' AND FromWhsCod='$store' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	echo $r13['qty_store'];
	?></span></td>
    <td><span class="style5"><?PHP $temp3=mssql_query("SELECT DocEntry FROM WTQ1 WHERE WhsCode ='$plant' AND FromWhsCod <> '$store' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r3=mssql_fetch_array($temp3);
	
	echo $r3['DocEntry'];
	?></span></td>
    <td><span class="style5"><?PHP $temp5=mssql_query("SELECT SUM(Quantity) as qty FROM WTQ1 WHERE WhsCode ='$plant'  AND FromWhsCod <> '$store' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r5=mssql_fetch_array($temp5);
	
	echo $r5['qty'];
	?></span></td>
    <td><span class="style5"><?=$r4['bgn']+$r13['qty_store']+$r5['qty'];?></span></td>
    <td><span class="style5">
      <?php
    $temp13=mssql_query("SELECT CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
$r13=mssql_fetch_array($temp13);
	echo $r13['CountQty'];
	?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?PHP $temp14=mssql_query("SELECT SUM(Quantity) as qty_wast FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant' AND U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ");
	$r14=mssql_fetch_array($temp14);
	
	//echo $r14['qty_wast'];
	
	echo $r['OnHand']-$r13['CountQty'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?=$r['OnHand'];?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
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
  </tr>
  </table>
  
</body>

</html>