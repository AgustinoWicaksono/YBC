<?php
$function = $this->uri->segment(2);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('opname_header[id_opname_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
   echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Purchase Requesition Number </strong></td>
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['opname_header']['opname_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Plant</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Request Reason</strong> </td>
		<td class ="column_input">
        <?=form_dropdown('opname_header[request_reason]', $request_reasons, $request_reason, 'class="input_text"');?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Apopnameoved' : $data['opname_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("opname_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
<?php
	if(empty($_POST) && $function == 'input2')
		$delivery_date = date("d-m-Y");
	else if(!empty($data['opname_header']['delivery_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$delivery_date = $data['opname_header']['delivery_date'];
        else
    		$delivery_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['opname_header']['delivery_date'])));
?>
		<td class="column_input"><?=form_input('opname_header[delivery_date]', $delivery_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'opname_header[delivery_date]'
					});
		</script></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Created Date</strong></td>
<?php
	if(empty($_POST) && $function == 'input2')
		$created_date = date("d-m-Y");
	else if(!empty($data['opname_header']['created_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$created_date = $data['opname_header']['created_date'];
        else
    		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['opname_header']['created_date'])));
?>
		<td class="column_input"><?=form_input('opname_header[created_date]', $created_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'opname_header[created_date]'
					});
		</script></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['opname_header']['status'])) : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Price / Item</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
	</tr>
<?php
//if($data['opname_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $opname_detail_tmp = $this->session->userdata('opname_detail');
    if(!empty($opname_detail_tmp)) {
       $data['opname_detail'] = $opname_detail_tmp;
    }

    $count = count($data['opname_detail']['id_opname_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($opname_detail_tmp)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($opname_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['opname_header']['status'] == '1' || ( ($data['opname_header']['status'] == '2') && !empty($data['opname_detail']['requirement_qty'][$i]) && !empty($data['opname_detail']['opnameice'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("opname_detail[requirement_qty][$i]", $error) || in_array("opname_detail[material_no][$i]", $error || in_array("opname_detail[opnameice][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['opname_detail']['material_no'][$i]);
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['opname_header']['status'])) : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['opname_header']['status'])) : ?>
        <?=form_hidden("opname_detail[id_opname_h_detail][$k]", $data['opname_detail']['id_opname_h_detail'][$k]);?>
        <?=form_hidden("opname_detail[id_opname_detail][$k]", $data['opname_detail']['id_opname_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("opname_detail[material_no][$k]", $data['opname_detail']['material_no'][$i]);?><?=$data['opname_detail']['material_no'][$i];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("opname_detail[requirement_qty][$i]", $error)) {
				echo form_input("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i], 'class="error_number" size="6"');
			} else {
				echo form_hidden("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i]);
				echo $data['opname_detail']['requirement_qty'][$i];
			}
?></td>
<td align="center">
<?php
			if(!empty($error) && in_array("opname_detail[opnameice][$i]", $error)) {
				echo form_input("opname_detail[opnameice][$k]", $data['opname_detail']['opnameice'][$i], 'class="error_number" size="6"');
			} else {
				echo form_hidden("opname_detail[opnameice][$k]", $data['opname_detail']['opnameice'][$i]);
				echo $data['opname_detail']['opnameice'][$i];
			}
?></td>
		<td><?=$item_x[$i]['MEINS'];?></td>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
 //	if($data['opname_header']['status'] != '2') :

?>
	<tr>
<?php
//if(!isset($data['opname_header']['status']) || $data['opname_header']['status'] == '1') :
if(!isset($data['opname_header']['status'])) :
?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['opname_header']['status'])) : ?><?=form_hidden("opname_detail[id_opname_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("opname_detail[material_no][$i]", $error)) {
			echo form_dropdown("opname_detail[material_no][$k]", $item, $data['opname_detail']['material_no'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("opname_detail[material_no][$k]", $item, $data['opname_detail']['material_no'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("opname_detail[requirement_qty][$i]", $error)) {
			echo form_input("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i], 'class="error_number" size="6"');
		} else {
			echo form_input("opname_detail[requirement_qty][$k]", $data['opname_detail']['requirement_qty'][$i], 'class="input_number" size="6"');
		}
		?>
		</td>
        <td align="center">
		<?php
		if(!empty($error) && in_array("opname_detail[opnameice][$i]", $error)) {
			echo form_input("opname_detail[opnameice][$k]", $data['opname_detail']['opnameice'][$i], 'class="error_number" size="6"');
		} else {
			echo form_input("opname_detail[opnameice][$k]", $data['opname_detail']['opnameice'][$i], 'class="input_number" size="6"');
		}
		?>
		</td>
	</tr>
<?php
//	endif;
?>
<?php
//endif;
?>
</table>
<table width="300" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center"><?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?> <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?></td>
	</tr>
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['opname_header']['status'] == '2') : ?>
        <?=form_submit($this->config->item('button_apopnameove'), $this->lang->line('button_change'));?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?> <?=form_submit($this->config->item('button_apopnameove'), $this->lang->line('button_apopnameove'));?> <?php endif; ?> <?=anchor('opname/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
<script language="javascript">
	function selectAll(){
//		t=document.form2.length;
//		document.write(t);
		//for(i=1; i<t-1; i++)
		for(i=1; i <= <?=$j;?>; i++)
			document.form1[i].checked=document.form1[<?=++$j;?>].checked;
	}
</script>