<?php
$function = $this->uri->segment(2);
$db_mysql=$this->m_database->get_db_mysql();
$user_mysql=$this->m_database->get_user_mysql();
$pass_mysql=$this->m_database->get_pass_mysql();
$db_sap=$this->m_database->get_db_sap();
$user_sap=$this->m_database->get_user_sap();
$pass_sap=$this->m_database->get_pass_sap();
$host_sap=$this->m_database->get_host_sap();

$mysqlcon = mysql_connect("localhost",$user_mysql,$pass_mysql);
mysql_select_db($db_mysql,$mysqlcon);
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('grsto_header[id_grsto_header]', $this->uri->segment(3));
}
$plant=$this->session->userdata['ADMIN']['plant'];
?>
<table width="1038" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	
	<tr>
		<td class="table_field_1"><strong>ID Transaksi  </strong></td>
		<td class="column_input"><?=form_hidden('grsto_header[id_grsto_header]', $grsto_header['id_grsto_header']);?><strong><?=$grsto_header['id_grsto_header'];?></strong></td>
	</tr>
  <tr>
    <td width="272" class="table_field_1"><strong>SR Number </strong></td>
		<td class="column_input"><strong><?=form_hidden('grsto_header[po_no]', $grsto_header['EBELN']);?><?=$grsto_header['EBELN'];?></strong>
        <?php if($function == 'input2') echo ' '.anchor('grsto/input', '<strong>Pilih ulang Transfer Slip Number dan Jenis Material</strong>');?></td>
  </tr>
	<tr>
		<td class ="table_field_1"><strong>Transfer Out No</strong></td>
	  <td class="column_input"><strong><?=$grsto_header['MBLNR'];?></strong>
        <?=form_hidden("grsto_header[no_doc_gist]", $grsto_header['MBLNR']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Transfer In  Number </strong></td>
		<td class="column_input"><?=empty($data['grsto_header']['grsto_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grsto_header']['grsto_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet From</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Transit Location </strong></td>
	  <td class="column_input"><?php
	  $plant1=$this->session->userdata['ADMIN']['plant'];
	  $cePL=mysql_fetch_array(mysql_query("SELECT TRANSIT,OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$plant1' ", $mysqlcon));
	  $cePK=mysql_fetch_array(mysql_query("SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$cePL[TRANSIT]' ", $mysqlcon));
	 // echo $cePL['TRANSIT'].' - Transit '.$cePL['OUTLET_NAME1'];
	// echo "SELECT OUTLET_NAME1 FROM m_outlet WHERE OUTLET='$cePL[TRANSIT]'  ";
	  ?></td>
	</tr>
	<tr>
		<td class ="table_field_1"><strong>Transfer to Outlet</strong> </td>
	  <td class ="column_input"><strong><?=$grsto_header['SUPPL_PLANT'];?><?=" - ";?><?=$grsto_header['SPLANT_NAME'];?></strong>
        <?=form_hidden("grsto_header[delivery_plant]", $grsto_header['SUPPL_PLANT']);?>
        <?=form_hidden("grsto_header[delivery_plant_name]", $grsto_header['SPLANT_NAME']);?>        </td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><?=form_hidden('grsto_header[delivery_date]', $grsto_header['delivery_date']);?>
        <strong><?php if(!empty($grsto_header['delivery_date'])) : ?><?=$this->l_general->sqldate_to_date($grsto_header['delivery_date']);?><?php endif; ?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grsto_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
<?=form_hidden("grsto_header[item_group_code]", $grsto_header['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grsto_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['grsto_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['grsto_header']['posting_date']));
        } else {
    		$posting_date = $data['grsto_header']['posting_date'];
        }
    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grsto_header']['posting_date']));
?>
		<td class="column_input"><?php if(($data['grsto_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grsto_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grsto_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("grsto_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['grsto_header']['status'] == '2') : ?>
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
<table width="1038" border="0" bordercolor="#000000" align="center">
  <tr bgcolor="#999999">
    <td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
    <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
    <td class="table_header_1"><div align="center"><strong>Goods Issue Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Actual GR. Qty</strong></div></td>
    <td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
    <?php if(($data['grsto_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
    <td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td>
    <?php endif; ?>
     <th width="30" class="table_header_1" ><div align="center"><strong>Val</strong></div></th>
    <th width="30" class="table_header_1" ><div align="center"><strong>Variance</strong></div></th>
  </tr>
  <?php
//if($data['grsto_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['grsto_detail']['id_grsto_detail'])) {
   	  $count = count($data['grsto_detail']['id_grsto_detail']);
    } else {
   	  $count = count($grsto_detail['id_grsto_h_detail']);
    }
    $gr_quantity = $this->session->userdata('gr_quantity');

	for($i = 1; $i <= $count; $i++) :
		if($data['grsto_header']['status'] == '1' || ( ($data['grsto_header']['status'] == '2') && !empty($data['grsto_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if($function == 'input2' && count($_POST) == 0)
			$data['grsto_detail']['gr_quantity'][$i] = $grsto_detail['BSTMG'][$i];
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td><?php if(!isset($data['grsto_header']['status']) || $data['grsto_header']['status'] == '1') : ?>
        <?=form_hidden("grsto_detail[id_grsto_h_detail][$i]", $grsto_detail['id_grsto_h_detail'][$i]);?>
      <?=form_hidden("grsto_detail[id_grsto_detail][$i]", $data['grsto_detail']['id_grsto_detail'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
        <?php
        if($function=='edit') {
		$id=$grsto_header['MBLNR'];
          $item = $data['grsto_detail']['item'][$i];
          $material_no = $data['grsto_detail']['material_no'][$i];
          $material_desc = $data['grsto_detail']['material_desc'][$i];
          $uom = $data['grsto_detail']['uom'][$i];
          $count_h = count($grsto_detail['EBELP']);
          //$outstanding_qty = 0;
		  $outstanding_qty = $data['grsto_detail']['outstanding_qty'][$i];
		$ta=mysql_query("SELECT id_gistonew_out_header FROM t_gistonew_out_header WHERE po_no = '$id'", $mysqlcon);
		$ra=mysql_fetch_array($ta);
		$gisto=$ra['id_gistonew_out_header'];
		$t=mysql_query("SELECT * FROM t_batch WHERE BaseEntry = '$gisto' AND ItemCode = '$material_no' AND BaseLinNum = '$item' ", $mysqlcon);
		//echo "SELECT * FROM t_batch WHERE BaseEntry = '$gisto' AND ItemCode = '$material_no' AND BaseLinNum = '$item' ";
		/*while($r=mysql_fetch_array($t))
		{
			$bacth[$r['DistNumber']] = $r['DistNumber'];
		}*/
		$r=mysql_fetch_array($t);
		$BatchNum = $r['BatchNum'];
         /* for ($h=1;$h<=$count_h;$h++) {
            if ($data['grsto_detail']['item'][$i]==$grsto_detail['EBELP'][$h]) {
              $outstanding_qty = $grsto_detail['BSTMG'][$h];
			  //echo $data['grsto_detail']['item'][$i]==$grsto_detail['EBELP'][$h];
              break;
            }
          }*/
		//echo $ta;
        } else {
		$id=$grsto_header['EBELN'];
		  $item = $grsto_detail['EBELP'][$i];
          $material_no = $grsto_detail['MATNR'][$i];
          $material_desc = $grsto_detail['MAKTX'][$i];
          $uom = $grsto_detail['BSTME'][$i];
          $outstanding_qty = $grsto_detail['BSTMG'][$i];
		  $number=$grsto_detail['NUMBER'][$i];
		$ta=mysql_query("SELECT id_gistonew_out_header FROM t_gistonew_out_header WHERE po_no = '$id'", $mysqlcon);
		$ra=mysql_fetch_array($ta);
		$gisto=$ra['id_gistonew_out_header'];
		$t=mysql_query("SELECT * FROM t_batch WHERE BaseEntry = '$gisto' AND ItemCode = '$material_no' AND BaseLinNum = '$item' ", $mysqlcon);
		//echo "SELECT * FROM t_batch WHERE BaseEntry = '$gisto' AND ItemCode = '$material_no' AND BaseLinNum = '$item' ";
		/*while($r=mysql_fetch_array($t))
		{
			$bacth[$r['DistNumber']] = $r['DistNumber'];
		}*/
		$r=mysql_fetch_array($t);
		
		$BatchNum = $r['BatchNum'];
		
		}
        ?>
		<td><?=$this->l_general->remove_0_digit_in_item_code($material_no);?>
        <?=form_hidden("grsto_detail[item][$i]", $number);?>
        <?=form_hidden("grsto_detail[item1][$i]", $item);?>
        <?=form_hidden("grsto_detail[material_no][$i]",$material_no);?></td>
		<td><?=$material_desc;?><?=form_hidden("grsto_detail[material_desc][$i]", $material_desc);?></td>
       <?php
       /*if ($function !='edit')
	   {
	   ?>
        <!--td><?=$BatchNum;?><?=form_hidden("grsto_detail[material_docno_cancellation][$i]", $BatchNum);?></td>
        <?php
        }else
		{
		?>
        <td><?=$data['grsto_detail']['material_docno_cancellation'][$i];?><?=form_hidden("grsto_detail[material_docno_cancellation][$i]", $data['grsto_detail']['material_docno_cancellation'][$i]);?></td-->
        <?php } */?>
		<td align="center"><?=number_format($outstanding_qty, 2, '.', ',');?><?=form_hidden("grsto_detail[outstanding_qty][$i]",$outstanding_qty);?></td>
        <td align="center"><?php
		if($data['grsto_header']['status'] != '2') {
			if(!empty($error) && in_array("grsto_detail[gr_quantity][$i]", $error)) {
				echo form_input("grsto_detail[gr_quantity][$i]", number_format($data['grsto_detail']['gr_quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grsto_detail[gr_quantity][$i]", number_format($gr_quantity[$i], 2, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grsto_detail[gr_quantity][$i]", number_format($data['grsto_detail']['gr_quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
            }
			}
		} else {
			echo number_format($data['grsto_detail']['gr_quantity'][$i], 2, '.', ',');
		}
		?></td>
		<td><?=$uom;?><?=form_hidden("grsto_detail[uom][$i]", $uom);?></td>
         <td><?php
		$val = array(
        '0' => 'Variance',
        '1' => 'Move',
        '2'  => 'Lost'
);
        if(!empty($error) && in_array("grsto_detail[val][$i]", $error)) {
			echo form_dropdown("grsto_detail[val][$i]", $val, $data['grsto_detail']['val'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:50px;" ');
		} else {
			echo form_dropdown("grsto_detail[val][$i]", $val, $data['grsto_detail']['val'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:50px;" ');
		}
		?></td>
        <td><?php
		if($data['grsto_header']['status'] != '2') {
			if(!empty($error) && in_array("grsto_detail[var][$i]", $error)) {
				echo form_input("grsto_detail[var][$i]", number_format($data['grsto_detail']['var'][$i], 2, '.', ''), 'class="error_number" size="4"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grsto_detail[var][$i]", number_format($var[$i], 2, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grsto_detail[var][$i]", number_format($data['grsto_detail']['var'][$i], 2, '.', ''), 'class="input_number" size="4"');
            }
			}
		} else {
			echo number_format($data['grsto_detail']['gr_quantity'][$i], 2, '.', ',');
		}
		?> </td>
    <?php if(($data['grsto_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
    <td align="center"><?php if($data['grsto_detail']['ok_cancel'][$i]==FALSE): ?>
        <?=form_checkbox('cancel['.$i.']', $data['grsto_detail']['id_grsto_h_detail'][$i], FALSE);?>
      <?php else: ?>
      <?=$data['grsto_detail']['ok_cancel'][$i];?>
      <?php endif; ?></td>
    <?php endif; ?>
  </tr>
  <?php
	endfor;
?>
  <?php if(($data['grsto_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
  <?php
	mysql_close($mysqlcon);
  endif; ?>
  <?php
//endif;
?>
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Good Receipt  Stock Transfer antar Plant.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
  <tr>
    <td align="center"><?=anchor('grsto/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
  </tr>
	</tr>
</table>
<?=form_close();?>
