<?php
$function = $this->uri->segment(2);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('stdstock_header[id_stdstock_header]', $this->uri->segment(3));?>
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
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['stdstock_header']['pr_no'];?></td>
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
        <?=form_dropdown('stdstock_header[request_reason]', $request_reasons, $request_reason, 'class="input_text"');?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['stdstock_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("stdstock_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
<?php
	if(empty($_POST) && $function == 'input2')
		$delivery_date = date("d-m-Y");
	else if(!empty($data['stdstock_header']['delivery_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$delivery_date = $data['stdstock_header']['delivery_date'];
        else
    		$delivery_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['delivery_date'])));
?>
		<td class="column_input"><?=form_input('stdstock_header[delivery_date]', $delivery_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stdstock_header[delivery_date]'
					});
		</script></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Created Date</strong></td>
<?php
	if(empty($_POST) && $function == 'input2')
		$created_date = date("d-m-Y");
	else if(!empty($data['stdstock_header']['created_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$created_date = $data['stdstock_header']['created_date'];
        else
    		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['stdstock_header']['created_date'])));
?>
		<td class="column_input"><?=form_input('stdstock_header[created_date]', $created_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stdstock_header[created_date]'
					});
		</script></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['stdstock_header']['status'])) : ?>
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
//if($data['stdstock_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $stdstock_detail_tmp = $this->session->userdata('stdstock_detail');
    if(!empty($stdstock_detail_tmp)) {
       $data['stdstock_detail'] = $stdstock_detail_tmp;
    }

    $count = count($data['stdstock_detail']['id_stdstock_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($stdstock_detail_tmp)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($stdstock_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['stdstock_header']['status'] == '1' || ( ($data['stdstock_header']['status'] == '2') && !empty($data['stdstock_detail']['requirement_qty'][$i]) && !empty($data['stdstock_detail']['price'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("stdstock_detail[requirement_qty][$i]", $error) || in_array("stdstock_detail[material_no][$i]", $error || in_array("stdstock_detail[price][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['stdstock_detail']['material_no'][$i]);
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['stdstock_header']['status'])) : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['stdstock_header']['status'])) : ?>
        <?=form_hidden("stdstock_detail[id_stdstock_h_detail][$k]", $data['stdstock_detail']['id_stdstock_h_detail'][$k]);?>
        <?=form_hidden("stdstock_detail[id_stdstock_detail][$k]", $data['stdstock_detail']['id_stdstock_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("stdstock_detail[material_no][$k]", $data['stdstock_detail']['material_no'][$i]);?><?=$data['stdstock_detail']['material_no'][$i];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("stdstock_detail[requirement_qty][$i]", $error)) {
				echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="error_number" size="6"');
			} else {
				echo form_hidden("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i]);
				echo $data['stdstock_detail']['requirement_qty'][$i];
			}
?></td>
<td align="center">
<?php
			if(!empty($error) && in_array("stdstock_detail[price][$i]", $error)) {
				echo form_input("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i], 'class="error_number" size="6"');
			} else {
				echo form_hidden("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i]);
				echo $data['stdstock_detail']['price'][$i];
			}
?></td>
		<td><?=$item_x[$i]['MEINS'];?></td>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
 //	if($data['stdstock_header']['status'] != '2') :

?>
	<tr>
<?php
//if(!isset($data['stdstock_header']['status']) || $data['stdstock_header']['status'] == '1') :
if(!isset($data['stdstock_header']['status'])) :
?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['stdstock_header']['status'])) : ?><?=form_hidden("stdstock_detail[id_stdstock_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("stdstock_detail[material_no][$i]", $error)) {
			echo form_dropdown("stdstock_detail[material_no][$k]", $item, $data['stdstock_detail']['material_no'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("stdstock_detail[material_no][$k]", $item, $data['stdstock_detail']['material_no'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("stdstock_detail[requirement_qty][$i]", $error)) {
			echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="error_number" size="6"');
		} else {
			echo form_input("stdstock_detail[requirement_qty][$k]", $data['stdstock_detail']['requirement_qty'][$i], 'class="input_number" size="6"');
		}
		?>
		</td>
        <td align="center">
		<?php
		if(!empty($error) && in_array("stdstock_detail[price][$i]", $error)) {
			echo form_input("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i], 'class="error_number" size="6"');
		} else {
			echo form_input("stdstock_detail[price][$k]", $data['stdstock_detail']['price'][$i], 'class="input_number" size="6"');
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
		<td align="center"><?php if($data['stdstock_header']['status'] == '2') : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_change'));?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?> <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?> <?php endif; ?> <?=anchor('stdstock/browse', $this->lang->line('button_back'));?></td>
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