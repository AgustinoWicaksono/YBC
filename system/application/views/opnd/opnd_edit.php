<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>

<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//echo "</pre>";
//echo '$item_sfg_name'.$item_sfg_name
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('opnd_header[id_opnd_header]', $this->uri->segment(3));?>
<table width="900" border="0" align="center">
<?php
if ($function=='edit') {
  $periode = $data['opnd_header']['periode'];
}
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Periode Opname</strong></td>
		<td class="column_input"><?=form_hidden("opnd_header[periode]", $periode);?>
        <strong><?=$periode;?></strong> <? if($function!='edit') : echo anchor('opnd/input', '<strong>Pilih Ulang Periode Opname</strong>'); endif; ?>
        </td>
	</tr>
</table>
<table width="900" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
		<td width="900" class="table_header_1"><div align="center"><strong>Item Opname Daily</strong></div></td>
	</tr>
</table>
<table width="900" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['opnd_header']['status']) || $data['opnd_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1" width="200"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
	</tr>
<?php
//if($data['opnd_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $opnd_detail_tmp = $this->session->userdata('opnd_detail');
    if(!empty($opnd_detail_tmp)) {
       $data['opnd_detail'] = $opnd_detail_tmp;
    }

	$count = count($data['opnd_detail']['id_opnd_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($opnd_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if(!empty($data['opnd_detail']['material_no'][$i]) ) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && (in_array("opnd_detail[material_no][$i]", $error)))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['opnd_detail']['material_no'][$i]);
            if (!empty($data['opnd_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['opnd_detail']['material_desc'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['opnd_header']['status']) || $data['opnd_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center">
        <?=form_hidden("opnd_detail[id_opnd_h_detail][$k]", $data['opnd_detail']['id_opnd_h_detail'][$k]);?>
        <?=form_hidden("opnd_detail[id_opnd_detail][$k]", $data['opnd_detail']['id_opnd_detail'][$k]);?>
        <?=$k;?></td>
		<td align="left"><?=form_hidden("opnd_detail[material_no][$k]", $data['opnd_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("opnd_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
?>
	<tr>
<?php if(!isset($data['opnd_header']['status']) || $data['opnd_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['opnd_header']['status']) || $data['opnd_header']['status'] == '1') : ?><?=form_hidden("opnd_detail[id_opnd_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("opnd_detail[material_no][$i]", $error)) {
			echo form_dropdown("opnd_detail[material_no][$k]", $item, $data['opnd_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("opnd_detail[material_no][$k]", $item, $data['opnd_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		?>
		</td>
	</tr>
</table>
<table width="600" align="left" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue to Cost Center.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('opnd/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
