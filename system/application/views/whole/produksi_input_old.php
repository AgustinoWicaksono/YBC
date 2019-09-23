<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Purchase Order / SR Number </strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Retur Number </strong></td>	
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
	<?php if(!empty($data['receiving_plant'])) : ?>
  <tr>
    <td class="table_field_1"><strong>Transfer Out to Outlet</strong></td>
		<td class="column_input"><?=form_hidden('receiving_plant', $data['receiving_plant']);?><?=form_dropdown('receiving_plant', $receiving_plant, $data['receiving_plant'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['item_group_code'])) : echo anchor('gisto_dept/input', '<strong>Pilih ulang Transfer Out to Outlet dan Material Group</strong>'); else : echo anchor('gisto_dept/input', '<strong>Pilih Ulang Transfer Out to Outlet</strong>'); endif; endif;?>
        </td>
	</tr>
	<?php else : ?>
  <tr>
    <td class="table_field_1"><strong>Transfer Out to Outlet</strong></td>
		<td class="column_input"><?=form_dropdown('receiving_plant', $receiving_plant, "", ' data-placeholder="Pilih outlet..." class="chosen-select input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
	<?php if(!empty($data['receiving_plant']) && !empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group_code', $data['item_group_code']);?><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" disabled="disabled"');?></td>
	</tr>
	<?php elseif(!empty($data['receiving_plant'])) : ?>
	<tr>
    
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], ' data-placeholder="Pilih material group..." class="chosen-select input_text" style="width:250px;" onChange="document.form1.submit();"');?></td>
	<?php endif; ?>
	<?php if(!empty($data['receiving_plant']) && !empty($data['item_group_code'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>