<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
	 $temp=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT WhsName,OLCT.Location FROM OWHS JOIN OLCT ON OWHS.Location=OLCT.Code WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $reck_loc=$temp['Location'];
?>
<style type="text/css">
<!--
.style5 {font-size: 10px}
.style7 {
	font-size: 18px;
	font-weight: bold;
}
.style8 {font-size: 9px}
.style10 {font-size: 24px}
.style12 {font-size: 18px}
-->
</style>


<p>&nbsp;</p>
<table width="676"  align="center">
  <tr>
    <td width="373"><u><span class="style10"><span class="style12">____________</span><br />
            <span class="style7">THE HARVEST</span></span></u><br />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></td>
    <td colspan="2" align="center"><span class="style7">STORE ROOM REQUISITION</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="116">No SR</td>
    <td width="165">:&nbsp;<?php echo $row->pr_no;?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>SR Date</td>
    <td>:&nbsp;<?php echo $row->created_date;
	?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>Delivery Date</td>
    <td>:&nbsp;<?php echo $row->delivery_date;
	?></td>
  </tr>
  <tr>
    <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
    <td>Request To</td>
    <td>:&nbsp;<strong><?php echo $row->to_plant.' - '.$row->OUTLET_NAME1 ;?>
    </strong></td>
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
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="673" border="1" align="center">
  <tr>
    <td width="26" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="72" bgcolor="#999999"><div align="center"><strong>Item Code</strong></div></td>
    <td width="207" bgcolor="#999999"><div align="center"><strong>Description</strong></div></td>
    <td width="59" align="center" bgcolor="#999999"><strong>Part Stock</strong></td>
    <td width="79" align="center" bgcolor="#999999"><strong>Stock On Hand</strong></td>
    <td width="56" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="128" bgcolor="#999999"><div align="center"><strong>Request Qty</strong></div></td>
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
    <td align="right"><?php
	$plant=$row1->plant; 
	//$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	//$b=mssql_select_db('MSI_GO',$c);
	$r=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'"));
	//$r=mssql_fetch_array($t);
	sqlsrv_close($con);		

	$part=$r['MinStock'];
	echo substr($part,0,-4);
	?>
    &nbsp;</td>
    <td align="right"><?php echo substr($r['OnHand'],0,-4); ?>&nbsp;</td>
    <td align="center"><?php echo $row1->uom; ?>&nbsp;</td>
    <td align="right"><?php  $qty=$row1->requirement_qty;
	echo substr($qty,0,-2); ?>&nbsp;</td>
  </tr>
   <?php } ?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
   
  <tr>
    <td height="86" colspan="7"><p>Remarks :
    <?php  //echo "SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'";?>
    </p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="676" align="center"  style="border-collapse:collapse;" border="1">
  <tr>
    <td width="161" align="center">Requested by :</td>
    <td width="149" align="center">Approved by :</td>
    <td width="143" align="center">Acknowledge :</td>
    <td width="159" align="center">Verified by :</td>
  </tr>
  <tr>
  <?php
    $id=$row->id_user_approved;  
    mysql_connect("localhost","root","");
    mysql_select_db("sap_php");
	/*foreach($data->result() as $row1) */
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	
	?>
    <td height="99" align="center"> <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>(User)</p></td>
    <td align="center" ><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>(<?php echo $name;?>)</p></td>
    
    <td align="center"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>(General Manager)</p></td>
    
    <td align="center"><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>(<?php echo $name;?>)</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="649" align="center">
  <tr>
    <td width="11"><span class="style5">1.</span></td>
    <td width="626"><span class="style3 style5"> FILLOUT IN DUPLICATE RETAIL YELLOW COPY FOR YOURFILE</span></td>
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
