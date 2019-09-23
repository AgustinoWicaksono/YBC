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
.style12 {
	font-size: 12px;
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
<?=$date_from;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
$row_count_to_show_header = 30;
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "select a.LocCode,a.ITEMCODE code,m.ItemName name,m.InvntryUom uom,m.U_Small U_Small,SUM(InQty-OutQty) ONHAND,
 (select o.MinStock from OITW o
 where o.ItemCode=a.ItemCode and a.LocCode=o.WhsCode) MinStock ,  (select o.MaxStock  from OITW o
 where o.ItemCode=a.ItemCode  and a.LocCode=o.WhsCode) MaxStock,
(select SUM((b.InQty)-(b.OutQty)) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND a.DocDate < convert(datetime, '$date_from', 120) )stock_awal,
(select SUM(b.InQty-b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode  AND a.DocDate <= convert(datetime, '$date_from', 120) ) stock_akhir
 from OIVL A,OITM M
WHERE a.LocCode='$plant'
AND a.DocDate <= convert(datetime, '$date_from', 120) 
and m.ItemCode=a.ItemCode
GROUP BY  a.LocCode,a.ITEMCODE,m.ItemName,m.InvntryUom,a.DocDate,m.U_Small
";
}
else
{
$swbQuery = "select a.LocCode,a.ITEMCODE code,m.ItemName name,m.InvntryUom uom,m.U_Small U_Small,SUM(InQty-OutQty) ONHAND,
(select MinStock from OITW o
 where o.ItemCode=a.ItemCode  and a.LocCode=o.WhsCode) MinStock , (select MaxStock  from OITW o
 where o.ItemCode=a.ItemCode and a.LocCode=o.WhsCode) MaxStock,
(select SUM((b.InQty)-(b.OutQty)) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND a.DocDate < convert(datetime, '$date_from', 120) )stock_awal,
(select SUM(b.InQty-b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode  AND a.DocDate <= convert(datetime, '$date_from', 120) ) stock_akhir
 from OIVL A,OITM M
WHERE a.LocCode='$plant'
AND a.DocDate <= convert(datetime, '$date_from', 120) 
and m.ItemCode=a.ItemCode
GROUP BY  a.LocCode,a.ITEMCODE,m.ItemName,m.InvntryUom,a.DocDate,U_Small";
}
//echo $swbQuery;

$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong> Store</strong> Daily</h3></td>
  </tr>
</table>
    <table width="1413" border="1" align="center" class="table" style="border-collapse:collapse;">
      <tr>
        <td width="54" rowspan="3" align="center" bgcolor="#999999"><span class="style5">No</span></td>
        <td width="75" rowspan="3" align="center" bgcolor="#999999"><span class="style5"><strong>Code</span><strong></td>
        <td width="150" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Name</span></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">UNIT</span></td>
        <td width="104" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Stock On Hand</span></td>
        <td width="116" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Expired Date</span></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Part Stock</span><span class="style5"></span></td>
        <td width="134" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Beginning Stock</span></td>
        <td colspan="4" align="center" bgcolor="#999999"><span class="style5">Date
          <?=' : '.$date_from;?>
        </span></td>
        <td width="95" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Ending  Stock</span></td>
      </tr>
      <tr>
        <td width="95" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
        <td width="81" rowspan="2" align="center" bgcolor="#999999"><span class="style5">In</span></td>
        <td width="72" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
        <td width="80" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Out</span></td>
      </tr>
      <tr>
        <td width="68" align="center" bgcolor="#999999"><span class="style5">Small</span></td>
        <td width="67" align="center" bgcolor="#999999"><span class="style5">Pack</span></td>
        <td width="64" bgcolor="#999999"><span class="style5">Min</span></td>
        <td width="64" bgcolor="#999999"><span class="style5">Max</span></td>
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
              <?=$r['code'];?>
        </span></td>
        <td><span class="style5"><?=$r['name'];?>&nbsp;</span></td>
        <td><span class="style5">&nbsp;
              <?=$r['U_Small'];?>
        </span></td>
        <td><span class="style5">&nbsp;
          <?=$r['uom'];?>
        </span></td>
        <td align="left"><span class="style5"> &nbsp;
          <?=$r['stock_akhir'];?>
        </span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;
          <?=$r['MinStock'];?>
        </span></td>
        <td><span class="style5">&nbsp;
          <?=$r['MaxStock'];?>
        </span></td>
        <td><span class="style5">&nbsp;
          <?=$r['stock_awal'];?>
        </span></td>
  <td><span class="style5">&nbsp;
    <?php $temp5=mssql_query("
SELECT b.DocEntry DocEntry FROM OPDN a , PDN1 b WHERE a.DocEntry=b.DocEntry  AND b.WhsCode ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120) 
union
SELECT b.DocEntry  DocEntry FROM OWTR a , WTR1 b WHERE a.DocEntry=b.DocEntry AND b.WhsCode ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120) 
union
SELECT b.DocEntry DocEntry FROM OIGN a , ign1 b WHERE a.DocEntry=b.DocEntry  AND b.WhsCode ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120) 
union
SELECT b.DocEntry DocEntry FROM OIQI a , IQI1 b WHERE a.DocEntry=b.DocEntry  AND b.WhsCode ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120) ");
$r5=mssql_fetch_array($temp5);
while ($r5=mssql_fetch_array($temp5))
	echo $r5['DocEntry'].', ';

	?>
  </span></td>
  <td><span class="style5">&nbsp;
    <?php 
	$item=$r['code'];
	$temp6=mssql_query("select 
(select SUM(b.InQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND b.DocDate = convert(datetime, '$date_from', 120) )qty_in,
 (select SUM(b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND b.DocDate = convert(datetime, '$date_from'', 120) ) qty_out
  from OIVL A,OITM M WHERE a.LocCode='$plant' AND a.DocDate = convert(datetime, '$date_from', 120) and m.ItemCode=a.ItemCode 
  and a.ItemCode='$item'
GROUP BY a.LocCode,a.ITEMCODE,m.ItemName,m.InvntryUom,a.DocDate
");
$r6=mssql_fetch_array($temp6);
	echo $r6['InQty'];
	?>
  </span></td>
  <td><span class="style5">&nbsp;</span></td>
  <td><span class="style5"> &nbsp;
    <?php 
	$item=$r['code'];
	$temp7=mssql_query("
select 
(select SUM(b.InQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND b.DocDate = convert(datetime, '$date_from', 120) )qty_in,
 (select SUM(b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode AND b.DocDate = convert(datetime, '$date_from'', 120) ) qty_out
  from OIVL A,OITM M WHERE a.LocCode='$plant' AND a.DocDate = convert(datetime, '$date_from', 120) and m.ItemCode=a.ItemCode 
  and a.ItemCode='$item'
GROUP BY a.LocCode,a.ITEMCODE,m.ItemName,m.InvntryUom,a.DocDate
");
$r7=mssql_fetch_array($temp7);
	echo $r7['OutQty'];
	?>
  </span></td>
        <td><span class="style5">
          <?=$r['stock_akhir'];?>
        </span></td>
      </tr>
      <?php } ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td>&nbsp;</td>
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
      </tr>
    </table>
<p>&nbsp;</p>
</body>

</html>