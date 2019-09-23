<?php
	 foreach($data->result() as $row) 
?><style type="text/css">
<!--
.style1 {font-weight: bold}
.style2 {font-size:10px}
-->
</style><p>&nbsp;</p>
<table width="648" align="center">
  <tr>
    <td height="53"><!--img src='harvest1.png' width='221'-->      <h3 align="center"><strong>CAKE ORDER FORM</strong></h3></td>
  </tr>
</table>
<table width="650" align="center">
  <tr>
    <td>
        
          <input type="checkbox" name="checkbox" id="checkbox">
        <span class="style2">The Harvest Senopati </span> <br>
        <span class="style2">Telp 021-72788657 / Fax. 021-7396125</span></td>
    <td>&nbsp;</td>
    <td>
        <input type="checkbox" name="checkbox5" id="checkbox5">
       <span class="style2">The Harvest Alam Sutera</span> <br>
        <span class="style2">Telp 021-53140400 / Fax. 021-53140402</span>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>
        <input type="checkbox" name="checkbox8" id="checkbox8">
       Pick Up    </td>
  </tr>
  <tr>
    <td><input type="checkbox" name="checkbox" id="checkbox">
      <span class="style2">The Harvest Pondok Indah</span> <br>
      <span class="style2">Telp 021-7201710 / Fax. 021-7268409</span></td>
    <td>&nbsp;</td>
    <td>
        <input type="checkbox" name="checkbox6" id="checkbox6">
       <span class="style2">The Harvest Bandung </span> <br>
        <span class="style2">Telp 022-4200756 / Fax. 022-4261200</span>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox8" id="checkbox8">
    Delivery</td>
  </tr>
  <tr>
    <td width="171"><input type="checkbox" name="checkbox" id="checkbox">
      <span class="style2">The Harvest Menteng </span> <br>
      <span class="style2">Telp 021-2300369 / Fax. 021-2300469</span></td>
    <td width="9">&nbsp;</td>
  <td width="173">
      <input type="checkbox" name="checkbox7" id="checkbox7">
       <span class="style2">The Harvest Surabaya </span> <br>
        <span class="style2">Telp 031-5616263 / Fax. 031-5619696</span>    </td>
    <td width="75">&nbsp;</td>
    <td width="7">&nbsp;</td>
    <td width="187">&nbsp;</td>
  </tr>
  <tr>
    <td>
        <input type="checkbox" name="checkbox2" id="checkbox2">
             <span class="style2">The Harvest Kelapa Gading</span> <br>
      <span class="style2">Telp 021-45844954 / Fax. 021-25840880</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Name</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
        <input type="checkbox" name="checkbox3" id="checkbox3">
       <span class="style2">The Harvest Darmawangsa </span> <br>
        <span class="style2">Telp 021-6690250 / Fax. 021-7394914</span>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Telp</td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
        <input type="checkbox" name="checkbox4" id="checkbox4">
       <span class="style2">The Harvest Pluit </span> <br>
        <span class="style2">Telp 021-6690250 / Fax. 021-6693681</span>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Address</td>
    <td>:</td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="checkbox" id="checkbox">
      <span class="style2">The Harvest Depok </span> <br>
      <span class="style2">Telp 021-77216200/ Fax. 021-77202170</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table style="border-collapse:collapse;" width="669" border="1" align="center">
  <tr>
    <td width="74"><div align="center">Qty</div></td>
    <td width="221"><div align="center">Cake</div></td>
    <td width="59"><div align="center">Size</div></td>
    <td width="88"><div align="center">Price</div></td>
    <td width="125"><div align="center">Total</div></td>
  </tr>
  <tr>
    <td><?php 
	$mat=$row->material_no;
	echo $mat; ?></td>
    <td><?php 
	$desc=$row->material_desc;
	echo $desc; ?></td>
    <td><?php
	$plant=$row->plant; 
	$c=mssql_connect("SVR-S-2012-64","sa","abc123?");
	$b=mssql_select_db('TEST',$c);
	$t=mssql_query("SELECT * FROM OITW where ItemCode='$mat' AND WhsCode='$plant'");
	$r=mssql_fetch_array($t);
	$part=$r['OnHand'];
	echo $part;
	?></td>
    <td><?php echo $r['MinStock']; ?></td>
    <td><?php echo $row->uom; ?></td>
  </tr>
  <tr>
   <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">Grand Total</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="674" align="center">
  <tr>
    <td colspan="3" align="center"><div align="left">Comments and special request :</div></td>
  </tr>
  <tr>
    <td colspan="3"> </td>
  </tr>
  <tr>
    <td colspan="3">.....................................................................................................................................................</td>
  </tr>
  <tr>
    <td colspan="3" >...................................................................................................................................................</td>
  </tr>
  <tr>
    <td width="161" >......................................</td>
    <td width="149" >&nbsp;</td>
    <td width="143" >&nbsp;</td>
  </tr>
  <tr>
    <td>Order Taker</td>
    <td>Accounting</td>
    <td>Order Taker On</td>
  </tr>
  <tr>
    <td colspan="3" class="style2">*Saya/kami menyetujui sepenuhnya syarat-syarat yang tercantum pada halaman belakang. I/we unconditionally accept all the terms and conditions on the reverse page</td>
  </tr>
</table>
<p>&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
<p class="style1">&nbsp;</p>
<h5 class="style1">&nbsp;</h5>
