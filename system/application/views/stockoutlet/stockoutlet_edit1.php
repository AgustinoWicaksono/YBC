<?php
$function = $this->uri->segment(2);
$this->load->helper('form');
$this->load->library('l_pagination');
?>


<script language="javascript">
function changeVal(obj, number) {
	var x = 'stockoutlet_detail[qty_gso]['+number+']';
	var y = 'stockoutlet_detail[qty_gss]['+number+']';
	var z = 'stockoutlet_detail[quantity]['+number+']';
	var num = 0;
	var result = 0;

	if(obj.form.elements[x].value == '') {
		obj.form.elements[x].value = 0;
	} else if(obj.form.elements[y].value == '') {
		obj.form.elements[y].value = 0;
	}
    num = parseFloat(obj.form.elements[x].value) + parseFloat(obj.form.elements[y].value);
	result = num.toFixed(2);
	obj.form.elements[z].value = result;
}
</script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('stockoutlet_header[id_stockoutlet_header]', $this->uri->segment(3));
}
?>
<table width="930" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Material Document No. </strong></td>
		<td class="column_input"><?=($function == 'input2') ? '<em>(Auto Number after Posting to SAP)</em>' : $data['stockoutlet_header']['stockoutlet_no'];?></td>
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
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['stockoutlet_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
    	<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
            <?=form_hidden("stockoutlet_header[item_group_code]", $stockoutlet_header['item_group_code']);?>
            <?php if(!empty($stockoutlet_header['item_group_code'])&&($function!=='edit')) : echo anchor('stockoutlet/input','<strong>Pilih ulang Material Group</strong>'); endif;?>
        </td>

	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['stockoutlet_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
  		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['stockoutlet_header']['posting_date'])) {
		$posting_date = date("d-m-Y", strtotime($data['stockoutlet_header']['posting_date']));
    }
?>
		<td class="column_input">
            <?php
            if($function!=='edit') : ?>
            <?php
            if(($data['stockoutlet_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
            <?=form_input('stockoutlet_header[posting_date]', $posting_date, 'class="input_text" size="10"');?>
                <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'stockoutlet_header[posting_date]'
					});
		        </script><?php else: ?><?=$posting_date;?><?=form_hidden("stockoutlet_header[posting_date]", $posting_date);?><?php endif;?>
            <?php else: ?><?=$posting_date;?><?=form_hidden("stockoutlet_header[posting_date]", $posting_date);?><?php endif;?>
        </td>
	</tr>
</table>

<div class="div_freezepanes_wrapper"  >


<table width="930" border="0" bordercolor="#000000" align="center" id="t1header">
  <tr bgcolor="#999999">
    <td width="45" class="table_header_1_opname"><div align="center"><strong>No.</strong></div></td>
    <td width="177" class="table_header_1_opname"><div align="center"><strong>Material No</strong></div></td>
    <td width="275" class="table_header_1_opname"><div align="center"><strong>Material Desc</strong></div></td>
    <td width="120" class="table_header_1_opname"><div align="center"><strong>Qty Warehouse <br> Stock Outlet</strong></div></td>
    <td width="120" class="table_header_1_opname"><div align="center"><strong>Qty Warehouse <br> Stock Support</strong></div></td>
    <td width="100" class="table_header_1_opname"><div align="center"><strong>Quantity</strong></div></td>
    <td width="70" class="table_header_1_opname"><div align="center"><strong>Uom</strong></div></td>
    <td width="30" class="table_header_1_opname" >&nbsp;</td>
  </tr>
  <tr>
	<td colspan="8" style="padding:0px;text-align:left;margin:0px;" align="left">

<div style="height:350px;width:920px;vertical-align:top;overflow:auto;background:none;margin-left:-2px;">
<table width="900" border="0" bordercolor="#000000" align="center" id="t1" style="margin:0px;padding:0px;">
  <tr bgcolor="#999999">
    <td width="45"></td>
    <td width="170"></td>
    <td width="275"></td>
    <td width="120"></td>
    <td width="120"></td>
    <td width="100"></td>
    <td width="70"></td>
  </tr>
<?php
//if($data['stockoutlet_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['stockoutlet_detail']['id_stockoutlet_detail'])) {
   	  $count = count($data['stockoutlet_detail']['id_stockoutlet_detail']);
    } else {
   	  $count = count($stockoutlet_detail['id_stockoutlet_h_detail']);
    }
    $qty_gso = $this->session->userdata('qty_gso');
    $qty_gss = $this->session->userdata('qty_gss');
    $quantity = $this->session->userdata('quantity');

    $item_qty = $this->m_stockoutlet->stockoutlet_detail_select_qty_by_date_and_material_no($posting_date);
	for($i = 1; $i <= $count; $i++) :
		if($data['stockoutlet_header']['status'] == '1' || ( ($data['stockoutlet_header']['status'] == '2') && !empty($data['stockoutlet_detail']['gr_quantity'][$i]) )) {
			$j++;
		}
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td align="center"><?php if(!isset($data['stockoutlet_header']['status']) || $data['stockoutlet_header']['status'] == '1') : ?>
        <?=form_hidden("stockoutlet_detail[id_stockoutlet_h_detail][$i]", $stockoutlet_detail['id_stockoutlet_h_detail'][$i]);?>
        <?=form_hidden("stockoutlet_detail[id_stockoutlet_detail][$i]", $data['stockoutlet_detail']['id_stockoutlet_detail'][$i]);?>
        <?=form_hidden("stockoutlet_detail[MATNR][$i]", $stockoutlet_detail['MATNR'][$i]);?>
        <?=form_hidden("stockoutlet_detail[MAKTX][$i]", $stockoutlet_detail['MAKTX'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
    <td><?=$stockoutlet_detail['MATNR'][$i];?></td>
    <td><?=$stockoutlet_detail['MAKTX'][$i];?></td>
    <td align="center"><?php
		if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($qty_gso)) {
                $qtygso = $qty_gso[$i];
			} else {
                $qtygso = $data['stockoutlet_detail']['qty_gso'][$i];
            }
            if ($function == 'input2') {
              $qtygso = $item_qty['qty_gso'][$stockoutlet_detail['MATNR'][$i]];
            }
?><?=form_input("stockoutlet_detail[qty_gso][$i]", $qtygso, 'onChange="changeVal(this, '.$i.')" class="input_number" size="4"');?>
<!--   <a href="javascript:TCR.TCRPopup(document.forms['form1'].elements['stockoutlet_detail[qty_gso][<?=$i;?>]'],
                                    document.forms['form1'].elements['stockoutlet_detail[qty_gss][<?=$i;?>]'],
                                    document.forms['form1'].elements['stockoutlet_detail[quantity][<?=$i;?>]'])">
   <img width="15" height="13" border="0" alt="Kalkulator" src="<?=base_url();?>js/calculator/calc.gif"></a>
-->
    <?php
		} else {
			echo $data['stockoutlet_detail']['qty_gso'][$i];
		}
		?></td>
    <td align="center"><?php
		if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($qty_gss)) {
                $qtygss = $qty_gss[$i];
			} else {
                $qtygss = $data['stockoutlet_detail']['qty_gss'][$i];
            }
            if ($function == 'input2') {
              $qtygss = $item_qty['qtygss'][$stockoutlet_detail['MATNR'][$i]];
            }
?> <?=form_input("stockoutlet_detail[qty_gss][$i]", $qtygss, 'onChange="changeVal(this, '.$i.')" class="input_number" size="4"');?>
<!--   <a href="javascript:TCR.TCRPopup(document.forms['form1'].elements['stockoutlet_detail[qty_gss][<?=$i;?>]'],
                                    document.forms['form1'].elements['stockoutlet_detail[qty_gso][<?=$i;?>]'],
                                    document.forms['form1'].elements['stockoutlet_detail[quantity][<?=$i;?>]'])">
    <img width="15" height="13" border="0" alt="Kalkulator" src="<?=base_url();?>js/calculator/calc.gif"></a>
-->
<?php
		} else {
			echo $data['stockoutlet_detail']['qty_gss'][$i];
		}
		?></td>
    <td align="center"><?php
		if($data['stockoutlet_header']['status'] != '2') {
			if(!empty($quantity)) {
                $qty = $quantity[$i];
			} else {
                $qty = $data['stockoutlet_detail']['quantity'][$i];
            }
            if ($function == 'input2') {
              $qty = $item_qty['quantity'][$stockoutlet_detail['MATNR'][$i]];
            }
          	echo form_input("stockoutlet_detail[quantity][$i]", $qty, 'class="input_number" size="6" disabled="disabled" ');
		} else {
			echo $data['stockoutlet_detail']['quantity'][$i];
		}
		?></td>
    <td><?php
		$item_x[$i] = $this->m_general->sap_item_select_by_item_code($stockoutlet_detail['MATNR'][$i]);
        if (!empty($data['stockoutlet_detail']['uom'][$i])) {
          $item_x[$i]['UNIT'] = $data['stockoutlet_detail']['uom'][$i];
        }
        ?>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['stockoutlet_header']['status'] != '2')):
           if($function == 'input2') { $item_x[$i]['UNIT'] = 'G'; } ?>
            <?=form_dropdown("stockoutlet_detail[uom][$i]", $this->config->item('uom_kg'), $item_x[$i]['UNIT']);?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['stockoutlet_header']['status'] != '2')):
           if($function == 'input2') { $item_x[$i]['UNIT'] = 'ML'; } ?>
            <?=form_dropdown("stockoutlet_detail[uom][$k]", $this->config->item('uom_l'), $item_x[$i]['UNIT']);?>
        <?php else :?>
            <?=$item_x[$i]['UNIT'];?>
            <?=form_hidden("stockoutlet_detail[uom][$i]", $item_x[$i]['UNIT']);?>
        <?php endif; ?>
        </td>
  </tr>
  <?php
	endfor;
?>
</table>
</td></tr>
</table>
</div>


<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
<?php if($data['stockoutlet_header']['status'] != '2') : ?>
		<td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        </td>
<?php endif; ?>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('stockoutlet/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
