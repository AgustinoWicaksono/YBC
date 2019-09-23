<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $id=$row->id_user_approved;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	 
	 
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
<table width="657" align="center">
  <tr>
    <td width="239" rowspan="5" align="left"><p><u><span class="style10"><span class="style12">_____________</span><br />
            <span class="style6">THE HARVEST</span></span></u>    <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p></td>
    <td width="406" height="27" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left"><span class="style6">STOCK OPNAME</span></td>
  </tr>
  <tr>
    <td align="left"><strong>
      <?=$reck;?>
    </strong></td>
  </tr>
  <tr>
    <td align="left">Periode : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="650" align="center">
  <tr>
    <td width="130">Opname No.</td>
    <td width="10">:</td>
    <td width="223"><?php echo $row->opname_no;?></td>
    <td width="100">Count Date</td>
    <td width="6">:</td>
    <td width="158"><?php  $date=$row->created_date;
	 echo substr($date,0,-8);?></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="43%" border="1" align="center">
  <tr>
    <td width="27" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="112" align="center" bgcolor="#999999"><strong>Code</strong></td>
    <td width="219" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="58" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="123" align="center" bgcolor="#999999"><strong>Batch Number</strong></td>
    <td width="74" align="center" bgcolor="#999999"><strong>Qty </strong></td>
  </tr>
  
   <?php
   $no = 1;
foreach($data->result() as $row1) 
{

	
?>
  <tr>
 
    <td align="center"><?php echo $no++; ?></td>
    <td>&nbsp;<?php echo $row1->material_no; ?></td>
    <td>&nbsp;<?php echo $row1->material_desc; ?></td>
    <td align="right">&nbsp;<?php echo $row1->uom; ?>&nbsp;</td>
    <td align="right">&nbsp;      <?php	echo $row1->num;?>
    &nbsp;</td>
    <td align="right"><?php $qty=$row1->requirement_qty;
	echo substr($qty,0,-2); ?>&nbsp;</td>
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
<table width="571" align="center">
  <tr>
    <td width="144" align="center">Prepared by :</td>
    <td width="136" align="center">Approved by :</td>
    <td width="136" align="center">Verified by :</td>
    <td width="135" align="center">Acknowledge By :</td>
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
   <?php
	/*foreach($data->result() as $row1) */
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	mysql_close($mysqlcon);
	?>
    <td align="center">(User)</td>
    <td align="center">(<?php echo $name;?>)</td>
    <td align="center">(<?php echo $name;?>)</td>
    <td align="center">(Cost Control)</td>
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
