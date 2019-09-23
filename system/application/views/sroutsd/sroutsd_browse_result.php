<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));

$plant = $this->session->userdata['ADMIN']['plant'];
$plant_name = $this->session->userdata['ADMIN']['plant_name'];
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
.style14 {font-size: 12px; font-weight: bold; }
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
$transit='T.'.$plant;
$cekG=mssql_fetch_array(mssql_query("SELECT ItmsGrpCod FROM OITB WHERE ItmsGrpNam='$item_group_code'"));
$grup_item=$cekG['ItmsGrpCod'];
if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "select a.DocDate, a.DocNum, b.LineNum, a.DocStatus,b.ItemCode, b.Dscription, str(b.OpenQty) Quantity, b.unitMsr, b.WhsCode ,
(select WhsName from OWHS where WhsCode=b.FromWhsCod) sr_whsto, (select SUBSTRING(WhsName,8,50)from OWHS where WhsCode=b.WhsCode) sr_whsfrom from OWTQ a, wtq1 b
where a.DocEntry= b.DocEntry
And b.OpenQty is not null
and a.CANCELED ='N'
and b.LineStatus <> 'C'
and b.WhsCode='$transit'
and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
";
}
else
{
$swbQuery = "select a.DocDate, a.DocNum, b.LineNum, a.DocStatus,b.ItemCode, b.Dscription, str(b.OpenQty) Quantity, b.unitMsr, b.WhsCode ,
(select WhsName from OWHS where WhsCode=b.FromWhsCod) sr_whsto, (select SUBSTRING(WhsName,8,50) from OWHS where WhsCode=b.WhsCode) sr_whsfrom from OWTQ a, wtq1 b
where a.DocEntry= b.DocEntry
 And b.OpenQty is not null
and a.CANCELED ='N'
and b.LineStatus <> 'C'
and b.WhsCode='$transit'
and a.DocDate <=  convert(datetime, '$date_to', 120) AND a.DocDate >=  convert(datetime, '$date_from', 120)
";
}
//echo $swbQuery;

$tmp=mssql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Outstanding SR</strong></h3></td>
  </tr>
</table>
    <table width="1013" border="1" align="center" class="table" style="border-collapse:collapse;">
      <tr>
        <td width="37" align="center" bgcolor="#999999"><span class="style14">No</span></td>
        <td width="127" align="center" bgcolor="#999999"><span class="style14">Tanggal</span></td>
        <td width="61" align="center" bgcolor="#999999"><span class="style14">No SR</span></td>
        <td width="81" align="center" bgcolor="#999999"><span class="style14">No Line SR</span></td>
        <td width="74" align="center" bgcolor="#999999"><span class="style14">CODE</span></td>
        <td width="190" align="center" bgcolor="#999999"><span class="style14">ITEM</span></td>
        <td width="89" align="center" bgcolor="#999999"><span class="style14">Quantity</span></td>
        <td width="59" align="center" bgcolor="#999999"><span class="style14">Uom</span></td>
        <td width="113" align="center" bgcolor="#999999"><span class="style14">Outlet From</span></td>
        <td width="118" align="center" bgcolor="#999999"><span class="style14">Outlet To</span></td>
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
        <td align="left"><span class="style5"> &nbsp;
              <?=$r['DocDate'];?>
        </span></td>
        <td align="center"><span class="style5"> &nbsp;
              <?=$r['DocNum'];?>
        </span></td>
        <td align="center"><span class="style5">
          <?=$r['LineNum']+1;?>
        </span></td>
        <td align="center"><span class="style5">
          <?=$r['ItemCode'];?>
        </span></td>
        <td><span class="style5"> &nbsp;
              <?=$r['Dscription'];?>
        </span></td>
        <td align="center"><span class="style5">
          <?=$r['Quantity'];?>
        </span></td>
        <td align="center"><span class="style5"> &nbsp;
              <?=$r['unitMsr'];?>
        </span></td>
        <td align="center"><span class="style5">
          <?=$r['sr_whsfrom'];?>
        </span></td>
        <td align="center"><span class="style5"> &nbsp;
              <?=$r['sr_whsto'];?>
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
      </tr>
    </table>
<p>&nbsp;</p>
</body>

</html>