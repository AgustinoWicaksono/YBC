<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	// $po=$row->grpo_no;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	 $doc=$row->do_no;
	  $cePL=mssql_fetch_array(mssql_query("SELECT Filler,OWHS.WhsName FROM OWTR JOIN OWHS ON OWTR.Filler = OWHS.WhsCode WHERE DocEntry='$doc'"));
	 
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
<table width="763" align="center">
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
    <td width="346"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="405">&nbsp;</td>
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
<table style="border-collapse:collapse;" width="763"  border="0" align="center">
  <tr>
    <th width="352" scope="col"><table width="352" height="86" border="0">
      <tr>
        <th width="146" align="left" scope="col">Transfer From</th>
        <th width="10" align="center" scope="col">:</th>
        <th width="182" align="left" scope="col">
		<?php  echo $cePL['Filler'].' - '.$cePL['WhsName'];?></th>
      </tr>
      <tr>
        <td>Transfer Slip No.</td>
        <td align="center">:</td>
        <td><?php echo $row->do_no;?></td>
      </tr>
      <tr>
        <td>Delivery Date</td>
        <td align="center">:</td>
        <td><?php $date=$row->posting_date;
		echo substr($date,0,-8);?></td>
      </tr>
    </table></th>
    <th width="395" scope="col"><table width="406" height="86" border="0">
      <tr>
        <th width="142" align="left" scope="col">Transfer To</th>
        <th width="9" align="center" scope="col">:</th>
        <th width="241" align="left" scope="col"><?php echo $row->plant.' - '.$reck;?></th>
      </tr>
      <tr>
        <td>Good Receipt No.</td>
        <td align="center">:</td>
        <td><?php echo $row->grpodlv_dept_no;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></th>
  </tr>
</table>
<table style="border-collapse:collapse;" width="768" border="1" align="center">
  <tr>
    <th width="28" align="center" bgcolor="#999999" scope="col">No</th>
    <th width="88" align="center" bgcolor="#999999" scope="col">Code</th>
    <th width="239" align="center" bgcolor="#999999" scope="col">Description</th>
    <th width="58" align="center" bgcolor="#999999" scope="col">Uom</th>
    <th width="88" align="center" bgcolor="#999999" scope="col">Qty Outstanding</th>
    <th width="89" align="center" bgcolor="#999999" scope="col">Qty Receipt</th>
    <th width="132" align="center" bgcolor="#999999" scope="col">SNRG</th>
  </tr>
     <?php
   $no = 1;
foreach($data->result() as $row1) 
{

	
?>
<?php 
	$item=$row1->material_no;
	$sel2=mssql_fetch_array(mssql_query("SELECT OBTN.DistNumber ,OBTN.ExpDate 
                     from OBTN  JOIN
                     IBT1 ON OBTN.DistNumber = IBT1.BatchNum AND OBTN.ItemCode = IBT1.ItemCode INNER JOIN

                      OWTR ON IBT1.BaseNum = OWTR.DocNum AND IBT1.BaseType = OWTR.ObjType INNER JOIN

                      WTR1 ON IBT1.WhsCode = WTR1.WhsCode AND IBT1.ItemCode = WTR1.ItemCode AND OWTR.DocEntry ='$doc'
					  AND WTR1.ItemCode='$item'
					  AND WTR1.DocEntry=OWTR.DocEntry"));
			
	?>
    
  <tr>
    <td align="center"><?php echo $no++; ?></td>
    <td><?php echo $row1->material_no; ?></td>
    <td>&nbsp;<?php echo $row1->material_desc; ?></td>
    <td align="right"><?php echo $row1->uom; ?>&nbsp;</td>
    <td align="right"><?php $qty=$row1->outstanding_qty;
	echo substr($qty,0,-2); ?>
    &nbsp;</td>
    <td align="right"><?php  $gr_qty=$row1->gr_quantity;
	echo substr($gr_qty,0,-2); ?>
    &nbsp;</td>
    <td>&nbsp;<?php echo $sel2['DistNumber'];?></td>
  </tr>
     <?php
}
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
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
   $id=$row->id_user_approved;  
   /* $id=$stdstock_header['id_user_input'];  */
    mysql_connect("localhost","root","");
    mysql_select_db("sap_php");
	/*foreach($data->result() as $row1) */
    $r=mysql_fetch_array(mysql_query("SELECT admin_realname FROM d_admin WHERE admin_id = '$id'"));
	$name=$r['admin_realname'];
	?>
    <td align="center">(User)</td>
    <td align="center">(<?php echo $name?>)</td>
    <td align="center">(<?php echo $name?>)</td>
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
