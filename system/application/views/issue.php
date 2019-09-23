<?php
	 foreach($data->result() as $row) 
	  $con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
?>
<style type="text/css">
<!--
.style10 {font-size: 24px}
.style7 {	font-size: 18px;
	font-weight: bold;
}
.style8 {font-size: 9px}
-->
</style>
<p>&nbsp;</p>
<table width="648" align="center">
  <tr>
    <td height="53" align="left"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><u><span class="style10"><span class="style7">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></h3>
      <p align="center">&nbsp;</p>
    <h3 align="center"><strong>GOOD ISSUE</strong></h3></td>
  </tr>
</table>
<table width="650" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No</td>
    <td>:</td>
    <td><?=$row->material_doc_no;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Date</td>
    <td>:</td>
    <td><?php echo $row->posting_date;?></td>
  </tr>
  <tr>
    <td width="132">&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="141">&nbsp;</td>
    <td width="101">Outlet</td>
    <td width="10">:</td>
    <td width="228"><?php
	$pL=$row->plant;
    $reck=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT WhsName FROM OWHS WHERE WhsCode='$pL'"));
	echo $pL.' - '.$row->OUTLET_NAME1;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>No Berita Acara</td>
    <td>:</td>
    <td><?php echo $row->no_acara;?>&nbsp;</td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="626" border="1" align="center">
  <tr>
    <td width="20" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="69" align="center" bgcolor="#999999"><strong>Item Code</strong></td>
    <td width="195" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="55" align="center" bgcolor="#999999"><strong>Unit</strong></td>
    <td width="51" align="center" bgcolor="#999999"><strong>Qty</strong></td>
    <td width="196" align="center" bgcolor="#999999"><strong>Reason </strong></td>
  </tr>
  <?php
   $no = 1;
foreach($data->result() as $row1) 
{

	
?>
  <tr>
   <td align="center"><?php echo $no++; ?></td>
    <td>&nbsp;      <?php 
	$mat=$row1->material_no;
	echo $mat; ?></td>
    <td>&nbsp;      <?php 
	$desc=$row1->material_desc;
	echo $desc; ?></td>
    <td align="right"><?php echo $row1->uom; ?>&nbsp;</td>
    <td align="right"> &nbsp;&nbsp;
    <?php
	$plant=$row1->plant; 
	
	$r=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'"));
	sqlsrv_close($con);

	//$r=mssql_fetch_array($t);
	$part=$r['OnHand'];
	//echo $part;
	$qty=$row1->quantity;
	echo substr($qty,0,-2)
	?>
    &nbsp;</td>
    <td>&nbsp;<?php echo $row1->reason_name; ?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="627" style="border-collapse:collapse;" align="center" border="1">
  <tr>
    <td width="204" align="center">Prepared By </td>
    <td width="202" align="center">Approved by </td>
    <td width="199" align="center">Knowledge by</td>
  </tr>
  <tr>
    <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
    <p>Staff</p></td>
    <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
    <p>MOD</p></td>
    <td align="center"><p>&nbsp;</p>
      <p>&nbsp;</p>
    <p>Security</p></td>
  </tr>
  <tr>
    <td >Name </td>
    <td >Name </td>
    <td >Name </td>
  </tr>
  <tr>
    <td >Time </td>
    <td >Time </td>
    <td >Time </td>
  </tr>
  <tr>
    <td>Date</td>
    <td>Date</td>
    <td>Date</td>
  </tr>
</table>
<p>&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
<p class="style1">&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
