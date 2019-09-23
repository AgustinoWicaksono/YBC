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
$swbQuery = "select a.LocCode code_item,a.BASE_REF DOC_NUM,a.InQty,a.OutQty,
(select SUM((b.InQty)-(b.OutQty)) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode and b.DocDate < convert(datetime, '$date_from', 120))stock_awal,
(select SUM(b.InQty-b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode and b.DocDate <= convert(datetime, '$date_from', 120)) stock_akhir
  from OIVL a
WHERE a.LocCode='$plant'
AND a.DocDate = convert(datetime, '$date_from', 120) 
";
}
else
{
$swbQuery = "select a.LocCode code_item,a.BASE_REF DOC_NUM,a.InQty,a.OutQty,
(select SUM((b.InQty)-(b.OutQty)) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode and b.DocDate < convert(datetime, '$date_from', 120))stock_awal,
(select SUM(b.InQty-b.OutQty) from OIVL b where a.loccode =b.loccode and a.ItemCode = b.ItemCode and b.DocDate <= convert(datetime, '$date_from', 120)) stock_akhir
  from OIVL a
WHERE a.LocCode='$plant'
AND a.DocDate = convert(datetime, '$date_from', 120) ";
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
        <td width="106" rowspan="3" align="center" bgcolor="#999999"><span class="style5"><strong>Code</span><strong></td>
        <td width="64" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Name</span></td>
        <td colspan="2" rowspan="2" align="center" bgcolor="#999999"><span class="style5">UNIT</span></td>
        <td width="152" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Stock On Hand</span></td>
        <td width="130" rowspan="3" align="center" bgcolor="#999999"><span class="style5">Expired Date</span></td>
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
        <td width="64" align="center" bgcolor="#999999"><span class="style5">Small</span></td>
        <td width="64" align="center" bgcolor="#999999"><span class="style5">Pack</span></td>
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
              <?=$r['code_item'];?>
        </span></td>
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
	?>
        </span></td>
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
	?>
        </span></td>
        <td align="left"><span class="style5"> &nbsp;
          <?php echo $r2['stock_akhir'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?>
        </span></td>
        <td><span class="style5">&nbsp;</span></td>
        <td><span class="style5">&nbsp;
              <?=$r3['MinStock'];?>
        </span></td>
        <td><span class="style5">&nbsp;
              <?=$r3['MaxStock'];?>
        </span></td>
        <td><span class="style5">&nbsp;
              <?php
  
	echo $r4['bgn'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
	?>
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
              <?php $temp6=mssql_query("select sum(a.InQty) InQty,sum(a.OutQty)OutQty from OIVL a
WHERE a.LocCode='$plant'
AND a.DocDate=convert(datetime, '$date_from', 120) ");
	echo "Transfer :";
	$r6=mssql_fetch_array($temp6);
	echo $r6['InQty'];
	?>
        </span></td>
        <td><span class="style5">&nbsp;
              <?php
    $temp8=mssql_query("SELECT b.DocEntry DocEntry FROM OIGE a , igE1 b WHERE a.DocEntry=b.DocEntry and  b.WhsCode ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120) 
union
SELECT b.DocEntry DocEntry FROM OWTR a , WTR1 b WHERE a.DocEntry=b.DocEntry and  b.FromWhsCod ='$plant' AND a.DocDate =convert(datetime, '$date_from', 120)");
	while ($r8=mssql_fetch_array($temp8))
	{
	echo $r8['DocEntry'].', ';
	}
	?>
        </span></td>
        <td><span class="style5"> &nbsp;
              <?php
	echo echo $r6['OutQty'];;
	?>
        </span></td>
        <td><span class="style5"><?php echo $r2['stock_akhir'];
	//echo "SELECT SUM(InQty) as  bgn FROM OIVL WHERE ItemCode='$item' AND LocCode='$plant' AND DocDate <=  convert(datetime, '$date_from', 120) ";
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