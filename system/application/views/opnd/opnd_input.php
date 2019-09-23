<?php
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=validation_errors('<div class="error">','</div>');?>
<?=form_open($this->uri->uri_string(), $form1);?>
<table width="900" border="0" align="center">
	<tr>
		<td width="272" class="table_field_1"><strong>Periode Opname</strong></td>
		<td class="column_input"><?=form_dropdown('periode', $periodes, $data['periode'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php if(!empty($data['periode'])) : ?>
	<tr>
		<td width="272" class="table_field_1"><strong>Urutan Item Berdasarkan</strong></td>
		<td class="column_input"><?=form_dropdown('item_choose', $item_choose, $data['item_choose'], 'class="input_text" onChange="document.form1.submit();"');?></td>
	</tr>
	<?php endif; ?>
</table>
<?=form_close();?>