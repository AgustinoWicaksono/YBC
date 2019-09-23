<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($grfg_detail);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('grfg_header[id_grfg_header]', $this->uri->segment(3));?>
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
		<td width="272" class="table_field_1"><strong>Goods Receipt FG. No.</strong></td>
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grfg_header']['grfg_no'];?></td>
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
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grfg_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_code'];?><?=form_hidden("grfg_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grfg_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
		$posting_date = date("d-m-Y");
	else if(!empty($data['grfg_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$posting_date = $data['grfg_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['grfg_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['grfg_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['grfg_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grfg_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grfg_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("grfg_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['grfg_header']['status']) || $data['grfg_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Goods Receipt Qty.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<?php if(($data['grfg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['grfg_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $grfg_detail_tmp = $this->session->userdata('grfg_detail');
    if(!empty($grfg_detail_tmp)) {
       $data['grfg_detail'] = $grfg_detail_tmp;
    }

	$count = count($data['grfg_detail']['id_grfg_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($grfg_detail_tmp))&&($count==1))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($grfg_detail_tmp);
	for($i = 1; $i <= $count2; $i++) {

		if($data['grfg_header']['status'] == '1' || ( ($data['grfg_header']['status'] == '2') && !empty($data['grfg_detail']['gr_quantity'][$i]))) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("grfg_detail[gr_quantity][$i]", $error) || in_array("grfg_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['grfg_detail']['material_no'][$i]);
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['grfg_header']['status']) || $data['grfg_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['grfg_header']['status']) || $data['grfg_header']['status'] == '1') : ?>
        <?=form_hidden("grfg_detail[id_grfg_h_detail][$k]", $data['grfg_detail']['id_grfg_h_detail'][$k]);?>
        <?=form_hidden("grfg_detail[id_grfg_detail][$k]", $data['grfg_detail']['id_grfg_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("grfg_detail[material_no][$k]", $data['grfg_detail']['material_no'][$i]);?><?=$data['grfg_detail']['material_no'][$i];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("grfg_detail[gr_quantity][$i]", $error)) {
				echo form_input("grfg_detail[gr_quantity][$k]", $data['grfg_detail']['gr_quantity'][$i], 'class="error_number" size="6"');
			} else {
				echo form_hidden("grfg_detail[gr_quantity][$k]", $data['grfg_detail']['gr_quantity'][$i]);
                if($data['grfg_header']['status'] != '2')
    			   echo form_input("grfg_detail[gr_quantity][$k]", $data['grfg_detail']['gr_quantity'][$i], 'class="input_number" size="6"');
                else
    			   echo $data['grfg_detail']['gr_quantity'][$i];
			}
?></td>
		<td><?=$item_x[$i]['UNIT'];?></td>
		<?php if(($data['grfg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['grfg_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['grfg_detail']['id_grfg_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['grfg_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['grfg_header']['status'] != '2') :
?>
	<tr>
<?php if((!isset($data['grfg_header']['status']) || $data['grfg_header']['status'] == '1'))
         : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center">
        <?php if((!isset($data['grfg_header']['status']) || $data['grfg_header']['status'] == '1')) : ?>
        <?=form_hidden("grfg_detail[id_grfg_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("grfg_detail[material_no][$i]", $error)) {
			echo form_dropdown("grfg_detail[material_no][$k]", $item, $data['grfg_detail']['material_no'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("grfg_detail[material_no][$k]", $item, $data['grfg_detail']['material_no'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("grfg_detail[gr_quantity][$i]", $error)) {
			echo form_input("grfg_detail[gr_quantity][$k]", $data['grfg_detail']['gr_quantity'][$i], 'class="error_number" size="6"');
		} else {
			echo form_input("grfg_detail[gr_quantity][$k]", $data['grfg_detail']['gr_quantity'][$i], 'class="input_number" size="6"');
		}
		?>
		</td>
		<td>&nbsp;</td>
	</tr>
<?php
	endif;
?>
<?php if(($data['grfg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', $j);?></td>
	</tr>
<?php endif; ?>
<?php
//endif;
?>
</table>
<?php if($data['grfg_header']['status'] != '2') : ?>
<table width="300" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center"><?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?>
        <?php if((count($data['grfg_detail']['id_grfg_h_detail']) < 1)||isset($_POST['delete'])) : ?>
        <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?php endif; ?>
        </td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['grfg_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?>
        <?=anchor('grfg/browse', $this->lang->line('button_back'));?></td>
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