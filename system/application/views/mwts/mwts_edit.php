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
//print_r($mwts_detail);
//echo "</pre>";
//echo '$item_whi_name'.$item_whi_name
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('mwts_header[id_mwts_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if ($function=='edit') {
  $item_whi_code = $data['mwts_header']['kode_whi'];
  $item_whi_name = $data['mwts_header']['nama_whi'];
  $uom_whi = $data['mwts_header']['uom_whi'];
}
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Whole Item Code</strong></td>
		<td class="column_input"><?=form_hidden("mwts_header[kode_whi]", $item_whi_code);?>
        <strong><?=$this->l_general->remove_0_digit_in_item_code($item_whi_code);?></strong> <? if($function!='edit') : echo anchor('mwts/input', '<strong>Pilih Ulang Item Whole</strong>'); endif; ?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Whole Item Description</strong></td>
		<td class="column_input"><?=form_hidden("mwts_header[nama_whi]", $item_whi_name);?>
        <strong><?=$item_whi_name;?></strong></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
		<td width="1038" class="table_header_1"><div align="center"><strong>Slice Material Item</strong></div></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['mwts_header']['status']) || $data['mwts_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1" width="200"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
	</tr>
<?php
//if($data['mwts_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $mwts_detail_tmp = $this->session->userdata('mwts_detail');
    if(!empty($mwts_detail_tmp)) {
       $data['mwts_detail'] = $mwts_detail_tmp;
    }

	$count = count($data['mwts_detail']['id_mwts_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($mwts_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['mwts_header']['status'] == '1' || ( ($data['mwts_header']['status'] == '2') && !empty($data['mwts_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("mwts_detail[quantity][$i]", $error) || in_array("mwts_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['mwts_detail']['material_no'][$i]);
            if (!empty($data['mwts_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['mwts_detail']['material_desc'][$i];
            }
            if (!empty($data['mwts_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['mwts_detail']['uom'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['mwts_header']['status']) || $data['mwts_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center">
        <?=form_hidden("mwts_detail[id_mwts_h_detail][$k]", $data['mwts_detail']['id_mwts_h_detail'][$k]);?>
        <?=form_hidden("mwts_detail[id_mwts_detail][$k]", $data['mwts_detail']['id_mwts_detail'][$k]);?>
        <?=$k;?></td>
		<td align="left"><?=form_hidden("mwts_detail[material_no][$k]", $data['mwts_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("mwts_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
		<td align="center">
<?php
			if(!empty($error) && in_array("mwts_detail[quantity][$i]", $error)) {
				echo form_input("mwts_detail[quantity][$k]", number_format($data['mwts_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("mwts_detail[quantity][$k]", $data['mwts_detail']['quantity'][$i]);
                if($data['mwts_header']['status'] != '2')
   				  echo form_input("mwts_detail[quantity][$k]", number_format($data['mwts_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
   				  echo number_format($data['mwts_detail']['quantity'][$i], 2, '.', ',');
			}
?></td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['mwts_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['mwts_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT'];?>
         <?=form_hidden("mwts_detail[uom][$k]", $item_x[$i]['UNIT']);?>
        </td>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['mwts_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['mwts_header']['status']) || $data['mwts_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['mwts_header']['status']) || $data['mwts_header']['status'] == '1') : ?><?=form_hidden("mwts_detail[id_mwts_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
        
		<?php
		if(!empty($error) && in_array("mwts_detail[material_no][$i]", $error)) {
			echo form_dropdown("mwts_detail[material_no][$k]", $item, $data['mwts_detail']['material_no'][$i], 'class="error_text chosen-select"');
		} else {
			echo form_dropdown("mwts_detail[material_no][$k]", $item, $data['mwts_detail']['material_no'][$i], 'class="input_text chosen-select"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("mwts_detail[quantity][$i]", $error)) {
			echo form_input("mwts_detail[quantity][$k]", $data['mwts_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("mwts_detail[quantity][$k]", $data['mwts_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
	</tr>
<?php
	endif;
?>
<?php if(($data['mwts_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="6">&nbsp;</td>
		<td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', $j);?></td>
	</tr>
<script language="javascript">
	function selectAll(){
		for(i=1; i <= <?=$j;?>; i++)
			document.getElementById('cancel['+i+']').checked = document.getElementById('select_all').checked;
	}
</script>
<?php endif; ?>
<?php
//endif;
?>
</table>
<?php if($data['mwts_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>
<?php endif; ?>
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
    <td align="center"><?=anchor('mwts/browse', $this->lang->line('button_back'));?></td>
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
