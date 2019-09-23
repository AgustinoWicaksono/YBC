<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant1 = $this->session->userdata['ADMIN']['plant'];
$plant2=substr($plant1,4);
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
    <?=$plant1;?> 
    - 
    <?=$plant_name;?>
    <br />
    Tanggal </p>
<?=$date_from.' - '.$date_to;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;


$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();
if ($date_to=="")
{
$date_to2=$date_from;
$date_from='2017-01-01';
}else
{
$date_to2=$date_to;
}
$item="SELECT * FROM OITM WHERE ItmsGrpCod=131";
mysql_connect("localhost",$user_mysql,$pass_mysql);
mysql_select_db($db_mysql);
$temp_cake="SELECT cake,otd_code,TRANSIT FROM m_outlet WHERE OUTLET ='$plant1'";
$re=mysql_fetch_array(mysql_query($temp_cake));
$trans_plant=$re['cake'];
$otd_code=$re['otd_code'];
$plant=$re['TRANSIT'];
$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
$row_count_to_show_header = 30;
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$transit='T.'.$plant;
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
str(B.BVolume) BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant1' AND A.OnHand > 0 AND AC.ItmsGrpCod='$grup_kode' AND B.U_pastry = 1";
}
else
{
	$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
str(B.BVolume) BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
WHERE A.WhsCode = '$plant1' AND A.OnHand > 0  AND B.U_pastry = 1";
}

$tmp=mssql_query($swbQuery);
//echo $swbQuery;
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>PASTRY</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="2158" border="1" align="center" class="table">
  <tr>
    <td width="24" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="50" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="250" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td width="80" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Convertion</span></strong></td>
    <td width="67" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Category</span></strong></td>
    <td width="30" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Unit</span></strong></td>
    <td width="74" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Beginning Stock</span></strong></td>
    <td colspan="4" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
    <td width="64" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="44" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Out</span></strong></td>
    <td width="53" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Int</span></strong></td>
    <td width="45" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Stock After Cutting</span></strong></td>
    <td width="74" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's In Convertion</span></strong></td>
    <td width="86" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's Out Convertion</span></strong></td>
    <td width="79" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Variance Counting </span></strong></td>
    <td colspan="8" align="center" bgcolor="#999999"><strong><span class="style5">QTY OUT</span></strong></td>
    <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Closing Stock</span></strong></td>
    <td width="81" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Variance Inventory </span></strong></td>
    <td width="54" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS</span></strong></td>
    <td width="69" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Variance Sales</span></strong></td>
    <td width="58" rowspan="3" align="center" bgcolor="#999999" ><strong><span class="style5">Remark</span></strong></td>
    <td width="58" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS VDINE</span></strong></td>
    <td width="88" rowspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Variance POS</span></strong></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Other Outlet</span></strong></td>
    <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Return</span></strong></td>
    <td width="19" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">No SR</span></strong></td>
    <td width="44" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cake Shop</span></strong></td>
    <td width="39" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">No COF</span></strong></td>
    <td width="119" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Pickup/Delivery From Other Outlet</span></strong></td>
    <td width="29" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">No TF</span></strong></td>
    <td width="47" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Other Outlet</span></strong></td>
    <td width="37" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">No Spoil</span></strong></td>
    <td width="105" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Wastage/Spoil</span></strong></td>
    <td width="54" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Ending Stock</span></strong></td>
    <td width="63" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Physical Ending</span></strong></td>
  </tr>
  <tr>
    <td width="29" align="center" bgcolor="#999999"><strong><span class="style5">No TF</span></strong></td>
    <td width="33" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
    <td width="48" align="center" bgcolor="#999999"><strong><span class="style5">No Return</span></strong></td>
    <td width="33" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
?>
  <tr>
  
    <td align="center"><span class="style5"><?=$no++;?></span></td>
    <td align="left"><span class="style5"><?=$r['ItemCode'];?></span></td>
    <td><span class="style5"><?=$r['ItemName'];?></span></td>
    <td align="center"><span class="style5"><?=$r['BVolume'];?></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5"><?=$r['InvntryUom'];?></span></td>
    <td align="center"><span class="style5"><?php
    $item=$r['ItemCode'];
	$temp1=mssql_query("SELECT str(SUM(InQty)) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant1' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r1=mssql_fetch_array($temp1);
	echo $r1['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td align="center"><span class="style5"><?php
    $temp2=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
;
	while ($r2=mssql_fetch_array($temp2))
	{
	echo $r2['DocEntry'].', ';
	}
	
	?></span></td>
    <td align="center"><span class="style5">
      <?php $temp6=mssql_query("SELECT str(SUM(Quantity)) as qty_in FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r6=mssql_fetch_array($temp6);
	echo $r6['qty_in'];
	?>
    </span></td>
    <td><span class="style5"><?php
    $temp4=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant1' AND U_Retur = 1  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while ($r4=mssql_fetch_array($temp4))
	{
	echo $r4['DocEntry'].', ';
	}
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?></span></td>
    <td align="center"><span class="style5"><?PHP $temp5=mssql_query("SELECT str(SUM(Quantity)) as qty_in FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant1' AND U_Retur = 1  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r5=mssql_fetch_array($temp5);
	
	echo $r5['qty_in'];
	?></span></td>
    <td align="center"><span class="style5"><?PHP 
	$onhand=$r6['qty_in']+ $r1['bgn']+$r5['qty_in'];
	echo $onhand;
	?></span></td>
    <td align="center"><span class="style5">
      <?PHP $temp8=mssql_query("SELECT str(SUM(Quantity)) as cut_out FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant1' AND U_BaseType=202 AND U_Cutting = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r8=mssql_fetch_array($temp8);
	echo $r8['cut_out'];
	?>
    </span></td>
    <td align="center"><span class="style5"><?PHP $temp7=mssql_query("SELECT str(SUM(Quantity)) as cut_in FROM IGN1 WHERE ItemCode = '$item' AND WhsCode= '$plant1' AND U_BaseType=202 AND U_Cutting = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r7=mssql_fetch_array($temp7);
	
	echo $r7['cut_in'];
	?></span></td>
    <td align="center"><span class="style5"><?php
    $after_cut=$onhand+$r7['cut_in']-$r8['cut_out'];
	echo $after_cut;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $conv_in=$r['BVolume']*$r7['cut_in'];
	echo $conv_in;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $conv_out=$r['BVolume']*$r8['cut_out'];
	echo $conv_out;
	?></span></td>
    <td><span class="style5"></span></td>
    <td align="center"><span class="style5"><span class="style5"><?PHP $temp9=mssql_query("SELECT DocEntry FROM WTQ1 WHERE ItemCode ='$item' AND FromWhsCod like '$plant1' AND WhsCode like 'T.01%' and DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	while ($r9=mssql_fetch_array($temp9))
	{
	echo $r9['DocEntry'].', ';
	}
//	echo "SELECT DocEntry FROM WTQ1 WHERE ItemCode ='$item' AND WhsCode like '$plantto' AND  DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ";
	
	?></span></span></td>
    <td align="center"><span class="style5">
      <?PHP $temp10=mssql_query("SELECT str(SUM(Quantity)) as Qty_Cake FROM WTQ1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant1' and WhsCode like 'T.01%' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r10=mssql_fetch_array($temp10);
	
	echo $r10['Qty_Cake'];
	?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td align="center"><span class="style5">
      <?php
    $temp13=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant1' and WhsCode not like 'T.01%'  AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while ($r13=mssql_fetch_array($temp13))
	{
	echo $r13['DocEntry'].', ';
	}
	?>
    </span></td>
    <td align="center"><span class="style5">
      <?php
    $temp12=mssql_query("SELECT SUM(Quantity)  as Qty_Out FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant1' and WhsCode not like 'T.01%' AND (U_Retur <> 1 OR U_Retur IS NULL) AND FromWhsCod  LIKE '%$plant2%' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
$r12=mssql_fetch_array($temp12);
	echo $r12['Qty_Out'];
	?>
    </span></td>
    <td align="center"><span class="style5"><?PHP $temp13=mssql_query("SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant1'  AND U_Waste = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r13=mssql_fetch_array($temp13);
	
	echo $r13['DocEntry'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td align="center"><span class="style5"><?PHP $temp14=mssql_query("SELECT SUM(Quantity) as qty_wast FROM IGE1 WHERE ItemCode = '$item' AND WhsCode= '$plant1' AND U_Waste = 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	$r14=mssql_fetch_array($temp14);
	
	echo $r14['qty_wast'];
	//echo "SELECT DocEntry FROM IGE1 WHERE ItemCode = '$item' AND  U_Waste = 1 AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td align="center"><span class="style5"><?PHP
    $ending_stock=$after_cut-$r10['Qty_Cake']-$r12['Qty_Out']-$r14['qty_wast'];
	echo $ending_stock;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $temp17=mssql_query("SELECT CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant1' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
$r17=mssql_fetch_array($temp17);
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