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
<table style="border-collapse:collapse;" width="531" border="0" align="center">
  <tr>
    <td width="313"><p>Transfer From :</p>
    <p><?php echo $row->PLANTNAME;?></p></td>
    <td width="313"><p>Transfer To :</p>
    <p><?php echo $row->REC_NAME;?></p></td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="709" border="1" align="center">
  <tr>
    <td width="81" rowspan="2">Item Code</td>
    <td width="27" rowspan="2">Description</td>
    <td colspan="3">Quantity</td>
    <td width="65" rowspan="2">Remark</td>
  </tr>
  <tr>
    <td width="54">Qty</td>
    <td width="54">Unit</td>
    <td width="54">Check</td>
   </tr>
   <?php foreach($data->result() as $row1)  { ?>
  <tr>
    <td><?php echo $row1->material_no;?></td>
    <td><?php echo $row1->material_desc;?></td>
    <td><?php echo $row1->gr_quantity;?></td>
    <td><?php echo $row1->uom;?></td>
    <td>&nbsp;</td>
    <td><?php echo $row1->posting_date;?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="12"><p>Notes :</p>
    <p>&nbsp;</p></td>
  </tr>
</table>
<table width="510" align="center">
  <tr>
    <td align="200">Pengirim </td>
    <td align="200">&nbsp;</td>
    <td align="200">&nbsp;</td>
    <td width="200">Penerima</td>
    <td width="200">&nbsp;</td>
    <td width="200">&nbsp;</td>
  </tr>
  <tr>
    <td width="200" >Disetujui Oleh</td>
    <td width="200">Driver</td>
    <td width="200" >Security</td>
    <td align="200">Disetujui Oleh</td>
    <td align="200">Driver</td>
    <td align="200">Security</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>Nama</td>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
    <td>Name</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td>Tanggal</td>
    <td>Tanggal</td>
    <td>Tanggal</td>
    <td>Tanggal</td>
    <td>Tanggal</td>
  </tr>
  <tr>
    <td>Jam</td>
    <td>Jam</td>
    <td>Jam</td>
    <td>Jam</td>
    <td>Jam</td>
    <td>Jam</td>
  </tr>
</table>

