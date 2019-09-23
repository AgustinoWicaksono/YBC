<?php
$function = $this->uri->segment(2);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('grpodlv_header[id_grpodlv_header]', $this->uri->segment(3));
}
?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
  <tr>
    <td width="272" class="table_field_1"><strong>Delivery Order Number </strong></td>
		<td class="column_input"><?=form_hidden('grpodlv_header[do_no]', $grpodlv_header['VBELN']);?><?=$grpodlv_header['VBELN'];?></td>
  </tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt Number </strong></td>	
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grpodlv_header']['grpodlv_no'];?></td>
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
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grpodlv_header']['status_string'];?></strong></td>
	</tr>	
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
<?=form_hidden("grpodlv_header[item_group_code]", $grpodlv_header['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpodlv_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
		$posting_date = date("d-m-Y");
	} else if (!empty($data['grpodlv_header']['posting_date'])) {
		$posting_date = date("d-m-Y", strtotime($data['grpodlv_header']['posting_date']));
    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpodlv_header']['posting_date']));
?>
		<td class="column_input"><?php if(($data['grpodlv_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grpodlv_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grpodlv_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("grpodlv_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
</table>
<table width="1038" border="0" bordercolor="#000000" align="center">
  <tr bgcolor="#999999">
    <td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Outstanding Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>GR Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
    <?php if(($data['grpodlv_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
    <td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td>
    <?php endif; ?>
  </tr>
  <?php
//if($data['grpodlv_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['grpodlv_detail']['id_grpodlv_detail'])) {
   	  $count = count($data['grpodlv_detail']['id_grpodlv_detail']);
    } else {
   	  $count = count($grpodlv_detail['id_grpodlv_h_detail']);
    }
    $gr_quantity = $this->session->userdata('gr_quantity');

	for($i = 1; $i <= $count; $i++) :
		if($data['grpodlv_header']['status'] == '1' || ( ($data['grpodlv_header']['status'] == '2') && !empty($data['grpodlv_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if($function == 'input2' && count($_POST) == 0)
			$data['grpodlv_detail']['gr_quantity'][$i] = $grpodlv_detail['LFIMG'][$i];
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td><?php if(!isset($data['grpodlv_header']['status']) || $data['grpodlv_header']['status'] == '1') : ?>
        <?=form_hidden("grpodlv_detail[id_grpodlv_h_detail][$i]", $grpodlv_detail['id_grpodlv_h_detail'][$i]);?>
      <?=form_hidden("grpodlv_detail[id_grpodlv_detail][$i]", $data['grpodlv_detail']['id_grpodlv_detail'][$i]);?>
      <?=form_hidden("grpodlv_detail[item][$i]", $grpodlv_detail['POSNR'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
		<td><?php if($function=='edit'):?><?=$data['grpodlv_detail']['material_no'][$i];?><?php else: ?><?=$grpodlv_detail['MATNR'][$i];?><?php endif;?></td>
		<td><?php if($function=='edit'):?><?=$data['grpodlv_detail']['material_desc'][$i];?><?php else: ?><?=$grpodlv_detail['MAKTX'][$i];?><?php endif;?></td>
		<td align="center"><?php if($function=='edit'):?><?=$data['grpodlv_detail']['outstanding_qty'][$i];?><?php else: ?><?=$grpodlv_detail['LFIMG'][$i];?><?php endif;?></td>
        <td align="center"><?php
		if($data['grpodlv_header']['status'] != '2') {
			if(!empty($error) && in_array("grpodlv_detail[gr_quantity][$i]", $error)) {
				echo form_input("grpodlv_detail[gr_quantity][$i]", $data['grpodlv_detail']['gr_quantity'][$i], 'class="error_number" size="6"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grpodlv_detail[gr_quantity][$i]", $gr_quantity[$i], 'class="input_number" size="6"');
			} else {
          	echo form_input("grpodlv_detail[gr_quantity][$i]", $data['grpodlv_detail']['gr_quantity'][$i], 'class="input_number" size="6"');
            }
			}
		} else {
			echo $data['grpodlv_detail']['gr_quantity'][$i];
		}
		?></td>
		<td><?php
        if($function=='edit')
          $material_no = $data['grpodlv_detail']['material_no'][$i];
        else
          $material_no = $grpodlv_detail['MATNR'][$i];
		$item_x[$i] = $this->m_general->sap_item_select_by_item_code($material_no);
        if($function=='edit'):?><?=$item_x[$i]['UNIT'];?><?php else: ?><?=$item_x[$i]['UNIT'];?><?php endif;?></td>
    <?php if(($data['grpodlv_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
    <td align="center"><?php if($data['grpodlv_detail']['ok_cancel'][$i]==FALSE): ?>
        <?=form_checkbox('cancel['.$i.']', $grpodlv_detail['id_grpodlv_h_detail'][$i], FALSE);?>
      <?php else: ?>
      <?=$data['grpodlv_detail']['ok_cancel'][$i];?>
      <?php endif; ?></td>
    <?php endif; ?>
  </tr>
  <?php
	endfor;
?>
  <?php if(($data['grpodlv_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
  <tr>
    <td colspan="6">&nbsp;</td>
    <td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?>
        <?=form_hidden('count', $j);?></td>
  </tr>
  <?php endif; ?>
  <?php
//endif;
?>
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['grpodlv_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?>
        <?=anchor('grpodlv/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
<script language="javascript">
	function selectAll(){
//		t=document.form2.length;
//		document.write(t);
		//for(i=1; i<t-1; i++)
//		for(i=1; i <= <?=$j;?>; i++)
		for(i=1; i <= <?=$j;?>; i++)
			document.form1[i].checked=document.form1[<?=++$j;?>].checked;
	}
</script>