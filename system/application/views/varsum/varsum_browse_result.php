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
<?=$date_from;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;
$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
$b=mssql_select_db('MSI_GO',$c);
mysql_connect("localhost","root","");
mysql_select_db("sap_php");
$row_count_to_show_header = 30;
$swbQuery="SELECT MATNR,MAKTX from m_item
where MATNR IN (SELECT material_no from t_grpodlv_detail JOIN t_grpodlv_header ON t_grpodlv_header.id_grpodlv_header=t_grpodlv_detail.id_grpodlv_header WHERE plant='$plant' AND var >0) 
OR 
MATNR IN (SELECT material_no from t_grsto_detail JOIN t_grsto_header ON t_grsto_header.id_grsto_header=t_grsto_detail.id_grsto_header WHERE plant='$plant' AND var >0) OR 
MATNR IN (SELECT material_no from t_grpodlv_dept_detail JOIN t_grpodlv_dept_header ON t_grpodlv_dept_header.id_grpodlv_dept_header=t_grpodlv_dept_detail.id_grpodlv_dept_header WHERE plant='$plant' AND var >0)";
$tmp=mysql_query($swbQuery);
?>
	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>Summary Variance</strong> 3</h3></td>
  </tr>
</table>
<table  style="border-collapse:collapse;" width="604" border="1" align="center" class="table">
  <tr>
    <td width="72" align="center" bgcolor="#999999"><strong><span class="style5">No</span></strong></td>
    <td width="72" align="center" bgcolor="#999999"><strong><span class="style5">Tanggal</span></strong></td>
    <td width="72" align="center" bgcolor="#999999"><strong><span class="style5"><strong>Item</span><strong></strong></td>
    <td width="168" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td width="49" align="center" bgcolor="#999999"><strong><span class="style5">Qty</span></td>
    <td width="49" align="center" bgcolor="#999999"><strong><span class="style5">UOM</span></strong></td>
    <td width="76" align="center" bgcolor="#999999"><strong><span class="style5">Lokasi/Outlet</span></strong></td>
  </tr>
  <?php
  $no=1;
	while($r=mysql_fetch_array($tmp))
	{
	$item=$r['MATNR'];
?>
  <tr>
    <td><span class="style5"><?=$no++;?></span></td>
  
    <td><span class="style5"><?php $r1F=mysql_fetch_array(mysql_query("SELECT posting_date AS posting_date FROM t_grpodlv_dept_detail 
	JOIN t_grpodlv_dept_header ON t_grpodlv_dept_detail.id_grpodlv_dept_header = t_grpodlv_dept_header.id_grpodlv_dept_header 
	WHERE material_no='$item' AND plant ='$plant' AND val is not null"));?>
    
	</span></td>
    <td><span class="style5"><?=$r['MATNR'];?></span></td>
    <td><span class="style5"><?=$r['MAKTX'];?></span></td>
    <td><span class="style5"><?php
    $r1=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grpodlv_detail 
	JOIN t_grpodlv_header ON t_grpodlv_detail.id_grpodlv_header = t_grpodlv_header.id_grpodlv_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=0 "));
	$r1A=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grpodlv_detail 
	JOIN t_grpodlv_header ON t_grpodlv_detail.id_grpodlv_header = t_grpodlv_header.id_grpodlv_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=2 "));
	 $r1B=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grsto_detail 
	JOIN t_grsto_header ON t_grsto_detail.id_grsto_header = t_grsto_header.id_grsto_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=0 "));
	$r1C=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grsto_detail 
	JOIN t_grsto_header ON t_grsto_detail.id_grsto_header = t_grsto_header.id_grsto_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=2 "));
	$r1D=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grpodlv_dept_detail 
	JOIN t_grpodlv_dept_header ON t_grpodlv_dept_detail.id_grpodlv_dept_header = t_grpodlv_dept_header.id_grpodlv_dept_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=0 "));
	$r1E=mysql_fetch_array(mysql_query("SELECT SUM(var) AS var FROM t_grpodlv_dept_detail 
	JOIN t_grpodlv_dept_header ON t_grpodlv_dept_detail.id_grpodlv_dept_header = t_grpodlv_dept_header.id_grpodlv_dept_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=2 "));
	if ($r1['var']==""  )
{
$var1=0;
}else 
{
$var1=$r1['var'];
}
if ($r1B['var']=="")
{
$var2=0;
}else 
{
$var2=$r1B['var'];
}
if ($r1A['var']=="")
{
$var3=0;
}else
{
$var3=$r1A['var'];
} 
if ($r1C['var']=="")
{
$var4=0;
}else
{
$var4=$r1C['var'];
}
if ($r1D['var']=="")
{
$var5=0;
}else
{
$var5=$r1D['var'];
}
if ($r1E['var']=="")
{
$var6=0;
}else
{
$var6=$r1E['var'];
}
$variance=$var1+$var3+$var5;
$lost=$var2+$var4+$var6;

	echo 'Var :'.$variance.'<br>';
	echo 'Lost :'.$lost.'<br>';
	
	?></span></td>
    <td><span class="style5"><?php
    $r2=mysql_fetch_array(mysql_query("SELECT uom FROM t_grpodlv_detail 
	JOIN t_grpodlv_header ON t_grpodlv_detail.id_grpodlv_header = t_grpodlv_header.id_grpodlv_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=0"));
	$r2A=mysql_fetch_array(mysql_query("SELECT uom FROM t_grpodlv_detail 
	JOIN t_grpodlv_header ON t_grpodlv_detail.id_grpodlv_header = t_grpodlv_header.id_grpodlv_header 
	WHERE material_no='$item' AND plant ='$plant' AND val=2 "));
	echo 'Var :'.' '.$r2['uom'].'<br>';
	echo 'Lost :'.' '.$r2A['uom'].'<br>';
	
	?></span></td>
    <td><span class="style5"><?=$plant_name;?></span></td>
  </tr>
  <?php } ?>
  <tr>
    <td><?php echo "SELECT MATNR,MAKTX from m_item
where MATNR IN (SELECT material_no from t_grpodlv_detail JOIN t_grpodlv_header ON t_grpodlv_header.id_grpodlv_header=t_grpodlv_detail.id_grpodlv_header WHERE plant='$plant' AND var >0) 
OR 
MATNR IN (SELECT material_no from t_grsto_detail JOIN t_grsto_header ON t_grsto_header.id_grsto_header=t_grsto_detail.id_grsto_header WHERE plant='$plant' AND var >0) OR 
MATNR IN (SELECT material_no from t_grpodlv_dept_detail JOIN t_grpodlv_dept_header ON t_grpodlv_dept_header.id_grpodlv_dept_header=t_grpodlv_dept_detail.id_grpodlv_dept_header WHERE plant='$plant' AND var >0"?></td>
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