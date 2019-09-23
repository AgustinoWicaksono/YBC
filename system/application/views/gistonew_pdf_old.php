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
    <td width="321"><strong>PT. Mount Scopus Indonesia</strong></td>
    <td width="317">&nbsp;</td>
  </tr>
  <tr>
    <td>Jl. Wolter Monginsidi No.95 Kebayoran Baru</td>
    <td>Transfer Slip No : <?php echo $row->po_no;?></td>
  </tr>
  <tr>
    <td>Jakarta Selatan 12110, Indonesia</td>
    <td>Date : <?php echo $row->posting_date;?></td>
  </tr>
  <tr>
      <td>Ph. +62 21 726 06680 / Fax. +62 21 727 971 59</td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="638" border="1" align="center">
  <tr>
    <td width="313"><p>Transfer From :</p>
    <p><?php echo $row->PLANTNAME;?></p></td>
    <td width="313"><p>Transfer To :</p>
    <p><?php echo $row->REC_NAME;?></p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="709" border="1" align="center">
  <tr>
    <td width="81" rowspan="2">Item Code</td>
    <td width="27" rowspan="2">Description</td>
    <td colspan="3">Quantity In</td>
    <td colspan="3">Quantity Out</td>
    <td width="54" rowspan="2">Supplier</td>
    <td width="54" rowspan="2">Manufac.</td>
    <td width="54" rowspan="2">Origin</td>
    <td width="65" rowspan="2">Arr. Date</td>
  </tr>
  <tr>
    <td width="54">Qty</td>
    <td width="54">Unit</td>
    <td width="54">Check</td>
    <td width="54">Qty</td>
    <td width="54">Unit</td>
    <td width="54">Check</td>
  </tr>
  <tr>
    <td><?php echo $row->material_no;?></td>
    <td><?php echo $row->material_desc;?></td>
    <td><?php echo $row->gr_quantity;?></td>
    <td><?php echo $row->uom;?></td>
    <td>&nbsp;</td>
    <td><?php echo $row->gr_quantity;?></td>
    <td><?php echo $row->uom;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $row->posting_date;?></td>
  </tr>
  <tr>
    <td colspan="12"><p>Comments :</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
<table style="border-collapse:collapse;" width="497" border="1" align="center">
  <tr>
    <td colspan="3" align="center">Loading  :</td>
    <td colspan="3" align="center">Unloading :</td>
  </tr>
  <tr>
    <td width="80"><p>Store :</p>
    <p>&nbsp;</p></td>
    <td width="72"><p>Loading :</p>
    <p>&nbsp;</p></td>
    <td width="65"><p>Security :</p>
    <p>&nbsp;</p></td>
    <td width="73"><p>Store :</p>
    <p>&nbsp;</p></td>
    <td width="81"><p>Loading :</p>
    <p>&nbsp;</p></td>
    <td width="86"><p>Security :</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
    <td><p>Name :</p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
    <td><p>Date :</p>
    <p>&nbsp;</p></td>
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
