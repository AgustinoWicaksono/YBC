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
.style13 {
	font-size: 10px;
	font-weight: bold;
}
.style14 {font-size: 10px}
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
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "select a.DocDate,a.docnum doc_num, b.quantity qty_in, b.unitMsr, b.WhsCode, b.FromWhsCod ,
(SELECT D.QUANTITY FROM WTR1 D WHERE D.ItemCode=B.ItemCode AND D.WhsCode LIKE 'T.%' and d.FromWhsCod='05WHST' ) qty_out,
((SELECT D.QUANTITY FROM WTR1 D WHERE D.ItemCode=B.ItemCode AND D.WhsCode LIKE 'T.%'and d.FromWhsCod='05WHST' )
-b.quantity) jml from owtr a, WTR1 b 
where a.DocEntry=b.DocEntry
and  a.DocNum in (182,181,184)
and WhsCode='$plant'
and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
";
}
else
{
$swbQuery = "select a.DocDate,a.docnum doc_num, b.ItemCode,b.Dscription,b.quantity qty_in, b.unitMsr, b.WhsCode, b.FromWhsCod ,
(SELECT D.QUANTITY FROM WTR1 D WHERE D.ItemCode=B.ItemCode AND D.WhsCode LIKE 'T.%' and d.FromWhsCod='05WHST' ) qty_out,
((SELECT D.QUANTITY FROM WTR1 D WHERE D.ItemCode=B.ItemCode AND D.WhsCode LIKE 'T.%'and d.FromWhsCod='05WHST' )
-b.quantity) jml from owtr a, WTR1 b 
where a.DocEntry=b.DocEntry
and   a.DocNum in (182,181,184)
and WhsCode='$plant'
and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)";
}
//echo $swbQuery;

$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Summary Variance</strong></h3></td>
  </tr>
</table>
    <table style="border-collapse:collapse;" width="960" border="1" align="center" class="table">
      
      <tr>
        <td width="27" height="24" align="center" bgcolor="#999999"><span class="style12">No</span></td>
        <td width="99" align="center" bgcolor="#999999"><span class="style12">Tanggal</span></td>
        <td width="59" align="center" bgcolor="#999999"><span class="style12">CODE</span></td>
        <td width="217" align="center" bgcolor="#999999"><span class="style12">ITEM</span></td>
        <td width="51" align="center" bgcolor="#999999"><span class="style13">Qty Variance</span></td>
        <td width="52" align="center" bgcolor="#999999"><span class="style12">Uom</span></td>
        <td width="159" align="center" bgcolor="#999999"><span class="style12">Outlet Pengirim</span></td>
        <td width="138" align="center" bgcolor="#999999"><span class="style12">Outlet Penerima</span></td>
        <td width="86" align="center" bgcolor="#999999"><span class="style12">No Doc</span></td>
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
        <td align="left"><span class="style5">
          &nbsp;
          <?=$r['DocDate'];?>
&nbsp;        </span></td>
        <td align="center"><span class="style5">
          <?=$r['ItemCode'];?>
        </span></td>
        <td><span class="style5">
          &nbsp;
          <?=$r['Dscription'];?>
        </span></td>
        <td align="center"><span class="style5">
          <?=$r['qty_out']-$r['qty_in'];?>
        </span></td>
  <td align="center"><span class="style5">
          <?=$r['unitMsr'];?>
        </span></td>
<td align="center"><span class="style14">Gudang Sentul</span></td>
      <td align="center"><span class="style5"><?=$plant_name;?>
      </span></td>
  <td align="center"><span class="style5">
        <?=$r['doc_num'];?>
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
      </tr>
    </table>
<p>&nbsp;</p>
</body>

</html>