<?php
	 foreach($data->result() as $row) 
	 $po=$row->grsto_no;
	 $plant=$row->plant;
	$con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
	 $temp=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
?>
<style type="text/css">
<!--
.style5 {font-size: 11px}
.style10 {font-size: 24px}
.style6 {	font-size: 18px;
	font-weight: bold;
}
.style8 {font-size: 9px}
-->
</style>

<p>&nbsp;</p>
<table width="719" align="center">
  <tr>
    <td height="51"><p><u><span class="style10"><span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>TRANSFER SLIP</strong></td>
  </tr>
  <tr>
    <td width="461"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="246">No : <?php echo $row->grsto_no;?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Date : <?php echo $row->delivery_date;?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>From : <?php echo $row->PLANT_REC.' - '.$row->PLANT_REC_NAME;?></td>
  </tr>
  <tr>
      <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
      <td>To : <?php echo $row->plant.' - '.$row->NAME1;?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="719" border="1" align="center">
  <tr>
    <td width="63" height="23" align="center" bgcolor="#999999"><span class="style3 style5">Item Code</span></td>
    <td width="110" align="center" bgcolor="#999999"><span class="style3 style5">Description</span></td>
  
    <td width="54" align="center" bgcolor="#999999"><span class="style3 style5">Quantity</span></td>
    <td width="41" align="center" bgcolor="#999999"><span class="style3 style5">UOM</span></td>
    <td width="70" align="center" bgcolor="#999999"><span class="style3 style5">Check Out</span></td>
    <td width="51" align="center" bgcolor="#999999"><span class="style3 style5">Check In</span></td>
    <td width="92" align="center" bgcolor="#999999"><span class="style3 style5">Batch Number</span></td>
    <td width="73" align="center" bgcolor="#999999"><span class="style3 style5">Arrived Date</span></td>
    <td width="107" align="center" bgcolor="#999999"><span class="style3 style5">Expired Date</span></td>
  </tr>
 <?php
  foreach($data->result() as $row1) 
  {
 ?>
  <tr>
    <td><span class="style8">&nbsp;<?php echo $row1->material_no;
	$item=$row1->material_no;
	$sell=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OBTN.DistNumber,OBTN.ExpDate FROM OITL
			JOIN ITL1 ON OITL.LogEntry = ITL1.LogEntry
			JOIN OBTN ON ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber
			where DocEntry = '$po' and DocType =67 AND OITL.StockQty >0 AND OITL.ItemCode='$item'"));
	sqlsrv_close($con);
			
	?></span></td>
    <td><span class="style8">&nbsp;<?php echo $row1->material_desc;?></span></td>
    <td align="right"><span class="style8">
      <?php $qty=$row1->gr_quantity;
	echo substr($qty,0,-2);?>
    &nbsp;</span></td>
    <td align="right"><span class="style8"><?php echo $row1->uom;?>&nbsp;</span></td>
    <td><span class="style8"></span></td>
    <td><span class="style8"></span></td>
    <td><span class="style8">&nbsp;<?php echo $sell['DistNumber'];?></span></td>
    <td><span class="style8">&nbsp;<?php echo $row1->delivery_date;
	
	?></span></td>
    <td><span class="style8">&nbsp;<?php echo $sell['ExpDate'];?></span></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="9"><p><span class="style3 style5">Comments</span> : </p>
    <p>
      <?php 
	$sell2=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT Comments FROM OWTR WHERE DocEntry='$po'"));
	echo $sell2['Comments'];
	?>
    </p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<table width="661" style="border-collapse:collapse;" border="1" align="center">
  <tr>
   
    <td width="317">
    <table width="317" border="0">
      <tr>
        <td colspan="3">Loading</td>
        </tr>
      <tr>
        <td width="77"><p>Store</p>
          <p>&nbsp;</p></td>
        <td width="70"><p>Loading</p>
          <p>&nbsp;</p></td>
        <td width="156"><p>Security</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td>Name</td>
        <td>Name</td>
        <td>Name</td>
      </tr>
      <tr>
        <td>Date</td>
        <td>Date</td>
        <td>Date</td>
      </tr>
    </table></td>
    <td width="328"><table width="328" border="0">
      <tr>
        <td colspan="3">Unloading</td>
      </tr>
      <tr>
        <td width="87"><p>Store</p>
            <p>&nbsp;</p></td>
        <td width="75"><p>Unloading</p>
            <p>&nbsp;</p></td>
        <td width="152"><p>Security</p>
            <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td>Name</td>
        <td>Name</td>
        <td>Name</td>
      </tr>
      <tr>
        <td>Date</td>
        <td>Date</td>
        <td>Date</td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
