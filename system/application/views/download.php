<div align="center" class="page_title">Download Template Excel</div>
<br />
<?
if($this->l_auth->is_have_perm('trans_grpo')) {
    $rpt_gr[]='excel_template/template_Goods Receipt PO from Vendor.xls';
    $rpt_gr1[]='Goods Receipt PO from Vendor';
}	
if($this->l_auth->is_have_perm('trans_grpodlv')) {
    $rpt_gr[]='excel_template/template_Goods Receipt PO STO With Delivery.xls';
    $rpt_gr1[]='Goods Receipt PO STO With Delivery';
}	
if($this->l_auth->is_have_perm('trans_grsto')) {
    $rpt_gr[]='excel_template/template_Goods Receipt Stock Transfer Antar Plant.xls';
    $rpt_gr1[]='Goods Receipt Stock Transfer Antar Plant';
}	
if($this->l_auth->is_have_perm('trans_grnonpo')) {
    $rpt_gr[]='excel_template/template_Goods Receipt Non PO.xls';
    $rpt_gr1[]='Goods Receipt Non PO';
}	
if($this->l_auth->is_have_perm('trans_grfg')) {
    $rpt_gr[]='excel_template/template_Goods Receipt FG Outlet.xls';
    $rpt_gr1[]='Goods Receipt FG Outlet';
}	

if($this->l_auth->is_have_perm('trans_gisto')) {
    $rpt_gi[]='excel_template/template_Goods Issue Stock Transfer Antar Plant.xls';
    $rpt_gi1[]='Goods Issue Stock Transfer Antar Plant';
}	
if($this->l_auth->is_have_perm('trans_gisto')) {
    $rpt_gi[]='excel_template/template_Goods Issue to Cost Center.xls';
    $rpt_gi1[]='Goods Issue to Cost Center';
}	
if($this->l_auth->is_have_perm('trans_tssck')) {
    $rpt_gi[]='excel_template/template_Transfer Selisih Stock ke CK.xls';
    $rpt_gi1[]='Transfer Selisih Stock ke CK';
}	

if($this->l_auth->is_have_perm('trans_stockoutlet')) {
    $rpt_stock[]='excel_template/template_Stock Opname.xls';
    $rpt_stock1[]='Stock Opname';
}	
if($this->l_auth->is_have_perm('trans_waste')) {
    $rpt_stock[]='excel_template/template_Waste Material.xls';
    $rpt_stock1[]='Waste Material';
}	
if($this->l_auth->is_have_perm('trans_twts')) {
    $rpt_stock[]='excel_template/template_Transaksi Pemotongan Whole di Outlet.xls';
    $rpt_stock1[]='Transaksi Pemotongan Whole di Outlet';
}	

if($this->l_auth->is_have_perm('trans_nonstdstock')) {
    $rpt_req[]='excel_template/template_Request untuk Non Standard Stock.xls';
    $rpt_req1[]='Request untuk Non Standard Stock';
}	
if($this->l_auth->is_have_perm('trans_stdstock')) {
    $rpt_req[]='excel_template/template_Request Tambahan untuk Standard Stock.xls';
    $rpt_req1[]='Request Tambahan untuk Standard Stock';
}	

if($this->l_auth->is_have_perm('trans_trend_utility')) {
    $rpt_other[]='excel_template/template_Trend Utility (Usage).xls';
    $rpt_other1[]='Trend Utility (Usage)';
}	
if($this->l_auth->is_have_perm('trans_prodstaff')) {
    $rpt_other[]='excel_template/template_Productivity Staff  Labor Per Store Per Days Per Hour Per Department.xls';
    $rpt_other1[]='Productivity Staff  Labor Per Store Per Days Per Hour Per Department';
}	

if($this->l_auth->is_have_perm('masterdata_sfg')) {
    $rpt_master[]='excel_template/template_Master_SFG_BOM.xls';
    $rpt_master1[]='Master SFG BOM';
}	
if($this->l_auth->is_have_perm('masterdata_opnd')) {
    $rpt_master[]='excel_template/template_Master_Item_Opname_Daily.xls';
    $rpt_master1[]='Master Item Opname Daily';
}	
if($this->l_auth->is_have_perm('masterdata_mwts')) {
    $rpt_master[]='excel_template/template_Master_Konversi_Item_Whole_Ke_Slice.xls';
    $rpt_master1[]='Master Konversi Item Whole Ke Slice';
}
if($this->l_auth->is_have_perm('masterdata_mpaket')) {
    $rpt_master[]='excel_template/template_Master_Paket.xls';
    $rpt_master1[]='Master Paket';
}

?>

<div style="padding:7px;display:block;width:900px;">

<?php if (count($rpt_gr)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="margin-right:17px;border-left:#75923c 3px solid;background-color:#eaf1dd;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#75923c;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
GOOD RECEIPT
</td>
<td style="color:#ffffff;background-color:#d7e5bc;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Terima Barang</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_gr)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#75923c 1px solid;" colspan="2">'.anchor($rpt_gr[$i],"".$rpt_gr1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#75923c 1px solid;text-align:center;">'.anchor($rpt_gr[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_gr1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>


<?php if (count($rpt_gi)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="border-left:#e46d0a 3px solid;background-color:#fde9d9;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#e46d0a;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
GOOD ISSUE
</td>
<td style="color:#ffffff;background-color:#fcd5b4;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Keluar Barang</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_gi)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#e46d0a 1px solid;" colspan="2">'.anchor($rpt_gi[$i],"".$rpt_gi1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#e46d0a 1px solid;text-align:center;">'.anchor($rpt_gi[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_gi1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>

<div style="clear:both">&nbsp;<br />&nbsp;</div>



<?php if (count($rpt_stock)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="margin-right:17px;border-left:#376091 3px solid;background-color:#dbe5f1;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#376091;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
STOCK OUTLET
</td>
<td style="color:#ffffff;background-color:#b8cce5;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Stock / Waste / Finish Good</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_stock)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#376091 1px solid;" colspan="2">'.anchor($rpt_stock[$i],"".$rpt_stock1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#376091 1px solid;text-align:center;">'.anchor($rpt_stock[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_stock1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>



<?php if (count($rpt_req)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="border-left:#953735 3px solid;background-color:#f2dddc;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#953735;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
STOCK REQUEST
</td>
<td style="color:#ffffff;background-color:#e6b9b8;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Permintaan Barang</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_req)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#953735 1px solid;" colspan="2">'.anchor($rpt_req[$i],"".$rpt_req1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#953735 1px solid;text-align:center;">'.anchor($rpt_req[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_req1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>




<div style="clear:both">&nbsp;<br />&nbsp;</div>



<?php if (count($rpt_master)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="margin-right:17px;border-left:#60497b 3px solid;background-color:#e5e0ec;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#60497b;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
MASTER DATA
</td>
<td style="color:#ffffff;background-color:#ccc0da;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Master Data</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_master)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#60497b 1px solid;" colspan="2">'.anchor($rpt_master[$i],"".$rpt_master1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#60497b 1px solid;text-align:center;">'.anchor($rpt_master[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_master1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>


<?php if (count($rpt_other)>0) { ?>
<table class="swbbodyb" cellpadding="0" cellspacing="0" width="410" border="0" style="border-left:#4a452a 3px solid;background-color:#ddd9c3;" align="left">
<tr>
<td width="140"></td>
<td width="200"></td>
<td width="70"></td>
</tr>
<tr>
<td style="color:#ffffff;background-color:#4a452a;padding:3px;text-align:center;color:#ffffff;font-weight:bold;font-size:14px;">
OTHER
</td>
<td style="color:#ffffff;background-color:#c5be97;color:#121212;padding:3px;font-size:14px;" colspan="2">&nbsp;Lain-lain</td>
</tr>

<tr>
<td style="padding:3px;color:#ffffff;background-color:#232325;" colspan="2">Template Excel</td>
<td style="padding:3px;color:#ffffff;background-color:#232325;text-align:center;" >Download</td>
</tr>

<?php
  $count = count($rpt_other)-1;
    for($i=0; $i<=$count; $i++){
	
		echo '<tr>';
		echo '<td style="padding:5px;border-bottom:#4a452a 1px solid;" colspan="2">'.anchor($rpt_other[$i],"".$rpt_other1[$i]).'</td>';
		echo '<td style="padding:5px;border-bottom:#4a452a 1px solid;text-align:center;">'.anchor($rpt_other[$i],'<img src="'.base_url().'images/download.png" alt="Download" title="Download: '.$rpt_other1[$i].'" />').'</td>';
		echo '</tr>';
	
       }
?>
</table>
<?php } ?>
<div style="clear:both">&nbsp;<br />&nbsp;</div>
<br />&nbsp;
</div>
