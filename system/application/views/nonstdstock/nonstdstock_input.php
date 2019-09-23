<?php
//echo "<pre>";
//print_r($request_reasons);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Purchase Requesition Number </strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet From</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
	<?php if(!empty($data['request_reason'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Request Reason</strong></td>
        <?=form_hidden('request_reason', $data['request_reason']);?>
		<td class="column_input"><?=form_dropdown('request_reason', $request_reasons, $data['request_reason'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['item_group_code'])) : echo anchor('nonstdstock/input', '<strong>Pilih ulang Request Reason dan Material Group</strong>'); else : echo anchor('nonstdstock/input', '<strong>Pilih Ulang Request Reason</strong>'); endif; endif;?>
        </td>
	</tr>
	<?php else : ?>
  <tr>
    <td class="table_field_1"><strong>Request Reason</strong></td>
		<td class="column_input"><?=form_dropdown('request_reason', $request_reasons, "", 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
	<?php if(!empty($data['request_reason']) && !empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group_code', $data['item_group_code']);?><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" disabled="disabled"');?></td>
	</tr>
	<?php elseif(!empty($data['request_reason'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
	<?php if(!empty($data['request_reason']) && !empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>