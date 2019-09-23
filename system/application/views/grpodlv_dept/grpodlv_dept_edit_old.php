<?php
$function = $this->uri->segment(2);
?>
<?php
	if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel')))
		$lebar=37+177+275+120+120+37+37+30;
	else
		$lebar=37+177+275+120+120+37+30;
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?php
if($function == 'edit') {
    echo form_hidden('grpodlv_dept_header[id_grpodlv_dept_header]', $this->uri->segment(3));
}
?>
<table width="<?php echo $lebar; ?>" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</td></tr>');
}
?>
	<tr>
    <td width="272" class="table_field_h">Data SAP per Tanggal/Jam</td>
    <td class="table_field_h"><?php echo $this->m_grpodlv_dept->posto_lastupdate(); ?> 
<?php /* <div style="color:#ffffff;font-style:italic;font-size:90%;">Jika data tidak lengkap, harap tunggu sinkronisasi berikutnya, yaitu 2 jam dari waktu di atas.</div> */ ?>    </td>
	</tr>
  <tr>
    <td class="table_field_1"><strong>Transfer Slip Number</strong></td>
  <td class="column_input"><strong><?=form_hidden('grpodlv_dept_header[do_no]', $grpodlv_dept_header['VBELN']);?><?=$grpodlv_dept_header['VBELN'];?></strong>
        <?php if($function == 'input2') echo ' '.anchor('grpodlv_dept/input', '<strong>Pilih ulang Transfer Slip Number dan Jenis Material</strong>');?></td>
  </tr>
	<tr>
		<td class="table_field_1"><strong>Goods Receipt Number  </strong></td>
		<td class="column_input"><strong><?=empty($data['grpodlv_dept_header']['grpodlv_dept_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['grpodlv_dept_header']['grpodlv_dept_no'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Date</strong></td>
		<td class="column_input"><?=form_hidden('grpodlv_dept_header[delivery_date]', $grpodlv_dept_header['delivery_date']);?>
        <strong><?php if(!empty($grpodlv_dept_header['delivery_date'])) : ?><?=$this->l_general->sqldate_to_date($grpodlv_dept_header['delivery_date']);?><?php endif; ?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet </strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['grpodlv_dept_header']['status_string'];?></strong></td>
	</tr>	
	<tr>
		<td class="table_field_1"><strong>Material Group <?php  $ha=$grpodlv_dept_header['VBELN'];
		?></strong> </td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_name'];?>
<?=form_hidden("grpodlv_dept_header[item_group_code]", $grpodlv_dept_header['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpodlv_dept_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if (!empty($data['grpodlv_dept_header']['posting_date'])) {
	    if (empty($error)) {
    		$posting_date = date("d-m-Y", strtotime($data['grpodlv_dept_header']['posting_date']));
        } else {
    		$posting_date = $data['grpodlv_dept_header']['posting_date'];
        }

    }

//	$posting_date = ($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['grpodlv_dept_header']['posting_date']));
?>
		<td class="column_input">
		<?php /* //disabled-20111011- requested by Bu Narti
		<?php if(($data['grpodlv_dept_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('grpodlv_dept_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'grpodlv_dept_header[posting_date]'
					});
		</script><?php else: ?>
		
		//end of disabled-20111011- requested by Bu Narti 
		*/
		?>
		<?=$posting_date;?><?=form_hidden("grpodlv_dept_header[posting_date]", $posting_date);?>
		<?php /*
		//disabled-20111011- requested by Bu Narti
		<?php endif;?>
		//end of disabled-20111011- requested by Bu Narti
		*/ ?>		</td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['grpodlv_dept_header']['status'] == '2') : ?>
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


<table width="<?php echo $lebar; ?>" border="0" bordercolor="#000000" align="center">
<thead>
  <tr bgcolor="#999999">
    <th width="37" class="table_header_1"><div align="center"><strong>No.</strong></div></th>
    <th width="177" class="table_header_1"><div align="center"><strong>Material No</strong></div></th>
    <th width="275" class="table_header_1"><div align="center"><strong>Material Desc</strong></div></th>
     <th width="177" class="table_header_1"><div align="center"><strong>Batch Number</strong></div></th>
    <th width="120" class="table_header_1"><div align="center"><strong>Outstanding Qty</strong></div></th>
    <th width="120" class="table_header_1"><div align="center"><strong>GR Qty</strong></div></th>
    <th width="37" class="table_header_1"><div align="center"><strong>Uom</strong></div></th>
    <?php if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
    <th class="table_header_1"><div align="center"><strong>Cancel</strong></div></th>
    <?php endif; ?>
    <th width="30" class="table_header_1_opname" >&nbsp;</th>
  </tr>
</thead>  
  <tr>
  <?php if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) { ?>
	<td colspan="8" style="padding:0px;text-align:left;margin:0px;" align="left">
	<?php } else { ?>
	<td colspan="7" style="padding:0px;text-align:left;margin:0px;" align="left">
	<?php } ?>
	<table class="filterable" border="0" width="100%" cellpadding="0" cellspacing="0" />
	<tr><td>
		<div style="height:350px;vertical-align:top;overflow:auto;background:none;margin-left:-2px;border-bottom:#376091 1px solid;">
		<table width="100%" border="0" align="center" id="t1" style="margin:0px;padding:0px;">
		  <tr bgcolor="#999999">
		    <td width="55"></td>
		    <td width="177"></td>
		    <td width="275"></td>
            <td width="177"></td>
		    <td width="110"></td>
		    <td width="120"></td>
		    <td width="37"></td>
		    <?php if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
    		<td width="37"></td>
    		<?php endif; ?>
		    <td></td>
		  </tr>
    
  <?php
//if($data['grpodlv_dept_details'] !== FALSE) :
//	$i = 1;
	$j = 0; // to count checkbox
    if(!empty($data['grpodlv_dept_detail']['id_grpodlv_dept_detail'])) {
   	  $count = count($data['grpodlv_dept_detail']['id_grpodlv_dept_detail']);
    } else {
   	  $count = count($grpodlv_dept_detail['id_grpodlv_dept_h_detail']);
    }
    $gr_quantity = $this->session->userdata('gr_quantity');

	for($i = 1; $i <= $count; $i++) :
		if($data['grpodlv_dept_header']['status'] == '1' || ( ($data['grpodlv_dept_header']['status'] == '2') && !empty($data['grpodlv_dept_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if($function == 'input2' && count($_POST) == 0)
			$data['grpodlv_dept_detail']['gr_quantity'][$i] = $grpodlv_dept_detail['LFIMG'][$i];
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
    <td><?php if(!isset($data['grpodlv_dept_header']['status']) || $data['grpodlv_dept_header']['status'] == '1') : ?>
        <?=form_hidden("grpodlv_dept_detail[id_grpodlv_dept_h_detail][$i]", $grpodlv_dept_detail['id_grpodlv_dept_h_detail'][$i]);?>
      <?=form_hidden("grpodlv_dept_detail[id_grpodlv_dept_detail][$i]", $data['grpodlv_dept_detail']['id_grpodlv_dept_detail'][$i]);?>
      <?php endif; ?>
      <?=$i;?></td>
        <?php
//		if($data['grpodlv_dept_header']['status'] == '2') {
//          $outstanding_qty = $data['grpodlv_dept_detail']['outstanding_qty'][$i];
//        } else {
//        }
        if($function=='edit') {
		  $item = $data['grpodlv_dept_detail']['item'][$i];
          $material_no = $data['grpodlv_dept_detail']['material_no'][$i];
          $material_desc = $data['grpodlv_dept_detail']['material_desc'][$i];
          $uom = $data['grpodlv_dept_detail']['uom'][$i];
		  $outstanding_qty =  $data['grpodlv_dept_detail']['outstanding_qty'][$i];
         /* $count_h = count($grpodlv_dept_detail['POSNR']);
          for ($h=1;$h<=$count_h;$h++) {
            if ($data['grpodlv_dept_detail']['item'][$i]==$grpodlv_dept_detail['POSNR'][$h]) {
              $outstanding_qty = $grpodlv_dept_detail['LFIMG'][$h];
              break;
            }
          }*/
		  $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
		$b=mssql_select_db('TEST_2',$c);
		$to="SELECT OBTN.DistNumber FROM OITL
			JOIN ITL1 ON OITL.LogEntry = ITL1.LogEntry
			JOIN OBTN ON ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber
			where DocEntry = '$ha' and DocType =67 AND OITL.StockQty >0 AND OITL.DocLine = '$item'";
		$t=mssql_query($to);
		$rw=mssql_fetch_row($t);
		$grpodlv_dept_detail['material_docno_cancellation'][$i]=$rw[0];
        } else {
		  $item = $grpodlv_dept_detail['POSNR'][$i];
		  $material_no = $grpodlv_dept_detail['MATNR'][$i];
          $material_desc = $grpodlv_dept_detail['MAKTX'][$i];
          $uom = $grpodlv_dept_detail['VRKME'][$i];
          $outstanding_qty = $grpodlv_dept_detail['LFIMG'][$i];
		  $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
		$b=mssql_select_db('TEST_2',$c);
		$to="SELECT OBTN.DistNumber FROM OITL
			JOIN ITL1 ON OITL.LogEntry = ITL1.LogEntry
			JOIN OBTN ON ITL1.ItemCode = OBTN.ItemCode and ITL1.SysNumber = OBTN.SysNumber
			where DocEntry = '$ha' and DocType =67 AND OITL.StockQty >0 AND OITL.DocLine = '$item'";
		$t=mssql_query($to);
		$rw=mssql_fetch_row($t);
		$grpodlv_dept_detail['material_docno_cancellation'][$i]=$rw[0];
        }
        ?>
		<td><?=$this->l_general->remove_0_digit_in_item_code($material_no);?>
        <?=form_hidden("grpodlv_dept_detail[item][$i]", $item);?>
        <?=form_hidden("grpodlv_dept_detail[material_no][$i]",$material_no);?></td>
		<td><?=$material_desc;?><?=form_hidden("grpodlv_dept_detail[material_desc][$i]", $material_desc);?></td>
        <td><?=$grpodlv_dept_detail['material_docno_cancellation'][$i];?><?=form_hidden("grpodlv_dept_detail[material_docno_cancellation][$i]", $grpodlv_dept_detail['material_docno_cancellation'][$i]);?></td>
        <?php
		if ($function=='edit' && $data['grpodlv_dept_header']['status'] != '2')
		{?>
			<td align="right"><?=number_format($outstanding_qty, 3, '.', ',');?><?=form_hidden("grpodlv_dept_detail[outstanding_qty][$i]",$outstanding_qty);?></td>
		<?php }
		else
		{ ?>
			<td align="right"><?=number_format($outstanding_qty, 3, '.', ',');?><?=form_hidden("grpodlv_dept_detail[outstanding_qty][$i]",$outstanding_qty);?></td>
		<?php }
		?>
		
        <td align="center"><?php
		if($data['grpodlv_dept_header']['status'] != '2') {
			if(!empty($error) && in_array("grpodlv_dept_detail[gr_quantity][$i]", $error)) {
				echo form_input("grpodlv_dept_detail[gr_quantity][$i]", number_format($data['grpodlv_dept_detail']['gr_quantity'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
			if(!empty($gr_quantity)) {
          	echo form_input("grpodlv_dept_detail[gr_quantity][$i]", number_format($gr_quantity[$i], 3, '.', ''), 'class="input_number" size="8"');
			} else {
          	echo form_input("grpodlv_dept_detail[gr_quantity][$i]", number_format($data['grpodlv_dept_detail']['gr_quantity'][$i], 3, '.', ''), 'class="input_number" size="8"');
            }
			}
		} else {
			echo number_format($data['grpodlv_dept_detail']['gr_quantity'][$i], 3, '.', ',');
		}
		?></td>
		<td><?=$uom;?></td>
    <?php if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center"><?php if($data['grpodlv_dept_detail']['ok_cancel'][$i]==FALSE): ?>
        <?=form_checkbox('cancel['.$i.']', $data['grpodlv_dept_detail']['id_grpodlv_dept_h_detail'][$i], FALSE);?>
      <?php else: ?>
      <?=$data['grpodlv_dept_detail']['ok_cancel'][$i];?>
      <?php endif; ?></td>
    <?php endif; ?>
  </tr>
  <?php
	endfor;
?>
  <?php if(($data['grpodlv_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
</div>
</td></tr></table>
<script src="<?=base_url();?>js/filterTable.js?88" type="text/javascript"></script>
</td></tr>
</table>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Receipt PO STO with Delivery.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a>        </td>
  </tr>
	<tr>
    <td align="center"><?=anchor('grpodlv_dept/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?=form_close();?>
<div style="clear:both;">&nbsp;</div>