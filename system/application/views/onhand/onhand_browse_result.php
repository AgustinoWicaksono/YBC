<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php
$this->load->helper('form');
$this->lang->load('g_general', $this->session->userdata('lang_name'));
$this->lang->load('g_button', $this->session->userdata('lang_name'));
$plant1 = $this->session->userdata['ADMIN']['plant'];
$plant2=substr($plant1,4);
$plant_name = $this->session->userdata['ADMIN']['plant_name'];
$db_mysql=$this->m_database->get_db_mysql();
		$user_mysql=$this->m_database->get_user_mysql();
		$pass_mysql=$this->m_database->get_pass_mysql();
		$db_sap=$this->m_database->get_db_sap();
		$user_sap=$this->m_database->get_user_sap();
		$pass_sap=$this->m_database->get_pass_sap();
		$host_sap=$this->m_database->get_host_sap();
$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
		mysql_select_db($db_mysql,$mysqlcon);
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
    <?=$plant_name.' <br/> '.$item_group_code;?></div>
<?php
//echo "<pre>";
//print_r($data);
//echo "</pre>";
//exit;

$temp_cake="SELECT cake,otd_code,TRANSIT FROM m_outlet WHERE OUTLET ='$plant1'";
$re=sqlsrv_fetch_array(sqlsrv_query($temp_cake));
$trans_plant=$re['cake'];
$otd_code=$re['otd_code'];
$plant=$re['TRANSIT'];
$c=sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));

$row_count_to_show_header = 30;
$cekG=sqlsrv_fetch_array(sqlsrv_query($c,"SELECT OnHand FROM OITW WHERE OnHand > 0"));
$transit='T.'.$plant;
$grup_item=$cekG['ItmsGrpCod'];

if ($grup_item != "")
{
$grup_kode=$grup_item;
$swbQuery = "SELECT A.ItemCode,B.ItemName,A.OnHand,C.ItmsGrpNam FROM OITW A
JOIN OITM B ON A.ItemCode=B.ItemCode
JOIN OITB C ON B.ItmsGrpCod=C.ItmsGrpCod
WHERE A.OnHand >0 AND A.WhsCode='$plant1' AND C.ItmsGrpNam='$grup_item'
 ";
//echo "abc";
}
else
{
	$swbQuery = "
SELECT A.ItemCode,B.ItemName,A.OnHand,C.ItmsGrpNam FROM OITW A
JOIN OITM B ON A.ItemCode=B.ItemCode
JOIN OITB C ON B.ItmsGrpCod=C.ItmsGrpCod
WHERE A.OnHand >0 AND A.WhsCode='$plant1'";
//echo "dfg";
}

$tmp=sqlsrv_query($c,$swbQuery);
//echo $swbQuery;
?>
<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>OnHand</strong></h3></td>
  </tr>
</table>
<a href="<?= site_url('onhand/browse_result_excel/'.$item_group_code)?>">Cetak</a>
<table style="border-collapse:collapse;" width="800" border="1" align="center" class="table">
  
  <tr id="myHeader" class="header">
    <td width="15" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="60" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td width="20" align="center" bgcolor="#999999"><strong><span class="style5">OnHand</span></strong></td>
  <!--<tr>
    <td width="26" align="center" bgcolor="#999999"><strong><span class="style5">No TF</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong><span class="style5">No Return</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
  </tr>-->
  </tr>
  <?php
  $no=1;
	while($r=sqlsrv_fetch_array($tmp))
	{
?>
  <tr> 
    <td align="center"><span class="style5"><?=$no++;?></span></td>
    <td align="left"><span class="style5"><?=$r['ItemCode'];?></span></td>
    <td><span class="style5"><?=$r['ItemName'];?></span></td>
    <td align="center"><span class="style5"><?=number_format($r['OnHand'],2,",",".");?></span></td>
    

<!--     <td align="center"><span class="style5"> 
<?php  
$ending_stock=$onhandaftercutting-$r16['qty_outtocshop']-$r17['qty_outtoother']-$r20['qty_spoiled'];
	echo $ending_stock;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $temp17=sqlsrv_query($c,"SELECT CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant1' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
$r17=sqlsrv_fetch_array($temp17);
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
    <td><span class="style5">&nbsp;</span></td> -->
  </tr>
  <?php } 
	mysql_close($mysqlcon);
	?>

  </table>
  
</body>
<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>

</html>