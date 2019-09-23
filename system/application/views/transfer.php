<?php
	 foreach($data->result() as $row) 
?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
-->
</style>

<p>&nbsp;</p>
<table width="738" align="center">
  <tr>
    <td height="53" colspan="6"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>TRANSFER FORM</strong></h3></td>
  </tr>
  <tr>
    <td colspan="3">Pengirim</td>
    <td colspan="3">Untuk (Tujuan)</td>
  </tr>
  <tr>
    <td width="111">Outlet</td>
    <td width="4">:</td>
    <td width="219"><?php 
	$from=$row->plant;
	mysql_connect("localhost","root","");
	mysql_select_db("sap_php");
	$r=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$from'"));
	$WhsFrom=$r['OUTLET_NAME1'];
	echo $from ;?></td>
    <td width="92">Outlet</td>
    <td width="10">:</td>
    <td width="274"><?php 
	$to=$row->receiving_plant;
	$r=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$to'"));
	$WhsTo=$r['OUTLET_NAME1'];
	echo $to;?></td>
  </tr>
  <tr>
    <td>Departement</td>
      <td>:</td>
      <td><?php echo $WhsFrom;?></td>
      <td>Departement</td>
      <td>:</td>
      <td><?php echo $WhsTo;?></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="648" border="1" align="center">
  <tr>
    <td width="90">Item Code</td>
    <td width="164">Production/Description</td>
    <td width="61">UoM</td>
    <td width="73">Qty</td>
    
    <td width="130">Remark</td>
  </tr>
  <?php foreach($data->result() as $row1)  { ?>
  <tr>
    <td><?php 
	$mat=$row1->material_no;
	echo $mat; ?></td>
    <td><?php 
	$desc=$row1->material_desc;
	echo $desc; ?></td>
    <td><?php echo $row1->uom; ?></td>
    <td><?php echo $row1->gr_quantity; ?></td>
    <td> </td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="2">Jumlah Baris</td>
    <td colspan="3">Store Keeper</td>
  </tr>
  <tr>
   <td colspan="6">Notes :</td>
  </tr>
</table>
<table width="762" align="center">
  <tr>
    <td>Pengirim</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Penerima</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prepared By</td>
    <td>Approved By</td>
    <td>Security</td>
    <td>Prepared By</td>
    <td>Approved By</td>
    <td>Security</td>
  </tr>
  <tr>
    <td width="123">&nbsp;</td>
    <td width="113">&nbsp;</td>
    <td width="115">&nbsp;</td>
    <td width="127">&nbsp;</td>
    <td width="123">&nbsp;</td>
    <td width="133">&nbsp;</td>
  </tr>
  <tr>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
  </tr>
  <tr>
    <td>Date</td>
    <td>Date</td>
    <td>Date</td>
    <td>Date</td>
    <td>Date</td>
    <td>Date</td>
  </tr>
  <tr>
    <td>Time</td>
    <td>Time</td>
    <td>Time</td>
    <td>Time</td>
    <td>Time</td>
    <td>Time</td>
  </tr>
</table>
