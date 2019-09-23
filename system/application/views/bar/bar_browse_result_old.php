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
$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
$row_count_to_show_header = 30;
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$transit='T.'.$plant;
$grup_item=$cekG['ItmsGrpCod'];
if ($date_to=="")
{
$date_to2=$date_from;
$date_from='2017-01-01';
}else
{
$date_to2=date_to;
}

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
WHERE A.WhsCode = '$plant' AND A.OnHand > 0 AND AC.ItmsGrpCod='$grup_kode' AND B.U_bar=1";

}
else
{
	//echo "xxxxxxx";
	//$swbQuery = "SELECT * FROM OITM WHERE  WhsCode = '$plant' AND OnHand > 0 AND U_bar=1";
	$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
B.BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant' AND A.OnHand > 0  AND B.U_bar=1";
}
//echo $swbQuery;

$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Bar</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="1311" border="1" align="center" class="table">
  <tr>
    <td width="72" align="center" bgcolor="#999999"><strong><span class="style5"><strong>Item</span><strong></strong></td>
    <td width="168" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="49" align="center" bgcolor="#999999"><strong><span class="style5">UOM</span></strong></td>
    <td width="76" align="center" bgcolor="#999999"><strong><span class="style5">BEGINNING</span></strong></td>
    <td width="60" align="center" bgcolor="#999999"><strong><span class="style5">No Req</span></strong></td>
    <td width="27" align="center" bgcolor="#999999"><strong><span class="style5">Qty Req</span></strong></td>
    <td width="67" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="57" align="center" bgcolor="#999999"><strong><span class="style5">Sold</span></strong></td>
    <td width="41" align="center" bgcolor="#999999"><strong><span class="style5">No Spoiled</span></strong></td>
    <td width="49" align="center" bgcolor="#999999"><strong><span class="style5">Spoiled</span></strong></td>
    <td width="43" align="center" bgcolor="#999999"><strong><span class="style5">No Transfer</span></strong></td>
    <td width="68" align="center" bgcolor="#999999"><strong><span class="style5">Transfer Out</span></strong></td>
    <td width="56" align="center" bgcolor="#999999"><strong><span class="style5">Physical Ending</span></strong></td>
    <td width="58" align="center" bgcolor="#999999"><span class="style5"><strong>Total Consume</strong></span></td>
    <td width="57" align="center" bgcolor="#999999"><strong><span class="style5">Ideal Consume</span></strong></td>
    <td width="70" align="center" bgcolor="#999999"><strong><span class="style5">Variance</span></strong></td>
    <td width="187" align="center" bgcolor="#999999"><strong><span class="style5">Remarks</span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
?>
  <tr>
  
    <td><span class="style5">&nbsp;
    <?=$r['ItemCode'];?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $item=$r['ItemCode'];
	$temp1=mssql_query("SELECT ItemName,IUoMEntry FROM OITM WHERE ItemCode ='$item' ");
	$r1=mssql_fetch_array($temp1);
	echo $r1['ItemName'];
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
	$uom=$r1['IUoMEntry'];
    $temp2=mssql_query("SELECT UomCode FROM OUOM WHERE UomEntry ='$uom' ");
	$r2=mssql_fetch_array($temp2);
	echo $r2['UomCode'];
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
   $temp4=mssql_query("SELECT str(SUM(InQty)) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r4=mssql_fetch_array($temp4);
	echo $r4['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) ";
	?></span></td>
    <td><span class="style5">&nbsp;
    <?PHP $temp3=mssql_query("SELECT DocEntry FROM WTQ1 WHERE WhsCode ='$transit' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r3=mssql_fetch_array($temp3);
	
	echo $r3['DocEntry'];
	?></span></td>
    <td><span class="style5">&nbsp;
    <?PHP $temp5=mssql_query("SELECT str(SUM(Quantity)) as qty FROM WTQ1 WHERE WhsCode ='$transit' AND ItemCode='$item' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r5=mssql_fetch_array($temp5);
	
	echo $r5['qty'];
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $Onhand=$r4['bgn']+$r5['qty'];
	echo $Onhand;?></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;
    <?PHP $temp13=mssql_query("SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant'  AND U_Waste = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r13=mssql_fetch_array($temp13);
	
	echo $r13['DocEntry'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td><span class="style5">&nbsp;
    <?PHP $temp14=mssql_query("SELECT str(SUM(Quantity)) as qty_wast FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant' AND U_Waste = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r14=mssql_fetch_array($temp14);
	
	echo $r14['qty_wast'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td><span class="style5">&nbsp;&nbsp;<?php
    $temp11=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND (U_Retur <> 1 OR U_Retur IS NULL) AND FromWhsCod  = '$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
while ($r11=mssql_fetch_array($temp11))
	{
	echo $r11['DocEntry'].', ';
	}
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $temp12=mssql_query("SELECT str(SUM(Quantity)) as QTY FROM WTR1 WHERE ItemCode ='$item' AND (U_Retur <> 1 OR U_Retur IS NULL) AND FromWhsCod  = '$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
$r12=mssql_fetch_array($temp12);
	echo $r12['QTY'];
	
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $temp13=mssql_query("SELECT str(CountQty) FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant' AND CountDate =  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120)");
$r13=mssql_fetch_array($temp13);
	echo $r13['CountQty'];
	?></span></td>
    <td>&nbsp;<span class="style5">
      <?php
    $consume=$Onhand-$r14['qty_wast']-$r12['QTY']-$r13['CountQty'];
	echo $consume;
	?>
    </span></td>
    <td>&nbsp;</td>
    <td><span class="style5">&nbsp;
      <?php
    $consume=$Onhand-$r14['qty_wast']-$r12['QTY']-$r13['CountQty'];
	echo -$consume;
	?>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  
</body>

</html>