<?php
$function = $this->uri->segment(2);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('grpo_header[id_grpo_header]', $this->uri->segment(3));
	
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
    <td class="table_field_h"><?php echo $this->m_grpo->po_lastupdate(); ?></td>
	</tr>
	
	<tr>
		<td class="table_field_1"><strong>ID Transaksi  </strong></td>
		<td class="column_input"><?=form_hidden('grpo_header[id_grpo_header]', $grpo_header['id_grpo_header']);?><strong><?=$grpo_header['id_grpo_header'];?></strong></td>
	</tr>
  <tr>
    <td class="table_field_1"><strong>Purchase Order Entry </strong></td>
		<td class="column_input"><?=form_hidden('grpo_header[po_no]', $grpo_header['EBELN']);?><strong><?=$grpo_header['EBELN'];?></strong><?php if($function == 'input2') echo ' '.anchor('grpo/input', '<strong>Pilih ulang Purchase Order dan Jenis Material</strong>');?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Purchase Order Number  </strong></td>
		<td class="column_input"><strong><?=form_hidden('grpo_header[docnum]', $grpo_header['DOCNUM']);?><?=$grpo_header['DOCNUM'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Vendor Code  </strong></td>
		<td class="column_input"><?=form_hidden('grpo_header[kd_vendor]', $grpo_header['kd_vendor']);?><strong><?=$grpo_header['kd_vendor'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Vendor Name </strong></td>
		<td class="column_input"><strong><?=$grpo_header['nm_vendor'];?>
        <?=form_hidden('grpo_header[nm_vendor]', $grpo_header['nm_vendor']);?></strong></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><?=form_hidden('grpo_header[delivery_date]', $grpo_header['delivery_date']);?>
        <strong><?php if(!empty($grpo_header['delivery_date'])) : ?><?=$this->l_general->sqldate_to_date($grpo_header['delivery_date']);?><?php endif; ?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt Number </strong></td>
		<td class="column_input"><?=empty($data['grpo_header']['grpo_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grpo_header']['grpo_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grpo_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
<?=form_hidden("grpo_header[item_group_code]", $grpo_header['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpo_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['grpo_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['grpo_header']['posting_date']));
        } else {
    		$posting_date = $data['grpo_header']['posting_date'];
        }
    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpo_header']['posting_date']));
?>
	  <td align="left" class="column_input"><script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grpo_header[posting_date]'
					});
		</script>
	  <?php if(($data['grpo_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
	  <?=form_input('grpo_header[posting_date]', $posting_date, 'class="input_text" size="10"');?>
	  <?php else: ?>
	  <?=$posting_date;?>
	  <?=form_hidden("grpo_header[posting_date]", $posting_date);?>
	  <?php endif;?></td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['grpo_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?>
        <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?></td>
  </tr>
</table>
<table width="1037" border="0" bordercolor="#000000" align="center">
	<tr bgcolor="#999999">
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Outstanding Qty</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>GR Qty</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
         <td class="table_header_1"><div align="center"><strong>QC</strong></div></td>
		<?php if(($data['grpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
	<?php
//if($data['grpo_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['grpo_detail']['id_grpo_detail'])) {
   	  $count = count($data['grpo_detail']['id_grpo_detail']);
    } else {
      $count = count($grpo_detail['id_grpo_h_detail']);
    }

    $gr_quantity = $this->session->userdata('gr_quantity');

	for($i = 1; $i <= $count; $i++) :
		if($data['grpo_header']['status'] == '1' || ( ($data['grpo_header']['status'] == '2') && !empty($data['grpo_detail']['gr_quantity'][$i]) && !empty($data['grpo_detail']['num'][$i]) )) {
			$j++;
		}

		if($function == 'input2' && count($_POST) == 0)
			$data['grpo_detail']['gr_quantity'][$i] = $grpo_detail['BSTMG'][$i];
?>
<?php if($i % 2) : ?>
  <tr class="table_row_2">
<?php else : ?>
  <tr class="table_row_1">
<?php endif; ?>
		<td><?php if(!isset($data['grpo_header']['status']) || $data['grpo_header']['status'] == '1') : ?><?=form_hidden("grpo_detail[id_grpo_h_detail][$i]", $grpo_detail['id_grpo_h_detail'][$i]);?>
        <?=form_hidden("grpo_detail[id_grpo_detail][$i]", $data['grpo_detail']['id_grpo_detail'][$i]);?>
        <?php endif; ?><?=$i;?></td>
        <?php
        if($function=='edit') {
          $item = $data['grpo_detail']['item'][$i];
          $material_no = $data['grpo_detail']['material_no'][$i];
          $material_desc = $data['grpo_detail']['material_desc'][$i];
          $uom = $data['grpo_detail']['uom'][$i];
          $count_h = count($grpo_detail['EBELP']);
          $outstanding_qty = 0;
          for ($h=1;$h<=$count_h;$h++) {
            if ($data['grpo_detail']['item'][$i]==$grpo_detail['EBELP'][$h]) {
              $outstanding_qty = $grpo_detail['BSTMG'][$h];
              break;
            }
          }
        } else {
          $item = $grpo_detail['EBELP'][$i];
          $material_no = $grpo_detail['MATNR'][$i];
          $material_desc = $grpo_detail['MAKTX'][$i];
          $uom = $grpo_detail['BSTME'][$i];
          $outstanding_qty = $grpo_detail['BSTMG'][$i];
        }
		//echo '{'.$item.'}'; 
        ?>
		
		<td><?=$this->l_general->remove_0_digit_in_item_code($material_no);?>
        <?=form_hidden("grpo_detail[item][$i]", $item);?>
        <?=form_hidden("grpo_detail[material_no][$i]",$material_no);?></td>
		<td><?=$material_desc;?><?=form_hidden("grpo_detail[material_desc][$i]", $material_desc);?></td>
         
       <td align="center"><?=number_format($outstanding_qty, 4, '.', ',');?><?=form_hidden("grpo_detail[outstanding_qty][$i]",$outstanding_qty);?></td>
       
		<td align="center">
		<?php
		if($data['grpo_header']['status'] != '2') {
			if(!empty($error) && in_array("grpo_detail[gr_quantity][$i]", $error)) {
				echo form_input("grpo_detail[gr_quantity][$i]", $data['grpo_detail']['gr_quantity'][$i], 'class="error_number" size="8"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grpo_detail[gr_quantity][$i]", number_format($gr_quantity[$i], 4, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grpo_detail[gr_quantity][$i]", number_format($data['grpo_detail']['gr_quantity'][$i], 4, '.', ''), 'class="input_number" size="8"');
            }
			}
		} else {
			echo number_format($data['grpo_detail']['gr_quantity'][$i], 4, '.', ',');
		}
		?>        </td>
		<td><?=$uom;?><?=form_hidden("grpo_detail[uom][$i]", $uom);?></td>
        <td align="center">
		<?php
			echo form_input("grpo_detail[qc][$i]", $data['grpo_detail']['qc'][$i], 'class="input_number" size="24"');
		?>
		</td>
       
		<?php if(($data['grpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?><td align="center"><?php if($data['grpo_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$i.']', $data['grpo_detail']['id_grpo_h_detail'][$i], FALSE);?><?php else: ?><?=$data['grpo_detail']['ok_cancel'][$i];?><?php endif; ?></td><?php endif; ?>
	</tr>
<?php
	endfor;
?>
<?php if(($data['grpo_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="6">&nbsp;</td>
		<td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?>		  <?=form_hidden('count', $j);?></td>
  </tr>
<?php
$k = 5; // counter from 1st component on form1 until before cancel
$m = $j + $k; // selectAll checkbox number
?>
<script language="javascript">
	function selectAll(){
//		t=document.form2.length;
//		document.write(t);
		//for(i=1; i<t-1; i++)
//		for(i=1; i <= <?=$j;?>; i++)

//		for(i=<?=$k;?>; i < <?=$m;?>; i++)
		for(i=1; i <= <?=$j;?>; i++)
//			document.write(document.form1[i].value + ' ');
//			document.form1[i].checked=document.form1[<?=$m;?>].checked;
//			document.form1.cancel[i].checked=document.form1.select_all.checked;
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
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Receipt PO dari Vendor.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a>         </td>
  </tr>
	<tr>
    <td align="center"><?=anchor('grpo/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?=form_close();?>
