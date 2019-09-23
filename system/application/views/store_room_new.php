<?php
	 foreach($data->result() as $row) 
?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
-->
</style>

<p>&nbsp;</p>
<table width="648" align="center">
  <tr>
    <td width="321" height="53"><!--img src='harvest1.png' width='221'--></td>
    <td width="317" align="right"><h3><strong>STORE ROOM REQUISITION</strong></h3></td>
  </tr>
  <tr>
    <td><strong>PT. Mount Scopus Indonesia</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="650" align="center">
  <tr>
    <td width="159">SR No.</td>
    <td width="10">:</td>
    <td width="183"><?php echo $row->pr_no;?></td>
    <td width="106">Delivery Date</td>
    <td width="10">:</td>
    <td width="156"><?php echo $row->delivery_date;?></td>
  </tr>
  <tr>
    <td>SR Date</td>
    <td>:</td>
    <td><?php echo $row->created_date;?></td>
    <td>Delivery Addres</td>
    <td>:</td>
    <td>-</td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="580" border="1" align="center">
  <tr>
    <td width="20">No</td>
    <td width="69"><div align="center">Item Code</div></td>
    <td width="164"><div align="center">Description</div></td>
    <td width="56">Part Stock</td>
    <td width="67">Stock On Hand</td>
    <td width="42">Uom</td>
    <td width="116"><div align="center">Request Qty</div></td>
  </tr>
  <?php foreach($data->result() as $row1)  { ?>
  <tr>
   <td><?php echo $no++; ?></td>
    <td><?php 
	$mat=$row1->material_no;
	echo $mat; ?></td>
    <td><?php 
	$desc=$row1->material_desc;
	echo $desc; ?></td>
    <td><?php
	$plant=$row1->plant; 
	$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	$b=mssql_select_db('MSI_GO',$c);
	$t=mssql_query("SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'");
	$r=mssql_fetch_array($t);
	$part=$r['OnHand'];
	echo $part;
	?></td>
    <td><?php echo $r['MinStock']; ?></td>
    <td><?php echo $row1->uom; ?></td>
    <td><?php echo $row1->requirement_qty; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="86" colspan="7"><p>Remarks :
    <?php  //echo "SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'";?>
    </p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="676" align="center">
  <tr>
    <td width="161" align="center">Requested by :</td>
    <td width="149" align="center">Approved by :</td>
    <td width="143" align="center">Acknowledge :</td>
    <td width="159" align="center">Verified by :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">(User)</td>
    <td align="center">(Division Head)</td>
    <td align="center">(General Manager)</td>
    <td align="center">(Purchasing Manager)</td>
  </tr>
</table>
<p>&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
<table width="549" border="0">
  <tr>
    <td width="18"><span class="style5">1.</span></td>
    <td width="354"><span class="style3 style5"> FILLOUT IN DUPLICATE RETAIL YELLOW COPY FOR YOURFILE</span></td>
  </tr>
  <tr>
    <td><span class="style5">2.</span></td>
    <td><span class="style3 style5"> DEPARTEMENT MANAGERS MUST SIGN PRIOR TO ORDERING</span></td>
  </tr>
  <tr>
    <td><span class="style5">3.</span></td>
    <td><span class="style3 style5"> RECEIVING - RED</span></td>
  </tr>
  <tr>
    <td><span class="style5">4.</span></td>
    <td><span class="style3 style5"> USER - BLUE</span></td>
  </tr>
</table>
<p class="style1">&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
