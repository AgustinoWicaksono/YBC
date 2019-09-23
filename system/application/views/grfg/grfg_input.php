<?php
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Goods Receipt FG No.</strong></td>
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
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input">
         <?php if((!empty($_POST))&&(!empty($data['item_group_code']))) : ?>
         <?=form_hidden('item_group_code', $data['item_group_code']);?>
         <?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();" disabled="disabled"');?>
         <? echo anchor('grfg/input', '<strong>Pilih Ulang Material Group</strong>'); ?>
         <?else : ?><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');;?>
         <?endif;?>
         </td>
	</tr>
	<?php if(!empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>