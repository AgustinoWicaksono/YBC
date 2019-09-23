<?php
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
		<td class="table_field_1"><strong>BOM Item Code</strong></td>
        <?php if((!empty($_POST))&&(!empty($data['item']))) : ?>
           <td class="column_input">
           <?=form_hidden('mpaket_header[kode_paket]', $data['item']);?><?=$data['item'];?></td>
           <tr>
  		   <td class="table_field_1"><strong>Nama Item BOM </strong></td>
           <td class="column_input"><?=form_hidden('mpaket_header[nama_paket]', $item_paket_name);?><?=$item_paket_name;?></td>
           </tr>
        <?else : ?>
          <td class="column_input"><?=form_dropdown('item', $item, $data['item'], 'class="input_text" onChange="document.form1.submit();"');?></td>
          <tr>
		<?endif;?>
	<?php endif; ?>
	</tr>
</table>
<?=form_close();?>