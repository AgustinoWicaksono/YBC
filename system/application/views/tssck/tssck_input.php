<?php
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Purchase Order Number </strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Goods Issue Number </strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Plant</strong></td>
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
	<?php if(!empty($data['receiving_plant'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Receiving Plant</strong></td>
		<td class="column_input"><?=form_hidden('receiving_plant', $data['receiving_plant']);?><?=form_dropdown('receiving_plant', $receiving_plant, $data['receiving_plant'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['do_no'])) : echo anchor('tssck/input', '<strong>Pilih ulang Receiving Plant dan Delivery Number</strong>'); else : echo anchor('tssck/input', '<strong>Pilih Ulang Receiving Plant</strong>'); endif; endif;?>
        </td>
	</tr>
	<?php else : ?>
  <tr>
    <td class="table_field_1"><strong>Receiving Plant</strong></td>
		<td class="column_input"><?=form_dropdown('receiving_plant', $receiving_plant, "", 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
	<?php if(!empty($data['receiving_plant']) && !empty($data['do_no'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Delivery Order Number</strong></td>
		<td class="column_input"><?=form_hidden('do_no', $data['do_no']);?><?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" disabled="disabled"');?></td>
	</tr>
	<?php elseif(!empty($data['receiving_plant'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Delivery Order Number</strong></td>
		<td class="column_input"><?=form_dropdown('do_no', $do_no, $data['do_no'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	<?php endif; ?>
	<?php if(!empty($data['receiving_plant']) && !empty($data['do_no'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>