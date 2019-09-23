<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $id=$row->id_user_approved;
	$con = sqlsrv_connect("msi-sap-db", array( "Database"=>"MSI", "UID"=>"sa", "PWD"=>"M$1S@p!#@" ));
	 $temp=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $doc=$row->do_no;
	  
	
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
<table width="679" align="center">
  <tr>
    <td colspan="2" align="left"><p><u><span class="style10"><span class="style12">_____________</span><br />
            <span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span class="style6">Retur In</span></td>
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
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="320"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="347">&nbsp;</td>
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
    <td>Retur From</td>
    <td>&nbsp;</td>
    <td><?php echo $row->FromPlant.' - '.$row->OUTLET_NAME1;?></td>
    <td>Retur To </td>
    <td>&nbsp;</td>
    <td><?php echo $row->plant.' - '.$reck;?></td>
  </tr>
  <tr>
    <td width="129" height="21">Retur Out No.</td>
    <td width="9">:</td>
    <td width="220"><?php echo $row->do_no;?></td>
    <td width="99">Retur In No.</td>
    <td width="5">:</td>
    <td width="160"><?php echo $row->retin_no;?></td>
  </tr>
  <tr>
    <td>Delivery Date </td>
    <td>:</td>
    <td><?php $date=$row->delivery;
	echo substr($date,0,-8);?></td>
    <td>Delivery Addres</td>
    <td>:</td>
    <td><?php echo $reck ;
	
	?></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="44%" border="1" align="center">
  <tr>
    <td width="20" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="70" align="center" bgcolor="#999999"><strong>Code</strong></td>
    <td width="206" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="42" align="center" bgcolor="#999999"><strong>Uom</strong></td>
	<td width="84" align="center" bgcolor="#999999"><strong>Qty Retur</strong></td>
    <td width="84" align="center" bgcolor="#999999"><strong>Qty Receipt</strong></td>
    <td width="90"  align="center" bgcolor="#999999"><strong>Reason</strong></td>
    <td width="117"  align="center" bgcolor="#999999">Batch Number</td>
  </tr>
  
   <?php
   $no = 1;
  // echo '['.count($data->result());
foreach($data->result() as $row1) 
{

	
?>
<?php 
	$item=$row1->material_no;
	$sel2=sqlsrv_fetch_array(sqlsrv_query($con,"SELECT OBTN.DistNumber ,OBTN.ExpDate 
                     from OBTN  JOIN
                     IBT1 ON OBTN.DistNumber = IBT1.BatchNum AND OBTN.ItemCode = IBT1.ItemCode INNER JOIN

                      OWTR ON IBT1.BaseNum = OWTR.DocNum AND IBT1.BaseType = OWTR.ObjType INNER JOIN

                      WTR1 ON IBT1.WhsCode = WTR1.WhsCode AND IBT1.ItemCode = WTR1.ItemCode AND OWTR.DocEntry ='$doc'
					  AND WTR1.ItemCode='$item'
					  AND WTR1.DocEntry=OWTR.DocEntry"));
	sqlsrv_close($con);			
	?>
  <tr>
 
    <td align="center"><?php echo $no++; ?></td>
    <td>&nbsp;<?php echo $row1->material_no; ?></td>
    <td>&nbsp;<?php echo $row1->material_desc; ?></td>
    <td align="right"><?php echo $row1->uom; ?>&nbsp;</td>
	<td align="right"><?php $qty=$row1->Qty_Retur;
	echo substr($qty,0,-2); ?>&nbsp;</td>
    <td align="right"><?php $qty=$row1->gr_quantity;
	echo substr($qty,0,-2); ?>&nbsp;</td>
    <td>&nbsp;<?php echo $row1->reason; ?></td>
    <td>&nbsp;<?php echo $sel2['DistNumber'];?></td>
  </tr>
   <?php
}
?>
  <tr>
    <td height="69" colspan="9" >Remark :</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="491" align="center">
  <tr>
    <td width="161" align="center">Received by :</td>
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
   <?php
    //$id=$$row->id_user_approved; 
	/*foreach($data->result() as $row1) */
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'", $mysqlcon));
	$name=$r['admin_realname'];
	//echo "SELECT admin_realname FROM d_admin WHERE admin_id = '$id'";
	mysql_close($mysqlcon);
	?>
    <td align="center">(User)</td>
    <td align="center">(<?php echo $name;?>)</td>
    <td align="center">(<?php echo $name;?>)</td>
  </tr>
</table>
<p>&nbsp;</p>
<div align="justify"></div>
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
