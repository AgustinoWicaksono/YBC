<p>&nbsp;</p>
<?php
$po = $this->uri->segment(3);
$release = $this->uri->segment(4);
$released_code_desc = $this->m_po_approval->sap_po_approval_select_release_code_desc($release);
?>

<?=form_open($this->uri->uri_string(), $form1);?>
<?=form_hidden('po', $po);?>
<?=form_hidden('release', $release);?>
<table width="1200" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Purchase Order</strong></td>
		<td class="column_input"><?=form_hidden('po_approval_header[po]', $po);?><strong><?=$po;?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Release Level</strong></td>
		<td class="column_input"><?=form_hidden('po_approval_header[release]', $release);?>
        <?=form_hidden('po_approval_header[rel_group]', $data['po_approval_header']['REL_GROUP']);?>
        <?=form_hidden('po_approval_header[rel_status]', $data['po_approval_header']['REL_STATUS']);?>
        <strong><?=$release;?> - <?=$released_code_desc['FRGGR'];?> - <?=$released_code_desc['FRGCT'];?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Vendor</strong></td>
		<td class="column_input"><?=form_hidden('po_approval_header[vendor]', $data['po_approval_header']['VENDOR']);?>
        <?=$data['po_approval_header']['VENDOR'];?> - <?=$data['po_approval_header']['VEND_NAME'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Total Price</strong></td>
		<td class="column_input"><?=form_hidden('po_approval_header[price]', $data['po_approval_header']['total_price']);?>
        <?=number_format($data['po_approval_header']['total_price'], 0, '.', ',');?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Currency</strong></td>
		<td class="column_input"><?=form_hidden('po_approval_header[currency]', $data['po_approval_header']['CURRENCY']);?>
        <?=$data['po_approval_header']['CURRENCY'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Status</strong></td>
		<td class="column_input"><strong><?=$data['po_approval_header']['status_string'];?></strong></td>
	</tr>
</table>
<table width="1200" border="0" bordercolor="#000000" align="center">
	<tr bgcolor="#999999">
		<td class="table_header_1"><div align="center"><strong>Item</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Plant</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Qty</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Item Price</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Total Price</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Delivery Date</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Cost Center</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Cost Center Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Internal Order</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Internal Order Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Asset</strong></div></td>
	</tr>
	<?php
if($data['po_approval_details'] !== FALSE) :

	if(!empty($data['po_approval_detail']['PO_ITEM'])) {
		$count = count($data['po_approval_detail']['PO_ITEM']);
	}

	for($i = 1; $i <= $count; $i++) :

       $cost_center_desc = $this->m_po_approval->sap_po_approval_select_cost_center_desc($data['po_cost_center']['COST_CTR'][$i]);
       $int_order_desc = $this->m_po_approval->sap_po_approval_select_int_order_desc($data['po_cost_center']['ORDER_NO'][$i]);
?>
<?php if($i % 2) : ?>
  <tr class="table_row_2">
<?php else : ?>
  <tr class="table_row_1">
<?php endif; ?>
		<td align="center"><?=$data['po_approval_detail']['PO_ITEM'][$i];?></td>
		<td align="left"><?=$data['po_approval_detail']['MATERIAL'][$i];?></td>
		<td align="left"><?=$data['po_approval_detail']['SHORT_TEXT'][$i];?></td>
		<td align="left"><?=$data['po_approval_detail']['PLANT'][$i];?></td>
		<td align="right"><?=number_format($data['po_approval_detail']['QUANTITY'][$i], 2, '.', ',');?></td>
		<td align="left"><?=$data['po_approval_detail']['UNIT'][$i];?></td>
		<td align="right"><?=number_format($data['po_approval_detail']['NET_PRICE'][$i], 0, '.', ',');?></td>
		<td align="right"><?=number_format($data['po_approval_detail']['NET_VALUE'][$i], 0, '.', ',');?></td>
		<td align="center"><?=$data['po_delivery_date']['DELIV_DATE'][$i];?></td>
		<td align="left"><?=$data['po_cost_center']['COST_CTR'][$i];?></td>
		<td align="left"><?=$cost_center_desc['KTEXT'];?></td>
		<td align="left"><?=$data['po_cost_center']['ORDER_NO'][$i];?></td>
		<td align="left"><?=$int_order_desc['KTEXT'];?></td>
		<td align="left"><?=$data['po_cost_center']['ASSET_NO'][$i];?></td>
	</tr>
<?php
	endfor;
endif;
?>
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>&nbsp;</tr>
	<tr>
		<td align="center">
		<?php if ((strcasecmp($data['po_approval_header']['status_string'],'approved')!=0)
                  &&(strcasecmp($data['po_approval_header']['status_string'],'rejected')!=0)) : ?>
    		<?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
		<?php endif; ?>
		<?php if ((strcasecmp($data['po_approval_header']['status_string'],'approved')==0)
                  &&(strcasecmp($data['po_approval_header']['status_string'],'rejected')!=0)) : ?>
    		<?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_cancel'));?>
		<?php endif; ?>
		<?php if ((strcasecmp($data['po_approval_header']['status_string'],'rejected')!=0)&&
                  (strcasecmp($data['po_approval_header']['status_string'],'approved')!=0)) : ?>
    		<?=form_submit($this->config->item('button_reject'), $this->lang->line('button_reject'));?>
		<?php endif; ?>
        </td>
	</tr>
</table>
<?=form_close();?>
