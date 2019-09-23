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
.style12 {font-size: 10px}
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
//$c=mssql_connect("192.168.0.20","sa","abc123?");
//$b=mssql_select_db('MSI',$c);
$con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
$trans=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT U_TransFor FROM OWHS WHERE WhsCode='$plant'"));
$transit=$trans['U_TransFor'];
$row_count_to_show_header = 30;
$cekG=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
//echo '{'.$grup_kode.'}';
$swbQuery = "SELECT B.ItemCode,B.ItemName,B.SVolume,B.InvntryUom,A.OnHand FROM OITW A 
JOIN OITM B ON A.ItemCode=B.ItemCode WHERE A.WhsCode='$plant' AND B.ItmsGrpCod='$grup_kode' AND A.OnHand >0";
}
else
{
	$swbQuery = "SELECT B.ItemCode,B.ItemName,B.SVolume,B.InvntryUom,A.OnHand FROM OITW A 
JOIN OITM B ON A.ItemCode=B.ItemCode WHERE A.WhsCode='$plant' AND A.OnHand >0";
}
//echo $swbQuery;

$tmp=sqlsrv_query($con,$swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Inventory Movement</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="1284" border="1" align="center" class="table">
  <tr>
    <td width="25" rowspan="3" align="center" bgcolor="#999999"><span class="style5">No</span></td>
    <td width="77" rowspan="3" align="center" bgcolor="#999999"><span class="style5"><strong>Code</span><strong></td>
    <td width="165" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Name</span></td>
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">UNIT</span></td>
    <td width="81" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Stock On Hand</span></td>
    <!--td width="90" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Expired Date</span></td-->
    <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Outstanding</span><span class="style5"></span></td>
    <td width="86" rowspan="3" align="center" bgcolor="#999999"><span class="style5"><span class="style12">Available</span>  Stock</span></td>
    <!--td colspan="4" align="center" bgcolor="#999999"><span class="style5">Date <?=' : '.$date_from;?></span></td-->
    <!--td width="93" rowspan="3" align="center" bgcolor="#999999"><span class="style12">Ending Stock</span></td-->
  </tr>
  <tr>
    <!--td width="86" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
    <td width="73" rowspan="2" align="center" bgcolor="#999999"><span class="style5">In</span></td>
    <!--td width="78" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Doc No</span></td>
    <!--td width="73" rowspan="2" align="center" bgcolor="#999999"><span class="style5">Out</span></td-->
  </tr>
  <tr>
    <td width="60" align="center" bgcolor="#999999"><span class="style5">Small</span></td>
    <td width="62" align="center" bgcolor="#999999"><span class="style5">Pack</span></td>
    <td width="75" align="center" bgcolor="#999999"><span class="style5">In</span></td>
    <td width="66" align="center" bgcolor="#999999"><span class="style5">Out</span></td>
  </tr>
  <?php
  $no=1;
	while($r=sqlsrv_fetch_array($tmp))
	{
	
?>
  <tr>
    <td align="center"><span class="style5">
      <?=$no++;?>
    </span></td>
    <td><span class="style5">&nbsp;
    <?=$r['ItemCode'];?></span></td>
    <td><span class="style5">&nbsp;
      <?=$r['ItemName'];?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?=$r['SVolume'];?>
    </span></td>
    <td><span class="style5">&nbsp;
      <?=$r['InvntryUom'];?>
    </span></td>
    <td align="left"><span class="style5">
    &nbsp;
    <?=substr($r['OnHand'],0,-4);?>
    </span></td>
    <!--td><span class="style5">&nbsp;</span></td-->
    <td width="75"><span class="style5">&nbsp;
    <?php $Query1=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OnHand FROM OITW WHERE WhsCode='$transit' AND ItemCode='$r[ItemCode]'")); 
	$Query2=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT ISNULL(SUM(OpenQty),0) AS OpenQty FROM POR1 WHERE ItemCode='$r[ItemCode]' AND LineStatus='O' AND WhsCode='$plant'"));
	echo $Query1['OnHand']+$Query2['OpenQty'];
	?></span></td>
    <td width="66"><span class="style5">&nbsp;
    <?php
	$Query3=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT  ISNULL(SUM(OpenQty),0) AS OpenQty  FROM WTQ1 WHERE LineStatus='O' AND WhsCode='$plant' AND ItemCode='$r[ItemCode]'"));
	echo $Query3['OpenQty'];
	?></span></td>
    <td><span class="style5">&nbsp;
      <?php
	  $ending=($r['OnHand']+$Query1['OnHand']+$Query2['OpenQty'])-$Query3['OpenQty'];
	  echo $ending;
	  ?>
    </span></td>
    <!--td><span class="style5">&nbsp;
    <?php
	$item=$r['itemcode'];
    $temp5=sqlsrv_query($con,"select distinct b.BASE_REF doc_in from oivl a ,oivl b,oitm c 
	   where a.itemcode=b.ItemCode
	   and a.ItemCode=c.ItemCode
	   and a.ItemCode='$item'
	   and c.U_store=1 
	   and b.LocCode=a.LocCode 
	   and b.InQty<> 0 
	   and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)
	   and a.LocCode = '$plant' 
");
	
	while ($r5=sqlsrv_fetch_array($temp5))
	{
	echo $r5['doc_in'].', ';
	}
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?></span></td>
    <!--td><span class="style5">&nbsp;
      <?=substr($r['inqty'],0,-4);?>
    </span></td>
    <!--td><span class="style5">&nbsp;
      <?php
	$item=$r['itemcode'];
    $temp5=sqlsrv_query($con,"select distinct b.BASE_REF doc_out from oivl a ,oivl b,oitm c 
	   where a.itemcode=b.ItemCode
	   and a.ItemCode=c.ItemCode
	   and a.ItemCode='$item'
	   and c.U_store=1 
	   and b.LocCode=a.LocCode 
	   and b.OutQty<> 0 
	   and b.DocDate <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)
	   and a.LocCode = '$plant' 
");
	
	while ($r5=sqlsrv_fetch_array($temp5))
	{
	echo $r5['doc_out'].', ';
	}
	sqlsrv_close($con);		
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <!--td><span class="style5"> &nbsp;
      <?=substr($r['outqty'],0,-4);?>
    </span></td>
    <!--td><span class="style5">
    &nbsp;
    <?=substr($r['stock_akhir'],0,-4);?>
    </span></td-->
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
    <!--td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <td><span class="style5">&nbsp;</span></td>
    <!--td><span class="style5">&nbsp;</span></td-->
    <!--td>&nbsp;</td-->
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
    <!--td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <!--td>&nbsp;</td>
    <!--td>&nbsp;</td-->
  </tr>
</table>
  
</body>

</html>