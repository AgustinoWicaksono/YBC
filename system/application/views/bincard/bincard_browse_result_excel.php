<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php

header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=BinCard.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");

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
    <?=$plant_name;?>
    <br />
    Tanggal <?=$date_from.' - '.$date_to?> </p>
<?=$group1.' - '.$group2.' - '.$group3;?></div>
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
$nyariTransit=mysql_fetch_array(mysql_query("SELECT TRANSIT FROM m_outlet WHERE OUTLET='$group'", $mysqlcon));
$OTrans=$nyariTransit['TRANSIT'];
$c=sqlsrv_connect($host_sap, array( "Database"=>$db_sap, "UID"=>$user_sap, "PWD"=>$pass_sap ));

$row_count_to_show_header = 30;

$tmp=sqlsrv_query($c, "SELECT A.DocEntry,A.ItemCode,A.ItemName FROM OITM A 
JOIN OIVL B ON A.ItemCode=B.ItemCode
WHERE A.DocEntry BETWEEN '$group2' AND '$group3'
AND DocDate between '$date_from' AND '$date_to' 
and   LEFT(B.LocCode,2)!='T.'
GROUP BY A.DocEntry,A.ItemCode,A.ItemName
ORDER BY DocEntry");
//echo $swbQuery;
?>

	<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>PASTRY</strong></h3></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="2158" border="1" align="center" class="table">
  <tr id="myHeader" class="header">
    <td width="22" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5"><strong>No</span><strong></strong></td>
    <td width="45" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Code</span></strong></td>
    <td width="215" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Description</span></strong></td>
    <td colspan="3" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
	<td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total In</span></strong></td>
<!--    <td width="57" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total On Hand</span></strong></td>
    <td width="42" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Out</span></strong></td>
    <td width="49" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting Int</span></strong></td>
    <td width="42" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Stock After Cutting</span></strong></td>
    <td width="69" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's In Convertion</span></strong></td>
    <td width="79" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Cutting's Out Convertion</span></strong></td>
    <td width="72" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Counting </span></strong></td>-->
    <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">QTY OUT</span></strong></td>
    <td width="68" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Total Out</span></strong></td>
    <!-- <td colspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Closing Stock</span></strong></td>
    <td width="73" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Inventory </span></strong></td>
    <td width="49" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS</span></strong></td>
    <td width="63" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance Sales</span></strong></td>
    <td width="53" rowspan="2" align="center" bgcolor="#999999" ><strong><span class="style5">Remark</span></strong></td>
    <td width="53" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">SOLD POS VDINE</span></strong></td>
    <td width="97" rowspan="2" align="center" bgcolor="#999999"><strong><span class="style5">Variance POS</span></strong></td> -->
  </tr>
  <tr>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR From CK</span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR From Outlet </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">GR Return </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE Transfer Outlet </span></strong></td>
    <td width="34" align="center" bgcolor="#999999"><strong><span class="style5">ISSUE Return Out </span></strong></td>
      </tr>
  <!--<tr>
    <td width="26" align="center" bgcolor="#999999"><strong><span class="style5">No TF</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong><span class="style5">No Return</span></strong></td>
    <td width="30" align="center" bgcolor="#999999"><strong><span class="style5">Qty In</span></strong></td>
  </tr>-->
  <?php
  $no=1;
	while($r=sqlsrv_fetch_array($tmp))
	{
?>
  <tr> 
    <td align="center"><span class="style5"><?=$no++;?></span></td>
    <td align="left"><span class="style5"><?=$r['ItemCode'];?></span></td>
    <td><span class="style5"><?=$r['ItemName'];?></span></td>
    <td align="center"><span class="style5">
      <?php
	 $item=$r['ItemCode'];
    $temp1=mysql_query("select SUM(c.gr_quantity) qty_ck 
	from 
	t_grpodlv_header b
	join t_grpodlv_detail c on b.id_grpodlv_header = c.id_grpodlv_header
	where b.do_no !=''  and b.grpodlv_no !='' and c.material_no='$item' and b.plant ='$plant1'
	and b.do_no not like '%C%' and b.grpodlv_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
/*echo "select c.gr_quantity from t_grpodlv_header b, t_grpodlv_detail c 
where b.do_no is not null and c.grpodlv_no is not null
and where b.do_no not like '%C%' and c.grpodlv_no not like '%C%'
and b.posting_date <=  convert(datetime, '$date_to', 120) AND b.DocDate >=  convert(datetime, '$date_from', 120)";
*/
	$r1=mysql_fetch_array($temp1);
		echo $r1['qty_ck'];
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td><span class="style5">
      <?php
	$temp3=mysql_query("
	select SUM(c.gr_quantity) qty_fo 
	from 
	t_grsto_header b
	join t_grsto_detail c on b.id_grsto_header = c.id_grsto_header
	where b.po_no !=''  and b.grsto_no !='' and b.no_doc_gist !='' and c.material_no='$item' and b.plant ='$plant1' AND b.delivery_plant='$group'
	and b.po_no not like '%C%' and b.grsto_no not like '%C%' and b.no_doc_gist not like '%C%' 
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r3=mysql_fetch_array($temp3);
		echo $r3['qty_fo'];
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
      <?php
	$temp7=mysql_query("
	select SUM(c.gr_quantity) qty_retin
	from 
	t_retin_header b
	join t_retin_detail c on b.id_retin_header = c.id_retin_header
	join t_gisto_dept_header d on b.do_no=d.gisto_dept_no
	where b.retin_no !='' and b.do_no !='' and c.material_no='$item' and b.plant ='$plant1' AND d.plant='$group'
	and b.retin_no not like '%C%' and b.do_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r7=mysql_fetch_array($temp7);
			echo $r7['qty_retin'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    <td align="center"><span class="style5">
		<?php $total_in=$r1['qty_ck']+$r3['qty_fo']+$r7['qty_retin'];
			echo $total_in;
		?>
	</span></td>
    <td align="center"><span class="style5">
      <?php
	$temp8=mysql_query("
	select SUM(c.gr_quantity) qty_to 
	from 
	t_gistonew_out_header b
	join t_gistonew_out_detail c on b.id_gistonew_out_header = c.id_gistonew_out_header
	where b.po_no !='' and b.gistonew_out_no !='' and c.material_no='$item' and b.plant ='$plant1' AND b.receiving_plant='$OTrans'
	and b.po_no not like '%C%' and b.gistonew_out_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r8=mysql_fetch_array($temp8);
		echo $r8['qty_to'];	
	
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
	<td align="center"><span class="style5">
      <?php
	$temp12=mysql_query("
	select SUM(c.gr_quantity) qty_ro 
	from 
	t_gisto_dept_header b
	join t_gisto_dept_detail c on b.id_gisto_dept_header = c.id_gisto_dept_header
	where b.gisto_dept_no !='' and c.material_no='$item' and b.plant ='$plant1' AND b.receiving_plant='$group'
	and b.gisto_dept_no not like '%C%' and b.po_no not like '%C%'
	and b.posting_date>='$date_from' AND b.posting_date<='$date_to'
", $mysqlcon);
	$r12=mysql_fetch_array($temp12);
		echo $r12['qty_ro'];
	//echo "SELECT DocEntry FROM WTR1 WHERE ItemCode='$item'GROUP BY DocEntry";
	?>
    </span></td>
    	
	<td align="center"><span class="style5">
		<?php $total_out=$r8['qty_to']+$r12['qty_ro'];
			echo $total_out;
		?>
	</span></td>
	
<!--     <td align="center"><span class="style5"> 
<?PHP  $ending_stock=$onhandaftercutting-$r16['qty_outtocshop']-$r17['qty_outtoother']-$r20['qty_spoiled'];
	echo $ending_stock;
	?></span></td>
    <td align="center"><span class="style5"><?php
    $temp17=sqlsrv_query($c,"SELECT CountQty FROM IQR1 WHERE ItemCode ='$item'  AND WhsCode  = '$plant1' AND CountDate <=  convert(datetime, '$date_to2', 120) AND CountDate >=  convert(datetime, '$date_from', 120) ");
$r17=sqlsrv_fetch_array($temp17);
		sqlsrv_close($c);
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