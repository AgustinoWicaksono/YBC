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
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
$transit='T.'.$plant;
$row_count_to_show_header = 30;
if ($grup_item != "")
{
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
 and c.U_icecream=1
 group by a.ItemCode,a.LocCode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock 
";
}
else
{
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
 and c.U_icecream=1
 group by a.ItemCode,a.LocCode,c.ItemName,c.U_Small,c.InvntryUom,d.MinStock,d.MaxStock";
}
$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Ice Cream</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="1391" border="1" align="center" class="table">
  <tr>
    <td width="81" align="center" bgcolor="#999999"><strong><span class="style5">Code</span><strong></strong></td>
    <td width="190" align="center" bgcolor="#999999"><strong><span class="style5">Item</span></strong></td>
    <td width="53" align="center" bgcolor="#999999"><strong><span class="style5">UOM</span></strong></td>
    <td width="80" align="center" bgcolor="#999999"><strong><span class="style5">BEGINNING</span></strong></td>
    <td width="67" align="center" bgcolor="#999999"><strong><span class="style5">No Req</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty Req</span></strong></td>
    <td width="74" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="64" align="center" bgcolor="#999999"><strong><span class="style5">Sold</span></strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong><span class="style5">No Spoiled</span></strong></td>
    <td width="53" align="center" bgcolor="#999999"><strong><span class="style5">Spoiled</span></strong></td>
    <td width="60" align="center" bgcolor="#999999"><strong><span class="style5">No Transfer</span></strong></td>
    <td width="59" align="center" bgcolor="#999999"><strong><span class="style5">Transfer Out</span></strong></td>
    <td width="86" align="center" bgcolor="#999999"><strong><span class="style5">Physical Ending</span></strong></td>
    <td width="86" align="center" bgcolor="#999999"><strong><span class="style5">Total Consume</span></strong></td>
    <td width="80" align="center" bgcolor="#999999"><strong><span class="style5">Ideal Consume</span></strong></td>
    <td width="79" align="center" bgcolor="#999999"><strong><span class="style5">Variance</span></strong></td>
    <td width="99" align="center" bgcolor="#999999"><strong><span class="style5">Remarks</span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mssql_fetch_array($tmp))
	{
?>
  <tr>
  
    <td align="left"><span class="style5">&nbsp;
      <?=$r['itemcode'];?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?=$r['ItemName'];?>
    </span></td>
    <td><span class="style5">
    &nbsp;
    <?=$r['InvntryUom'];?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?=substr($r['stock_awal'],0,-4);?>
    </span></td>
    <td><span class="style5">&nbsp;
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
    <td><span class="style5">&nbsp;
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
    <td><span class="style5">&nbsp;
      <?php $onhand=$r['stock_awal']+$r6['In_sr'];
	echo $onhand; ?>
    </span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;
      <?php
	$item=$r['itemcode'];
    $temp7=mssql_query("
select distinct b.docnum no_retur from  oige b, ige1 c,oivl d, oitm e
where  d.BASE_REF=c.DocEntry
and  b.docentry=c.DocEntry
and d.transtype = '60'
and d.OutQty <> 0
and e.itemcode = d.ItemCode
and c.U_Waste =1
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
    </span></td>
    <td><span class="style5">
      <?php
	$item=$r['itemcode'];
    $temp20=mssql_query("
select sum(b.Quantity) qty_spoiled
from
OIGE a,
IGE1 b,
 oitm e
where  a.docentry = b.DocEntry 
and e.itemcode = b.ItemCode 
and e.itemcode ='$item'
and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
and b.WhsCode='$plant'
and b.U_Waste=1
");

$r20=mssql_fetch_array($temp20);
	echo substr($r20['qty_spoiled'],0,-4);
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td><span class="style5">&nbsp;&nbsp;
      <?php
	$item=$r['itemcode'];
    $temp6=mssql_query("
	select b.DocNum no_tf from owtr b, wtr1 c,oitm e
where  b.docentry=c.DocEntry
and e.itemcode = c.ItemCode
and c.ItemCode='$item'
and c.FromWhsCod='$plant'
and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)
");
	while ($r6=mssql_fetch_array($temp6))
	{
	echo $r6['no_tf'].', ';
	}
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?php
	$item=$r['itemcode'];
    $temp5=mssql_query("
	select sum(c.Quantity) qty_tf from owtr b, wtr1 c,oitm e
where  b.docentry=c.DocEntry
and e.itemcode = c.ItemCode
and c.ItemCode='$item'
and c.FromWhsCod='$plant'
and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)
");

$r5=mssql_fetch_array($temp5);
	echo substr($r5['qty_tf'],0,-4);
	
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td><span class="style5">
    &nbsp;
    <?php
	  $item=$r['itemcode'];
    $temp13=mssql_query("SELECT COALESCE(SUM(CountQty),0) CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant' AND CountDate =  convert(datetime, '$date_to', 120) AND CountDate >=  convert(datetime, '$date_from', 120)");
$r13=mssql_fetch_array($temp13);
	echo substr($r13['CountQty'],0,-4);
	?>
    </span></td>
    <td><span class="style5">
    &nbsp;
    <?php
    $consume=$onhand-$r20['qty_spoiled']-$r5['qty_tf']-$r13['CountQty'];
	echo $consume;
	?>
    </span></td>
    <td>&nbsp;</td>
    <td><span class="style5">
    &nbsp;&nbsp;
    <?php
    $consume=$onhand-$r20['qty_spoiled']-$r5['qty_tf']-$r13['CountQty'];
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