<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $po=$row->grpo_no;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('TEST_2',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName,OLCT.Location FROM OWHS JOIN OLCT ON OWHS.Location=OLCT.Code WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $reck_loc=$temp['Location'];
	  $temp1=mssql_fetch_array(mssql_query("SELECT * FROM PDN1 WHERE DocEntry='$po'"));
?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
.style6 {
	font-size: 18px;
	font-weight: bold;
}
.style10 {font-size: 24px}
.style8 {font-size: 9px}
.style12 {font-size: 18px}
-->
</style>

<p>&nbsp;</p>
<table width="654" align="center">
  <tr>
    <td align="left"><p><u><span class="style10"><span class="style12">_____________</span><br />
            <span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td><strong>RECEIVING SLIP</strong> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>No. <?php echo $row->grpo_no;?></td>
  </tr>
  <tr>
    <td width="321"><strong>PT. Mount Scopus Indonesia</strong></td>
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
    <td width="317">Address. <?php echo $reck_loc ;
	
	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="45%" border="1" align="center">
  <tr>
    <td width="38" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="117" align="center" bgcolor="#999999"><strong>Code</strong></td>
    <td width="183" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="60" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="108" align="center" bgcolor="#999999"><strong>Order</strong></td>
    <td width="110"  align="center" bgcolor="#999999"><strong>Receieve</strong></td>
    <td width="110"  align="center" bgcolor="#999999"><strong>Price</strong></td>
    <td width="110"  align="center" bgcolor="#999999"><strong>SNRG</strong></td>
    <td width="110"  align="center" bgcolor="#999999"><strong>Exp</strong></td>
  </tr>
  
   <?php
   $no = 1;
foreach($data->result() as $row1) 
{

	
?>
  <tr>
 
    <td align="center"><?php echo $no++; ?></td>
    <td><?php echo $row1->material_no; ?></td>
    <td><?php echo $row1->material_desc; ?></td>
    <td><?php echo $row1->uom; ?></td>
    <td><?php echo $row1->outstanding_qty; ?></td>
    <td><?php echo $row1->gr_quantity; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <?php
}
?>
  <tr>
    <td height="69" colspan="11" >Remark :</td>
  </tr>
</table>

<table width="326" align="center">
  <tr>
    <td width="161">Delivered by :</td>
    <td width="149">Received by :</td>
  </tr>
  <tr>
    <td>Name :</td>
    <td>Name :</td>
  </tr>
  <tr>
    <td>Date :</td>
    <td>Date :</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div align="justify"></div>
<p class="style1">&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
