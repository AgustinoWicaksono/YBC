<?php
$function = $this->uri->segment(2);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('grpofg_header[id_grpofg_header]', $this->uri->segment(3));
}
?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td class="table_field_h"><?php echo $this->m_grpofg->posto_lastupdate(); ?> 
<?php /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>
    </td>
	</tr>
  <tr>
    <td class="table_field_1"><strong>Delivery Order Number</strong></td>
		<td class="column_input"><strong><?=form_hidden('grpofg_header[do_no]', $grpofg_header['VBELN']);?><?=$grpofg_header['VBELN'];?></strong>
        <?php if($function == 'input2') echo ' '.anchor('grpofg/input', '<strong>Pilih ulang Delivery Order dan Jenis Material</strong>');?></td>
  </tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt PO Number </strong></td>
		<td class="column_input"><strong><?=empty($data['grpofg_header']['grpo_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grpofg_header']['grpo_no'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt FG Number </strong></td>
		<td class="column_input"><strong><?=empty($data['grpofg_header']['grfg_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grpofg_header']['grfg_no'];?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><?=form_hidden('grpofg_header[delivery_date]', $grpofg_header['delivery_date']);?>
        <strong><?php if(!empty($grpofg_header['delivery_date'])) : ?><?=$this->l_general->sqldate_to_date($grpofg_header['delivery_date']);?><?php endif; ?></strong></td>
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
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grpofg_header']['status_string'];?></strong></td>
	</tr>	
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
<?=form_hidden("grpofg_header[item_group_code]", $grpofg_header['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpofg_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['grpofg_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['grpofg_header']['posting_date']));
        } else {
    		$posting_date = $data['grpofg_header']['posting_date'];
        }

    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpofg_header']['posting_date']));
?>
		<td class="column_input">
		<?php /* //disabled-20111011- requested by Bu Narti
		<?php if(($data['grpofg_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grpofg_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grpofg_header[posting_date]'
					});
		</script><?php else: ?>
		
		//end of disabled-20111011- requested by Bu Narti 
		*/
		?>
		<?=$posting_date;?><?=form_hidden("grpofg_header[posting_date]", $posting_date);?>
		<?php /*
		//disabled-20111011- requested by Bu Narti
		<?php endif;?>
		//end of disabled-20111011- requested by Bu Narti
		*/ ?>
		</td>
	</tr>
</table>
<table width="1038" border="0" bordercolor="#000000" align="center">
  <tr bgcolor="#999999">
    <td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material No CK</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material No POS</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material Desc CK</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Outstanding Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>GR PO Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>GR FG Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
    <?php if(($data['grpofg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
    <td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td>
    <?php endif; ?>
  </tr>
  <?php
//if($data['grpofg_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['grpofg_detail']['id_grpofg_detail'])) {
   	  $count = count($data['grpofg_detail']['id_grpofg_detail']);
    } else {
   	  $count = count($grpofg_detail['id_grpofg_h_detail']);
    }
    $gr_quantity = $this->session->userdata('gr_quantity');

	for($i = 1; $i <= $count; $i++) :
		if($data['grpofg_header']['status'] == '1' || ( ($data['grpofg_header']['status'] == '2') && !empty($data['grpofg_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if($function == 'input2' && count($_POST) == 0) {
			$data['grpofg_detail']['gr_quantity'][$i] = $grpofg_detail['LFIMG'][$i];
			$data['grpofg_detail']['grfg_quantity'][$i] = $grpofg_detail['LFIMG'][$i];
        }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td><?php if(!isset($data['grpofg_header']['status']) || $data['grpofg_header']['status'] == '1') : ?>
        <?=form_hidden("grpofg_detail[id_grpofg_h_detail][$i]", $grpofg_detail['id_grpofg_h_detail'][$i]);?>
      <?=form_hidden("grpofg_detail[id_grpofg_detail][$i]", $data['grpofg_detail']['id_grpofg_detail'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
        <?php
//		if($data['grpofg_header']['status'] == '2') {
//          $outstanding_qty = $data['grpofg_detail']['outstanding_qty'][$i];
//        } else {
//        }
        if($function=='edit') {
          $item = $data['grpofg_detail']['item'][$i];
          $material_no = $data['grpofg_detail']['material_no'][$i];
          $material_no_pos = $data['grpofg_detail']['material_no_pos'][$i];
          $material_desc = $data['grpofg_detail']['material_desc'][$i];
          $uom = $data['grpofg_detail']['uom'][$i];
          $outstanding_qty = 0;
          $count_h = count($grpofg_detail['POSNR']);
          for ($h=1;$h<=$count_h;$h++) {
            if ($data['grpofg_detail']['item'][$i]==$grpofg_detail['POSNR'][$h]) {
              $outstanding_qty = $grpofg_detail['LFIMG'][$h];
              break;
            }
          }
        } else {
          $item = $grpofg_detail['POSNR'][$i];
          $material_no = $grpofg_detail['MATNR'][$i];
          $material_pos = $this->m_grpofg->grpofg_map_item_ck_pos_select($material_no);
          $material_no_pos = $material_pos['material_no_pos'];
          $material_desc = $grpofg_detail['MAKTX'][$i];
          $uom = $grpofg_detail['VRKME'][$i];
          $outstanding_qty = $grpofg_detail['LFIMG'][$i];
        }
        ?>
		<td><?=$this->l_general->remove_0_digit_in_item_code($material_no);?>
        <?=form_hidden("grpofg_detail[item][$i]", $item);?>
        <?=form_hidden("grpofg_detail[material_no][$i]",$material_no);?></td>
		<td><?=$material_no_pos;?><?=form_hidden("grpofg_detail[material_no_pos][$i]", $material_no_pos);?></td>
		<td><?=$material_desc;?><?=form_hidden("grpofg_detail[material_desc][$i]", $material_desc);?></td>
		<td align="center"><?=number_format($outstanding_qty, 3, '.', ',');?><?=form_hidden("grpofg_detail[outstanding_qty][$i]",$outstanding_qty);?></td>
        <td align="center"><?php
		if($data['grpofg_header']['status'] != '2') {
			if(!empty($error) && in_array("grpofg_detail[gr_quantity][$i]", $error)) {
				echo form_input("grpofg_detail[gr_quantity][$i]", number_format($data['grpofg_detail']['gr_quantity'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grpofg_detail[gr_quantity][$i]", number_format($gr_quantity[$i], 3, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grpofg_detail[gr_quantity][$i]", number_format($data['grpofg_detail']['gr_quantity'][$i], 3, '.', ''), 'class="input_number" size="8"');
            }
			}
		} else {
			echo number_format($data['grpofg_detail']['gr_quantity'][$i], 3, '.', ',');
		}
		?></td>
        <td align="center"><?php
		if($data['grpofg_header']['status'] != '2') {
			if(!empty($error) && in_array("grpofg_detail[grfg_quantity][$i]", $error)) {
				echo form_input("grpofg_detail[grfg_quantity][$i]", number_format($data['grpofg_detail']['grfg_quantity'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
			if(!empty($grfg_quantity)) {
          	echo form_input("grpofg_detail[grfg_quantity][$i]", number_format($grfg_quantity[$i], 3, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grpofg_detail[grfg_quantity][$i]", number_format($data['grpofg_detail']['grfg_quantity'][$i], 3, '.', ''), 'class="input_number" size="8"');
            }
			}
		} else {
			echo number_format($data['grpofg_detail']['grfg_quantity'][$i], 3, '.', ',');
		}
		?></td>
		<td><?=$uom;?><?=form_hidden("grpofg_detail[uom][$i]", $uom);?></td>
    <?php if(($data['grpofg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center"><?php if($data['grpofg_detail']['ok_cancel'][$i]==FALSE): ?>
        <?=form_checkbox('cancel['.$i.']', $data['grpofg_detail']['id_grpofg_h_detail'][$i], FALSE);?>
      <?php else: ?>
      <?=$data['grpofg_detail']['ok_cancel'][$i];?>
      <?php endif; ?></td>
    <?php endif; ?>
  </tr>
  <?php
	endfor;
?>
  <?php if(($data['grpofg_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?>
        <?=form_hidden('count', $j);?></td>
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
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['grpofg_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?><a href="#" onclick="window.open('<?=base_url();?>help/Goods Receipt PO STO with Delivery.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a>
        </td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('grpofg/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
