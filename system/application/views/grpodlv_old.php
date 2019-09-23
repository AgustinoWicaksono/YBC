<?php
	 foreach($data->result() as $row) 
	 $plant=$row->plant;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	$temp=mssql_fetch_array(mssql_query("SELECT WhsName,OLCT.Location FROM OWHS JOIN OLCT ON OWHS.Location=OLCT.Code WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $doc=$row->do_no;
	  $reck_loc=$temp['Location'];
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
<table width="682"  align="center">
  <tr>
    <td width="336"><u><span class="style10"><span class="style12">____________</span><br />
            <span class="style6">THE HARVEST</span></span></u><br />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></td>
    <td colspan="2" align="center"><span class="style6">Good Receipt From  Central Kitchen Sentul</span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="157">Transfer Slip No.</td>
    <td width="173">:&nbsp;<?php echo $row->do_no;?></td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Good Receipt No</td>
    <td>:&nbsp;<?php echo $row->grpodlv_no;?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>Date</td>
    <td>:&nbsp;<?php echo $row->created_date;?></td>
  </tr>
  <tr>
    <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
    <td>Delivery Date</td>
    <td>:&nbsp;<?php echo $row->lastmodified;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Delivery</td>
    <td>:&nbsp;<strong><?=$reck;?>
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
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="47%" border="1" align="center">
  <tr>
    <td width="32" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="111" align="center" bgcolor="#999999"><strong>Code</strong></td>
    <td width="178" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="62" align="center" bgcolor="#999999"><strong>Uom</strong></td>
    <td width="100" align="center" bgcolor="#999999"><strong>Qty Outstanding</strong></td>
    <td width="76"  align="center" bgcolor="#999999"><strong>Qty Receipt</strong></td>
    <td width="116"  align="center" bgcolor="#999999"><strong>SNRG</strong></td>
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
    <td>&nbsp;<?php echo $row1->material_no; ?></td>
    <td>&nbsp;<?php echo $row1->material_desc; ?></td>
    <td align="right"><?php echo $row1->uom; ?>&nbsp;</td>
    <td align="right"><?php $qty=$row1->outstanding_qty;
	 echo substr($qty,0,-2);?>&nbsp;</td>
    <td align="right"><?php $qty_grpo=$row1->gr_quantity; 
	echo substr($qty_grpo,0,-2);?>
    &nbsp;</td>
    <td align="right"><?php echo $sel2['DistNumber'];?>&nbsp;&nbsp;</td>
  </tr>
     <?php
}
?>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td height="69" colspan="9" >Remark :</td>
  </tr>
</table>
<p>&nbsp;	</p>
<p>&nbsp;</p>
<table width="606" border="1"   style="border-collapse:collapse;" align="center">
  <tr>
    <td width="187" align="center" scope="col">Requested by :</td>
    <td width="196" align="center" scope="col">Approved by :</td>
    <td width="201" align="center" scope="col">Verified by :</td>
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
    <td height="115" align="center" valign="bottom">(User)</td>
    <td align="center" valign="bottom">(<?php echo $name;?>)</td>
    <td align="center" valign="bottom">(<?php echo $name;?>)</td>
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
