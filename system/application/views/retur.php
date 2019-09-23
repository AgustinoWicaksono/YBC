<?php
	 foreach($data->result() as $row) 
	  $plant=$row->plant;
	 $id=$row->id_user_approved;
	 $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	 $b=mssql_select_db('MSI_GO',$c);
	 $temp=mssql_fetch_array(mssql_query("SELECT WhsName FROM OWHS WHERE WhsCode='$plant'"));
	 $reck=$temp['WhsName'];
	  $doc=$row->do_no;
	
?>
<style type="text/css">
<!--
.style10 {font-size: 24px}
.style11 {font-size: 12px}
.style7 {	font-size: 18px;
	font-weight: bold;
}
.style8 {font-size: 9px}
.style12 {font-size: 10px}
-->
</style>

<p>&nbsp;</p>
<table width="738" align="center" style="border-collapse:collapse;"  border="0">
  <tr>
    <td height="53" colspan="6" align="left"><u><span class="style10"><span class="style11">____________________</span><br />
          <span class="style7">THE HARVEST</span></span></u><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="style8">&nbsp;Partisier &amp; Chocolatier</span></td>
  </tr>
  <tr>
    <td height="53" colspan="6" align="center"><!--img src='harvest1.png' width='221'-->      <h3>&nbsp;</h3>
      <h3><strong>RETUR OUT</strong></h3>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="111"><strong>Pengirim</strong></td>
    <td width="4"></td>
    <td width="279">&nbsp;</td>
    <td width="102"><strong>Penerima</strong></td>
    <td width="3"></td>
    <td width="211">&nbsp;</td>
  </tr>
  <tr>
    <td>Day / Date</td>
    <td>:</td>
    <td><?php $date=$row->lastmodified;
	echo substr($date,0,-8);?></td>
    <td>Day / Date</td>
    <td>:</td>
    <td><?php $date2=$row->lastmodified;
	echo substr($date2,0,-8);?></td>
  </tr>
  <tr>
    <td>Outlet</td>
    <td>:</td>
    <td><?php 
	$from=$row->plant;
	mysql_connect("localhost","root","");
	mysql_select_db("sap_php");
	$r=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$from'"));
	$WhsFrom=$r['OUTLET_NAME1'];
	echo $from ;?></td>
    <td>Outlet</td>
    <td>:</td>
    <td><?php 
	$to=$row->receiving_plant;
	$r=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$to'"));
	$WhsTo=$r['OUTLET_NAME1'];
	echo $to;?></td>
  </tr>
  <tr>
    <td>Departement</td>
      <td>:</td>
      <td><?php echo $WhsFrom;?></td>
      <td>Departement</td>
      <td>:</td>
      <td><?php echo $WhsTo;?></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="48%" border="1" align="center">
    <tr>
    <td width="25" align="center" bgcolor="#999999"><strong>No</strong></td>
    <td width="118" height="22" align="center" bgcolor="#999999"><strong>Item Code</strong></td>
    <td width="185" align="center" bgcolor="#999999"><strong>Description</strong></td>
    <td width="48" align="center" bgcolor="#999999"><strong>UoM</strong></td>
    <td width="68" align="center" bgcolor="#999999"><strong>Qty</strong></td>
    <td width="124" align="center" bgcolor="#999999"><strong>Batch Number</strong></td>
    <td width="118" align="center" bgcolor="#999999"><strong>Reason</strong></td>
  </tr>
  <?php 
  $no = 1;
  foreach($data->result() as $row1)  { ?>
  <?php 
	$item=$row1->material_no;
	 $doc=$row->do_no;
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
    <td height="16">&nbsp;      <?php  
	$mat=$row1->material_no;
	echo $mat; ?></td>
    <td>&nbsp;      <?php 
	$desc=$row1->material_desc;
	echo $desc; ?></td>
    
    <td align="right"><?php 
	$uom=$row1->uom;
	echo $uom;
	 ?>
    &nbsp;</td>
   
    <td align="right"><?php $qty=$row1->gr_quantity;
	echo substr($qty,0,-2); ?>&nbsp;</td>
    <td>&nbsp;<?php echo $sel2['DistNumber'];?></td>
    <td>&nbsp;      <?php 
	$res=$row1->reason;
	echo $res;
	 ?> </td>
  </tr>
     <?php }?>
  <tr>
    <td align="center">&nbsp;</td>
    <td height="16">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td height="16">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="740" style="border-collapse:collapse;" border="0" align="center">
<tr>
     <td width="369"><table width="353" style="border-collapse:collapse;" border="1">
    <tr>
           <td colspan="3">Pengirim</td>
         </tr>
         <tr>
           <td width="113">Prepared By</td>
           <td width="110">Approved By</td>
           <td width="108">Security           </td>
        </tr>
         <tr>
           <td height="72">&nbsp;</td>
           <td>&nbsp;</td>
           <td>&nbsp;</td>
         </tr>
         <tr>
           <td><span class="style12">Name :</span></td>
           <td><span class="style12">Name :</span></td>
           <td><span class="style12">Name :</span></td>
         </tr>
         <tr>
           <td><span class="style12">Date :</span></td>
           <td><span class="style12">Date :</span></td>
           <td><span class="style12">Date :</span></td>
        </tr>
         <tr>
           <td height="21"><span class="style12">Time :</span></td>
           <td><span class="style12">Time :</span></td>
           <td><span class="style12">Time :</span></td>
         </tr>
    </table></td>
    <td width="361"><table width="364" style="border-collapse:collapse;" border="1">
       <tr>
         <td colspan="3">Penerima</td>
       </tr>
       <tr>
         <td width="113">Prepared By</td>
         <td width="120">Approved By</td>
         <td width="109">Security </td>
       </tr>
       <tr>
         <td height="72">&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
       </tr>
       <tr>
         <td><span class="style12">Name :</span></td>
         <td><span class="style12">Name :</span></td>
         <td><span class="style12">Name :</span></td>
       </tr>
       <tr>
         <td><span class="style12">Date :</span></td>
         <td><span class="style12">Date :</span></td>
         <td><span class="style12">Date :</span></td>
       </tr>
       <tr>
         <td height="21"><span class="style12">Time :</span></td>
         <td><span class="style12">Time :</span></td>
         <td><span class="style12">Time :</span></td>
       </tr>
    </table></td>
  </tr>
 </table>
