<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	 $doc=$row->do_no;
	 $cePL=mssql_fetch_array(mssql_query("SELECT Filler,OWHS.WhsName FROM OWTR JOIN OWHS ON OWTR.Filler = OWHS.WhsCode WHERE DocEntry='$doc'"));
	 
	 
	$db_mysql=$this->m_database->get_db_mysql();
	$user_mysql=$this->m_database->get_user_mysql();
	$pass_mysql=$this->m_database->get_pass_mysql();
	$db_sap=$this->m_database->get_db_sap();
	$user_sap=$this->m_database->get_user_sap();
	$pass_sap=$this->m_database->get_pass_sap();
	$host_sap=$this->m_database->get_host_sap();
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
<table width="648" align="center">
  <tr>
    <td colspan="2" align="left"><p><u><span class="style10"><span class="style12">_____________</span><br />
            <span class="style6">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><span class="style6">Good Receipt From Other Departement</span></td>
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
    <td>Transfer From</td>
    <td>:</td>
    <td><?php
    $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	  $doc=$grpodlv_dept_header['VBELN'];
	  $cePL=mssql_fetch_array(mssql_query("SELECT Filler,OWHS.WhsName FROM OWTR JOIN OWHS ON OWTR.Filler = OWHS.WhsCode WHERE DocEntry='$doc'"));
	 // $cePK=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$cePL[TRANSIT]' "));
	  echo $cePL['Filler'].' - '.$cePL['WhsName'];
	  ?></td>
    <td>Transfer To</td>
    <td>&nbsp;</td>
    <td><?php echo $row->plant.' - '.$reck;?></td>
  </tr>
  <tr>
    <td width="129">Transfer Slip No.</td>
    <td width="9">:</td>
    <td width="204"><?php echo $row->do_no;?></td>
    <td width="115"> Good Receipt No.</td>
    <td width="5">:</td>
    <td width="160"><?php echo $row->grpodlv_dept_no;?></td>
  </tr>
  <tr>
    <td>Delivery Date</td>
    <td>:</td>
    <td><?php echo $row->lastmodified;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="50%" border="1" align="center">
  <tr>
    <td width="38" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="118" align="center" bgcolor="#999999"><strong>Code</strong></td>
    <td width="181" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="60" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="109" align="center" bgcolor="#999999"><strong>Qty Outstanding</strong></td>
    <td width="111"  align="center" bgcolor="#999999"><strong>Qty Receipt</strong></td>
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
  </tr>
   <?php
}
?>
  <tr>
    <td height="69" colspan="8" >Remark :</td>
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
   <?php
    $id=$row->id_user_approved;  
    mysql_connect("localhost",$user_mysql,$pass_mysql);
    mysql_select_db($db_mysql);
	/*foreach($data->result() as $row1) */
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	?>
    <td align="center">(User)</td>
    <td align="center">(<?php echo $row->admin_realname;?>)</td>
    <td align="center">(<?php echo $row->admin_realname;?>)</td>
  </tr>
</table>
<p>&nbsp;</p>
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
<p class="style1">&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
