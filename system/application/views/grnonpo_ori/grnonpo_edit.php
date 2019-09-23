<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($grnonpo_detail);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('grnonpo_header[id_grnonpo_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Goods Receipt No.</strong></td>
		<td class="column_input"><?=empty($data['grnonpo_header']['grnonpo_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grnonpo_header']['grnonpo_no'];?></td>
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
		<td class="table_field_1"><strong>Cost Center</strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['cost_center'].' - '.$this->session->userdata['ADMIN']['cost_center_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grnonpo_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_code'];?><?=form_hidden("grnonpo_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grnonpo_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	else if(!empty($data['grnonpo_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
    		$posting_date = $data['grnonpo_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['grnonpo_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['grnonpo_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['grnonpo_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grnonpo_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grnonpo_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("grnonpo_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['grnonpo_header']['status']) || $data['grnonpo_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Text</strong></div></td>
		<?php if(($data['grnonpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['grnonpo_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $grnonpo_detail_tmp = $this->session->userdata('grnonpo_detail');
    if(!empty($grnonpo_detail_tmp)) {
       $data['grnonpo_detail'] = $grnonpo_detail_tmp;
    }

	$count = count($data['grnonpo_detail']['id_grnonpo_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($grnonpo_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['grnonpo_header']['status'] == '1' || ( ($data['grnonpo_header']['status'] == '2') && !empty($data['grnonpo_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("grnonpo_detail[quantity][$i]", $error) || in_array("grnonpo_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['grnonpo_detail']['material_no'][$i]);
            if (!empty($data['grnonpo_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['grnonpo_detail']['material_desc'][$i];
            }
            if (!empty($data['grnonpo_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['grnonpo_detail']['uom'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['grnonpo_header']['status']) || $data['grnonpo_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['grnonpo_header']['status']) || $data['grnonpo_header']['status'] == '1') : ?>
        <?=form_hidden("grnonpo_detail[id_grnonpo_h_detail][$k]", $data['grnonpo_detail']['id_grnonpo_h_detail'][$k]);?>
        <?=form_hidden("grnonpo_detail[id_grnonpo_detail][$k]", $data['grnonpo_detail']['id_grnonpo_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("grnonpo_detail[material_no][$k]", $data['grnonpo_detail']['material_no'][$i]);?><?=$data['grnonpo_detail']['material_no'][$i];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("grnonpo_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
		<td align="center">
<?php
			if(!empty($error) && in_array("grnonpo_detail[quantity][$i]", $error)) {
				echo form_input("grnonpo_detail[quantity][$k]", number_format($data['grnonpo_detail']['quantity'][$i], 2, '.', ','), 'class="error_number" size="8"');
			} else {
				echo form_hidden("grnonpo_detail[quantity][$k]", $data['grnonpo_detail']['quantity'][$i]);
                if($data['grnonpo_header']['status'] == '2')
    				echo number_format($data['grnonpo_detail']['quantity'][$i], 2, '.', ',');
                else
				    echo form_input("grnonpo_detail[quantity][$k]", number_format($data['grnonpo_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['grnonpo_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['grnonpo_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT'];?>
         <?=form_hidden("grnonpo_detail[uom][$k]", $item_x[$i]['UNIT']);?>
        </td>
		<td align="center"><?=form_hidden("grnonpo_detail[additional_text][$k]", $data['grnonpo_detail']['additional_text'][$i]);?>
		<?php if($data['grnonpo_header']['status'] != '2'): ?>
			<?=form_input("grnonpo_detail[additional_text][$k]", $data['grnonpo_detail']['additional_text'][$i], 'class="input_number" size="24"');?>
         <?php else: ?>
            <?=$data['grnonpo_detail']['additional_text'][$i];?></td>
        <?php endif; ?>
		<?php if(($data['grnonpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['grnonpo_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['grnonpo_detail']['id_grnonpo_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['grnonpo_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}

	}
	
	// below is for new data
	if($data['grnonpo_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['grnonpo_header']['status']) || $data['grnonpo_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['grnonpo_header']['status']) || $data['grnonpo_header']['status'] == '1') : ?><?=form_hidden("grnonpo_detail[id_grnonpo_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("grnonpo_detail[material_no][$i]", $error)) {
			echo form_dropdown("grnonpo_detail[material_no][$k]", $item, $data['grnonpo_detail']['material_no'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("grnonpo_detail[material_no][$k]", $item, $data['grnonpo_detail']['material_no'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("grnonpo_detail[quantity][$i]", $error)) {
			echo form_input("grnonpo_detail[quantity][$k]", $data['grnonpo_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("grnonpo_detail[quantity][$k]", $data['grnonpo_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
		<td>&nbsp;</td>
		<td align="center">
		<?php
			echo form_input("grnonpo_detail[additional_text][$k]", $data['grnonpo_detail']['additional_text'][$i], 'class="input_number" size="24"');
		?>
		</td>
	</tr>
<?php
	endif;
?>
<?php if(($data['grnonpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
<?php if($data['grnonpo_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
        <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?>
        </td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['grnonpo_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Goods Receipt Non PO.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('grnonpo/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
