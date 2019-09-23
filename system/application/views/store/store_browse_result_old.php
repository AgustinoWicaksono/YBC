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
.style11 {
	font-size: 27px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div align="center" class="page_title">
  <div align="center" class="page_title">
    <p align="left"><span class="style11"><u>THE HARVEST </u></span><br />
         &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="style5">Partisier &amp; Chocolatier</span></p>
    <p>
      <?=$page_title;?>
      <br />
      Outlet
      <?=$plant;?>
      -
      <?=$plant_name;?>
      <br />
      Tanggal
      <?=$date_from.' sampai '.$date_to;?>
    </p>
  </div>
</div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
$row_count_to_show_header = 30;
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($date_to=="")
{
$date_to2=$date_from;
$date_from='2017-01-01';
}else
{
$date_to2=$date_to;
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
WHERE A.WhsCode = '$plant' AND A.OnHand > 0 AND AC.ItmsGrpCod='$grup_kode' AND B.U_store=1";

}
else
{
	//echo "xxxxxxx";
	//$swbQuery = "SELECT * FROM OITW WHERE  WhsCode = '$plant' AND OnHand > 0 AND B.U_store=1";
	
	$swbQuery = "SELECT A.ItemCode,B.ItemName,B.OnHand,
B.BVolume,
A.WhsCode,
B.InvntryUom
FROM OITW A
JOIN OITM B ON A.ItemCode = B.ItemCode
JOIN OITB AC ON B.ItmsGrpCod = AC.ItmsGrpCod
WHERE A.WhsCode = '$plant' AND A.OnHand > 0  AND B.U_store=1";
}
//echo $swbQuery;

$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Store</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="1461" border="1" align="center" class="table">
  <tr>
    <td width="26" rowspan="3" align="center" bgcolor="#999999"><span class="style5">No</span></td>
    <td width="83" rowspan="3" align="center" bgcolor="#999999"><span class="style5"><strong>Code</span><strong></td>
    <td width="179" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Name</span></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">UNIT</span></td>
    <td width="87" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Stock On Hand</span></td>
    <td width="86" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Location</span></td>
    <td width="96" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Expired Date</span></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Part Stock</span><span class="style5"></span></td>
    <td width="97" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Adjusment</span></td>
    <td width="90" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Beginning Stock</span></td>
    <td colspan="4" align="center" bgcolor="#999999"><span class="style5">Date <?=' : '.$date_from;?></span></td>
  </tr>
  <tr>
    <td width="93" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
    <td width="79" rowspan="2" align="center" bgcolor="#999999"><span class="style5">In</span></td>
    <td width="84" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
    <td width="79" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Out</span></td>
  </tr>
  <tr>
    <td width="64" align="center" bgcolor="#999999"><span class="style5">Small</span></td>
    <td width="66" align="center" bgcolor="#999999"><span class="style5">Pack</span></td>
    <td width="81" bgcolor="#999999"><span class="style5">Min</span></td>
    <td width="71" bgcolor="#999999"><span class="style5">Max</span></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
	
?>
  <tr>
    <td align="center"><span class="style5">
      <?=$no++;?>
    </span></td>
    <td><span class="style5">&nbsp;
    <?=$r['ItemCode'];?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $item=$r['ItemCode'];
	$temp1=mssql_query("SELECT ItemName,U_Small,IUoMEntry FROM OITM WHERE ItemCode ='$item'");
	$r1=mssql_fetch_array($temp1);
	echo $r1['ItemName'];
	//echo '['.$date_to.']';
	if ($date_to=="")
	{
	//echo "aaa";
	 $temp4=mssql_query("SELECT str(SUM(InQty)) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ");
	 }else
	 {
	  $temp4=mssql_query("SELECT str(SUM(InQty)) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <  convert(datetime, '$date_from', 120)");
	  
	 }
	$r4=mssql_fetch_array($temp4);
	$temp9=mssql_query("SELECT str(SUM(Quantity)) as qty_out FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r9=mssql_fetch_array($temp9);
	$temp6=mssql_query("SELECT str(SUM(Quantity)) as qty_in FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r6=mssql_fetch_array($temp6);
	$temp7=mssql_query("SELECT str(SUM(Quantity)) qty_in  FROM PDN1 WHERE ItemCode ='$item' AND WhsCode ='$plant'  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r7=mssql_fetch_array($temp7);
	 $like_date=substr($date_from,0,7);
	  
    $temp81=mssql_query("SELECT str(SUM(Quantity)) as qty_ajt FROM IGN1 WHERE ItemCode='$item' AND WhsCode='$plant' AND CONVERT(VARCHAR(24),DocDate,120) like '%$like_date%'");
	$r81=mssql_fetch_array($temp81);
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td><span class="style5">&nbsp;
      <?=$r1['U_Small'];?>
    </span></td>
    <td><span class="style5">&nbsp;
    <?php
	$uom=$r1['IUoMEntry'];
    $temp2=mssql_query("SELECT UomCode FROM OUOM WHERE UomEntry ='$uom'");
	$r2=mssql_fetch_array($temp2);
	echo $r2['UomCode'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td align="left"><span class="style5">
      &nbsp;
      <?php
	$temp3=mssql_query("SELECT str(Onhand)Onhand,MinStock,MaxStock FROM OITW WHERE ItemCode ='$item' AND WhsCode ='$plant'");
	$r3=mssql_fetch_array($temp3);
	echo $r4['bgn']-$r9['qty_out']+$r6['qty_in']+$r7['qty_in']+$r81['qty_ajt'];
	//echo "$r4[bgn]-$r9[qty_out]+$r6[qty_in]+$r7[qty_in]+$r81[qty_ajt]";
	?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td width="81"><span class="style5">&nbsp;
    <?=$r3['MinStock'];?></span></td>
    <td width="71"><span class="style5">&nbsp;
    <?=$r3['MaxStock'];?></span></td>
    <td><span class="style5">&nbsp;
      <?php
	 
	echo $r81['qty_ajt'];
	//echo "SELECT SUM(Quantity) as qty_ajt FROM IGN1 WHERE ItemCode='$item' AND WhsCode='$plant' AND CONVERT(VARCHAR(24),DocDate,120) like '%$like_date%'";
	?>
    </span></td>
    <td><span class="style5">&nbsp;
    <?php
  
	echo $r4['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php
    $temp5=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	echo "Transfer :";
	while ($r5=mssql_fetch_array($temp5))
	{
	echo $r5['DocEntry'].', ';
	}
	echo "<br> GR PO :";
	$temp7=mssql_query("SELECT DocEntry  FROM PDN1 WHERE ItemCode ='$item' AND WhsCode ='$plant'  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while ($r7=mssql_fetch_array($temp7))
	{
	echo $r7['DocEntry'].', ';
	}
	
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?></span></td>
    <td><span class="style5">&nbsp;
    <?php $temp6=mssql_query("SELECT str(SUM(Quantity)) as qty_in FROM WTR1 WHERE ItemCode ='$item' AND WhsCode ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	echo "Transfer :";
	$r6=mssql_fetch_array($temp6);
	echo $r6['qty_in'];
	echo "<br> GR PO :";
	$temp7=mssql_query("SELECT str(SUM(Quantity)) qty_in  FROM PDN1 WHERE ItemCode ='$item' AND WhsCode ='$plant'  AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	$r7=mssql_fetch_array($temp7);
	echo $r7['qty_in'];
	?></span></td>
    <td><span class="style5">&nbsp;
      <?php
    $temp8=mssql_query("SELECT DocEntry FROM WTR1 WHERE ItemCode ='$item' AND FromWhsCod ='$plant' AND U_Retur <> 1 AND DocDate <=  convert(datetime, '$date_to2', 120) AND DocDate >=  convert(datetime, '$date_from', 120)");
	while ($r8=mssql_fetch_array($temp8))
	{
	echo $r8['DocEntry'].', ';
	}
	?>
    </span></td>
    <td><span class="style5"> &nbsp;
    <?php
	echo $r9['qty_out'];
	?></span></td>
  </tr>
  <?php } ?>
  <tr>
    <td>&nbsp;</td>
  
    <td><span class="style5"></span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    
    
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td>&nbsp;</td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
  </tr>
  
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
  </tr>
</table>
  
</body>

</html>