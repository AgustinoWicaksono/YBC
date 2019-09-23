<?php
header("Content-type: application/vnd-ms-excel");
 
 header("Content-Disposition: attachment; filename=SR.xls");
 
 header("Pragma: no-cache");
 
 header("Expires: 0");
	 foreach($data->result() as $row) 
	 $po=$row->gistonew_out_no;
	 $plant=$row->plant;
	  $con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
	// $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 //$b=mssql_select_db('MSI_TRIAL',$c);
	 $temp=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
?>
<style type="text/css">
<!--
.style5 {font-size: 11px}
-->
</style>

<p>&nbsp;</p>
<table width="648" align="center">
  <tr>
    <td>&nbsp;</td>
    <td><strong>TRANSFER SLIP</strong></td>
  </tr>
  <tr>
    <td width="321"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="317">No : <?php echo $row->gistonew_out_no;?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Date : <?php echo $row->posting_date;?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>From : <?php echo $row->plant.' - '.$row->NAME1;?></td>
  </tr>
  <tr>
      <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
      <td>To : <?php echo $row->PLANT_REC.' - '.$row->PLANT_REC_NAME;?></td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="709" border="1" align="center">
  <tr>
    <td width="81"><span class="style3 style5">Item Code</span></td>
    <td width="27"><span class="style3 style5">Description</span></td>
  
    <td width="54"><span class="style3 style5">Quantity</span></td>
    <td width="54"><span class="style3 style5">UOM</span></td>
    <td width="54"><span class="style3 style5">Check Out</span></td>
    <td width="65"><span class="style3 style5">Check In</span></td>
    <!--td width="54"><span class="style3 style5">SNRG</span></td-->
    <td width="54"><span class="style3 style5">Arrived Date</span></td>
    <td width="54"><span class="style3 style5">Expired Date</span></td>
  </tr>
 <?php
  foreach($data->result() as $row1) 
  {
 ?>
  <tr>
    <td><?php echo $row1->material_no;
	$item=$row1->material_no;
	$sell=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OBTN.DistNumber,OBTN.ExpDate FROM OITL
			JOIN ITL1 ON OITL.LogEntry = ITL1.LogEntry
			JOIN OBTN ON ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber
			where DocEntry = '$po' and DocType =67 AND OITL.StockQty >0 AND OITL.ItemCode='$item'"));
	sqlsrv_close($con);
			
	?></td>
    <td><?php echo $row1->material_desc;?></td>
    <td><?php echo $row1->gr_quantity;?></td>
    <td><?php echo $row1->uom;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <!--td><?php echo $sell['DistNumber'];?></td-->
    <td><?php echo $row1->posting_date;
	
	?></td>
    <td><?php echo $sell['ExpDate'];?></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="8"><p><span class="style3 style5">Comments</span> : </p>
    <p>
      <?php 
	$sell2=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT Comments FROM OWTR WHERE DocEntry='$po'"));
	echo $sell2['Comments'];
	?>
    </p></td>
  </tr>
  
</table>
<table width="705" style="border-collapse:collapse;" border="0" align="center">
  <tr>
   
    <td width="326">
    <table width="344" style="border-collapse:collapse;" border="1">
      <tr>
        <td colspan="3">Loading</td>
        </tr>
      <tr>
        <td width="76"><p>Store</p>
          <p>&nbsp;</p></td>
        <td width="69"><p>Loading</p>
          <p>&nbsp;</p></td>
        <td width="177"><p>Security</p>
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
    <td width="369"><table width="358" style="border-collapse:collapse;" border="1">
      <tr>
        <td colspan="3">Unloading</td>
      </tr>
      <tr>
        <td width="71"><p>Store</p>
            <p>&nbsp;</p></td>
        <td width="94"><p>Unloading</p>
            <p>&nbsp;</p></td>
        <td width="171"><p>Security</p>
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
