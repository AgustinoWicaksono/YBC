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
    <td width="272" class="table_field_1"><strong>SR Number </strong>&mdash; <i>Transfer In Inter Outlet</i></td>
  <?php if(!empty($data['po_no'])) : ?>
		<td class="column_input"><?=form_hidden('po_no', $data['po_no']);?><?=form_dropdown('po_no', $po_no, $data['po_no'], 'class="input_text" disabled="disabled"');?>
        <?php if(!empty($_POST)) : if(!empty($data['po_no'])) : echo anchor('grsto/input', '<strong>Pilih ulang SR Number</strong>'); endif; endif;?>
        </td>
	<?php else : ?>
		<td class="column_input"><?=form_dropdown('po_no', $po_no, $data['po_no'], 'data-placeholder="Pilih Nomor SR" class="chosen-select input_text" onChange="document.form1.submit();"');?></td>
	<?php endif; ?>
	</tr>
<?php if(isset($_POST['po_no'])) : ?>
	<tr>
		<td class="table_field_1"><strong> Transfer Out No</strong></td>
	  <td class="column_input"><strong><?=$data['grsto_header']['MBLNR'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Transfer In Number </strong></td>
		<td class="column_input"><em>(Auto Number after Posting to SAP)</em></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet </strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Transit Location </strong></td>
	  <td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Outlet </strong> </td>
		<td class="column_input"><strong><?=$data['grsto_header']['SUPPL_PLANT'];?><?=" - ";?><?=$data['grsto_header']['SPLANT_NAME'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><strong><?php if(!empty($data['grsto_header']['DELIV_DATE'])) : ?><?=$this->l_general->sqldate_to_date($data['grsto_header']['DELIV_DATE']);?><?php endif; ?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class="column_input"><strong>Not Approved</strong></td>
	</tr>
<?php endif; ?>
<?php if(!empty($data['po_no'])) : ?>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_dropdown('item_group_code', $item_group_code, $data['item_group_code'], 'class="input_text" onChange="document.form1.submit();"');?></td>
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