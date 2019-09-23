<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $po=$row->grpo_no;
	 $c=mssql_connect("192.168.0.20","sa","abc123?");
	 $b=mssql_select_db('MSI_TRIAL',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName,OLCT.Location FROM OWHS JOIN OLCT ON OWHS.Location=OLCT.Code WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $reck_loc=$temp['Location'];
	  $temp1=mssql_fetch_array(mssql_query("SELECT * FROM PDN1 WHERE DocEntry='$po'"));
	  
	 
?>
<style type="text/css">
<!--
.style6 {
	font-size: 18px;
	font-weight: bold;
}
.style10 {font-size: 24px}
.style8 {font-size: 9px}
.style12 {font-size: 18px}
.style13 {
	font-size: 36px;
	font-weight: bold;
}
.style15 {font-size: 12px}
-->
</style>

<p>&nbsp;</p>
<table width="717" align="center">
  <tr>
    <td align="left"><p><u><span class="style10"><span class="style12">_____________</span><br />
            <span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td><span class="style13">RECEIVING SLIP</span> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>No. <?php echo $row->grpo_no;?></td>
  </tr>
  <tr>
    <td width="386"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td>Date. <?php echo $row->delivery_date;?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Vendor. <?=$row->nm_vendor;?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>Attn.</td>
  </tr>
  <tr>
    <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
    <td width="319">Address. <?php echo $reck_loc ;
	
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td>&nbsp;</td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="740" border="1" align="center">
  <tr>
    <th width="27" height="28" align="center" bgcolor="#999999" scope="col">No</th>
    <th width="80" align="center" bgcolor="#999999" scope="col">Code</th>
    <th width="132" align="center" bgcolor="#999999" scope="col">Description</th>
    <th width="54" align="center" bgcolor="#999999" scope="col">Uom</th>
    <th width="56" align="center" bgcolor="#999999" scope="col">Order</th>
    <th width="68" align="center" bgcolor="#999999" scope="col">Receive</th>
    <th width="81" align="center" bgcolor="#999999" scope="col">Price</th>
    <th width="97" align="center" bgcolor="#999999" scope="col">Batch Number</th>
    <th width="87" align="center" bgcolor="#999999" scope="col">Exp Date</th>
  </tr>
   <?php
   $no = 1;
foreach($data->result() as $row1) 
{
?>
<?php 
	$item=$row1->material_no;
	$sell=mssql_fetch_array(mssql_query("SELECT OBTN.DistNumber,OBTN.ExpDate FROM OITL
			JOIN ITL1 ON OITL.LogEntry = ITL1.LogEntry
			JOIN OBTN ON ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber
			where DocEntry = '$po' and DocType =20 AND OITL.StockQty >0 AND OITL.ItemCode='$item'"));
			
	?>
    <?php 
	$item=$row1->material_no;
	$sell2=mssql_fetch_array(mssql_query("select str(price)price from PDN1
     where DocEntry = '$po' and  ItemCode='$item'"));
			
	?>
    <?php 
	$item=$row1->material_no;
	$sell3=mssql_fetch_array(mssql_query("select (DocTotal-VatSum,DocTotalSy,* from OPDN
     where DocEntry = '$po' and  ItemCode='$item'"));
			
	?>
    
   <?php 
	$item=$row1->material_no;
	$sell3=mssql_fetch_array(mssql_query("select DocTotal-VatSum,DocTotalSy,* from OPDN
     where DocEntry = '$po' and  ItemCode='$item'"));
			
	?>
	
  <tr>
    <td align="center"><span class="style8"><?php echo $no++; ?></span></td>
    <td><span class="style8">&nbsp;<?php echo $row1->material_no; ?></span></td>
    <td><span class="style8">&nbsp;<?php echo $row1->material_desc; ?></span></td>
    <td align="right"><span class="style8">&nbsp;<?php echo $row1->uom; ?>&nbsp;</span></td>
    <td align="right"><span class="style8">&nbsp;
      <?php $outs_qty=$row1->outstanding_qty;
	echo substr($outs_qty,0,-2);
	 ?>
    &nbsp;</span></td>
    <td align="right"><span class="style8">
      <?php $gr_qty=$row1->gr_quantity; 
	echo substr($gr_qty,0,-2);
	?>
    &nbsp;</span></td>
    <td align="right"><span class="style8"><?php echo number_format($sell2['price'],2);?>&nbsp;</span></td>
    <td align="right"><span class="style8">&nbsp;<?php echo $sell['DistNumber'];?>&nbsp;</span></td>
    <td><span class="style8">&nbsp;<?php echo $sell['ExpDate'];?></span></td>
  </tr>
   <?php } ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><span class="style8"></span></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
</table>
<p>&nbsp;</p>
<table width="1018" border="0" align="center">
  <tr>
    <th width="684" align="right" scope="col">.</th>
    <th width="318" align="left" scope="col">&nbsp;</th>
  </tr>
</table>
<p>&nbsp;</p>
<table width="522" border="0" align="center">
  <tr>
    <th width="256" scope="col"><table style="border-collapse:collapse; width="200" border="1">
      <tr>
        <th width="220" height="29" align="center" scope="col"><span class="style15">Delivered By:</span></th>
      </tr>
      <tr>
        <td><p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td><span class="style15">Name :</span></td>
      </tr>
      <tr>
        <td><span class="style15">Date&nbsp;&nbsp;  :</span></td>
      </tr>
	  <tr>
        <td><span class="style15">Time&nbsp;&nbsp;  :</span></td>
      </tr>
    </table></th>
    <th width="19" scope="col">&nbsp;</th>
    <th width="233" scope="col"><table style="border-collapse:collapse;  width="200"  border="1"  align="center">
      <tr>
        <th width="223" height="28" align="center" scope="col"><span class="style15">Received By :</span></th>
      </tr>
      <tr>
        <td><p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td><span class="style15">Name :</span></td>
      </tr>
      <tr>
        <td><span class="style15">Date &nbsp;:</span></td>
      </tr>
	  <tr>
        <td><span class="style15">Time &nbsp;:</span></td>
      </tr>
    </table></th>
	<th width="19" scope="col">&nbsp;</th>
	<th width="233" scope="col"><table style="border-collapse:collapse;  width="200"  border="1"  align="center">
      <tr>
        <th width="223" height="28" align="center" scope="col"><span class="style15">Security Check :</span></th>
      </tr>
      <tr>
        <td><p>&nbsp;</p>
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td><span class="style15">Name :</span></td>
      </tr>
      <tr>
        <td><span class="style15">Date &nbsp;:</span></td>
      </tr>
	  <tr>
        <td><span class="style15">Time &nbsp;:</span></td>
      </tr>
    </table></th>
  </tr>
</table>
<p>&nbsp;</p>
<blockquote>
  <p>&nbsp;</p>
</blockquote>
<div align="justify"></div>
