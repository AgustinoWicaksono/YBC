<table class="table-browse">
	<tr>
		<td class="column_description">Vendor Code</td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=$data_1['vendor_code'];?></td>
	</tr>
	<tr>
		<td class="column_description">Vendor Name</td>
		<td class="column_colon">:</td>
		<td class="column_input"><?=$data_1['vendor_name'];?></td>
	</tr>
</table>
<table class="table-browse">
	<tr>
		<th width="10" class="table_header_1">#</th>
		<th class="table_header_1">Item</th>
		<th class="table_header_1">Material No</th>
		<th class="table_header_1">Material Desc</th>
		<th class="table_header_1">Outstanding Qty</th>
		<th class="table_header_1">GR Qty</th>
		<th class="table_header_1">Uom</th>
		<th class="table_header_1">Plant</th>
		<th class="table_header_1">Storage Location</th>
	</tr>
<?php
if($data['purchase'] !== FALSE) :
	$i = 1;
	foreach ($data['purchase']->result_array() as $purchase):
?>
	<tr>
		<td class="table_content_1" width="10" align="right"><?=$i++;?><?=form_hidden("purchase_id[$i]", $purchase['purchase_id']);?></td>
		<td class="table_content_1"><?=$purchase['item'];?></td>
		<td class="table_content_1"><?=$purchase['material_no'];?></td>
		<td class="table_content_1"><?=$purchase['material_desc'];?></td>
		<td class="table_content_1" width="10" align="right"><?=$purchase['outstanding_qty'];?></td>
		<td class="table_content_1"><?=form_input("gr_quantity[$i]", $data['gr_quantity'], 'class="input_text" size="2"');?></td>
		<td class="table_content_1"><?=$purchase['uom'];?></td>
		<td class="table_content_1"><?=$purchase['plant'];?></td>
		<td class="table_content_1"><?=$purchase['storage_location'];?></td>
	</tr>
<?php
	endforeach;
endif;
?>
</table>
