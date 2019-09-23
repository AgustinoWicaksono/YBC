<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('TEST_2',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
.style6 {
	font-size: 24px;
	font-weight: bold;
}
-->
</style>

<p>&nbsp;</p>
<table width="648" align="center">
  <tr>
    <td colspan="2" align="center"><strong>STORE ROOM REQUISITION</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><strong>
      <?=$reck;?>
    </strong></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="321"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="317">&nbsp;</td>
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
    <td width="92">PR No.</td>
    <td width="10">:</td>
    <td width="249"><?php echo $row->pr_no;?></td>
    <td width="103">Delivery Date</td>
    <td width="7">:</td>
    <td width="161"><?php echo $row->delivery_date;?></td>
  </tr>
  <tr>
    <td>PR Date</td>
    <td>:</td>
    <td><?php echo $row->created_date;?></td>
    <td>Delivery Addres</td>
    <td>:</td>
    <td><?php $plant=$row->plant ;
	
	?></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="649" border="1" align="center">
  <tr>
    <td width="26" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="72" bgcolor="#999999"><div align="center"><strong>Item Code</strong></div></td>
    <td width="166" bgcolor="#999999"><div align="center"><strong>Description</strong></div></td>
    <td width="58" align="center" bgcolor="#999999"><strong>Part Stock</strong></td>
    <td width="70" align="center" bgcolor="#999999"><strong>Stock On Hand</strong></td>
    <td width="44" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="167" bgcolor="#999999"><div align="center"><strong>Request Qty</strong></div></td>
  </tr>
  <?php
   $no = 1;
foreach($data->result() as $row1) 
{

	
?>
  <tr>
    <td align="center"><?php echo $no++; ?></td>
    <td><?php 
	$mat=$row1->material_no;
	echo $mat; ?></td>
    <td><?php 
	$desc=$row1->material_desc;
	echo $desc; ?></td>
    <td><?php
	$plant=$row1->plant; 
	$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	$b=mssql_select_db('TEST_2',$c);
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
<p>&nbsp;	</p>
<p>&nbsp;</p>
<table width="491" align="center">
  <tr>
    <td width="161" align="center">Requested by :</td>
    <td width="149" align="center">Approved by :</td>
    <td width="159" align="center">Verified by :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">(User)</td>
    <td align="center">(Division Head)</td>
    <td align="center">(Purchasing)</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;	</p>
<div align="justify"></div>
<p>&nbsp;	</p>
<h5 class="style1">&nbsp;</h5>
 <table width="640" align="center">
  <tr>
    <td width="10"><span class="style5">1.</span></td>
    <td width="618"><span class="style3 style5"> FILLOUT IN DUPLICATE RETAIL YELLOW COPY FOR YOURFILE</span></td>
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
