
<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php

mysql_query("update m_item set VOL_TEMP =0 ");
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="1038" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<tr>
	<?php if(!empty($data['item_choose'])) : ?>
		<td class="table_field_1"><strong>Item Code</strong></td>
        <?php if((!empty($_POST))&&(!empty($data['item']))) : ?>
           <td class="column_input">
           <?=form_hidden('twtsnew_header[kode_paket]', $data['item']);?><?=$data['item'];?></td>
           <tr>
  		   <td class="table_field_1"><strong>Nama Item BOM </strong></td>
           <td class="column_input"><?=form_hidden('twtsnew_header[nama_paket]', $item_paket_name);?><?=$item_paket_name;?></td>
           </tr>
        <?else : ?>
           <td class="column_input"><?=form_dropdown('item', $item, $data['item'], ' data-placeholder="Pilih item..." class="chosen-select input_text" onChange="document.form1.submit();"');?></td>
          <tr>
		<?endif;?>
	<?php endif; ?>
	</tr>
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