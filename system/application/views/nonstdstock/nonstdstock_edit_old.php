<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print '$request_reasons ';
//print_r($data['nonstdstock_detail']);
//echo "</pre>";
?>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('nonstdstock_header[id_nonstdstock_header]', $this->uri->segment(3));?>


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
		<td width="272" class="table_field_1"><strong>Purchase Requesition Number </strong></td>
		<td class="column_input">
        <?=empty($data['nonstdstock_header']['pr_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['nonstdstock_header']['pr_no'];?>
        <?=form_hidden("nonstdstock_header[pr_no]", $data['nonstdstock_header']['pr_no']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Outlet From</strong></td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['plant'].' - '.$this->session->userdata['ADMIN']['plant_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Storage Location </strong> </td>
		<td class="column_input"><?=$this->session->userdata['ADMIN']['storage_location'].' - '.$this->session->userdata['ADMIN']['storage_location_name'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Request Reason</strong> </td>
		<td class ="column_input"><?=$request_reason;?>
        <?=form_hidden('nonstdstock_header[request_reason]', $request_reason);?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=$data['nonstdstock_header']['status_string'];?></strong>
        <?=form_hidden("nonstdstock_header[status]", $data['nonstdstock_header']['status']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("nonstdstock_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Created Date</strong></td>
<?php
/*	if(empty($_POST) && $function == 'input2')
		$created_date = date("d-m-Y");
	else if(!empty($data['nonstdstock_header']['created_date']))
        if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0))
    		$created_date = $data['nonstdstock_header']['created_date'];
        else
         if($function == 'edit')
    		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['nonstdstock_header']['created_date'])));
         else
    		$created_date = $data['nonstdstock_header']['created_date'];
*/
   if($data['nonstdstock_header']['status'] != '2') {
    	if(empty($_POST) && $function == 'input2')
//    		$created_date = date("d-m-Y");
    		$created_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
    	else if(!empty($data['nonstdstock_header']['created_date']))
            if ((isset($_POST['button']['add']))||(count($_POST['delete'])>0)||(!empty($error)))
        		$created_date = $data['nonstdstock_header']['created_date'];
            else
        		$created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['nonstdstock_header']['created_date'])));
   } else {
     $created_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['nonstdstock_header']['created_date'])));;
   }
?>
		<td class="column_input">
         <?php if(($data['nonstdstock_header']['status'] != '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('nonstdstock_header[created_date]', $created_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'nonstdstock_header[created_date]'
					});
		</script><?php else : ?>
    <?=$created_date;?><?=form_hidden("nonstdstock_header[created_date]", $created_date);?>
    <?php endif;?></td>
	</tr>
</table>

<table width="1038" border="0" align="center" id="t1">
	<tr bgcolor="#999999">
<?php if(empty($data['nonstdstock_header']['status']) || $data['nonstdstock_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Lead Time (hari)</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Requirement Qty</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Price / Item</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Delivery Date</strong></div></td>
		<?php if(($data['nonstdstock_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))) : ?><td class="table_header_1"><div align="center"><strong>Delete</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['nonstdstock_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $nonstdstock_detail_tmp = $this->session->userdata('nonstdstock_detail');
    if(!empty($nonstdstock_detail_tmp)) {
       $data['nonstdstock_detail'] = $nonstdstock_detail_tmp;
    }

	$count = count($data['nonstdstock_detail']['id_nonstdstock_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($nonstdstock_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($nonstdstock_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['nonstdstock_header']['status'] == '1' || ( ($data['nonstdstock_header']['status'] == '2') && !empty($data['nonstdstock_detail']['requirement_qty'][$i]) && !empty($data['nonstdstock_detail']['price'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {
			if($k == $count && !empty($error) && ( in_array("nonstdstock_detail[requirement_qty][$i]", $error) || in_array("nonstdstock_detail[material_no][$i]", $error) || in_array("nonstdstock_detail[delivery_date][$i]", $error) || in_array("nonstdstock_detail[price][$i]", $error) ) )
				break;
			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['nonstdstock_detail']['material_no'][$i]);
            if (!empty($data['nonstdstock_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['nonstdstock_detail']['material_desc'][$i];
              $item_x[$i]['UNIT'] = $data['nonstdstock_detail']['uom'][$i];
            }
            $item_lead_time[$i] = $this->m_nonstdstock->sap_item_lead_time_select($data['nonstdstock_detail']['material_no'][$i]);
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(empty($data['nonstdstock_header']['status']) || $data['nonstdstock_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['nonstdstock_header']['status']) || $data['nonstdstock_header']['status'] !== '0') : ?>
        <?=form_hidden("nonstdstock_detail[id_nonstdstock_h_detail][$k]", $data['nonstdstock_detail']['id_nonstdstock_h_detail'][$k]);?>
        <?=form_hidden("nonstdstock_detail[id_nonstdstock_detail][$k]", $data['nonstdstock_detail']['id_nonstdstock_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("nonstdstock_detail[material_no][$k]", $data['nonstdstock_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?></td>
<?php
  if (!empty($data['nonstdstock_detail']['lead_time'][$i]))
     $lead_time = $data['nonstdstock_detail']['lead_time'][$i];
  else
     $lead_time = $item_lead_time[$i]['LEAD_TIME'];
?>
		<td align="center"><?=form_hidden("nonstdstock_detail[lead_time][$k]", $lead_time);?><?=$lead_time;?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("nonstdstock_detail[requirement_qty][$i]", $error)) {
				echo form_input("nonstdstock_detail[requirement_qty][$k]", number_format($data['nonstdstock_detail']['requirement_qty'][$i], 3, '.', ''), 'class="error_number" size="8"');
			} else {
                if($data['nonstdstock_header']['status'] == '2') {
    				echo form_hidden("nonstdstock_detail[requirement_qty_old][$k]", $data['nonstdstock_detail']['requirement_qty'][$i]);
                }
    			echo form_input("nonstdstock_detail[requirement_qty][$k]", number_format($data['nonstdstock_detail']['requirement_qty'][$i], 3, '.', ''), 'class="input_number" size="8"');
			}
?></td>
<td align="center">
 <?php
			if(!empty($error) && in_array("nonstdstock_detail[price][$i]", $error)) {
				echo form_input("nonstdstock_detail[price][$k]", number_format($data['nonstdstock_detail']['price'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
                if($data['nonstdstock_header']['status'] == '2') {
    				echo form_hidden("nonstdstock_detail[price_old][$k]", $data['nonstdstock_detail']['price'][$i]);
                }
    			echo form_input("nonstdstock_detail[price][$k]", number_format($data['nonstdstock_detail']['price'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td> 
		<td>
        <?php
		$it=$data['nonstdstock_detail']['material_no'][$i];
		$ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'");
	   $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$it' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$it' 
group by m_uom.UomName 

");
		$count1=mysql_num_rows($tq);
		$ri=mysql_fetch_array($ti);
		
		while($r=mysql_fetch_array($tq))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("nonstdstock_detail[uom][$i]", $error)) {
			echo form_dropdown("nonstdstock_detail[uom][$k]", $itemC, $data['nonstdstock_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="error_text" style="width:60px;" ');
		} else {
		echo form_dropdown("nonstdstock_detail[uom][$k]", $itemC  , $data['nonstdstock_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="input_text" style="width:60px;"  ');  
		}
		}
	   ?>
        </td>
<?php
    if(empty($_POST['delete'])) {
      if (isset($_POST['button']['add'])) {
        $delivery_date = $this->l_general->str_to_date($created_date);
        $oneday = 60 * 60 * 24;
        $delivery_date = date("d-m-Y",strtotime($delivery_date) + ($lead_time * $oneday));
      } else {
        if (($function == 'edit')&&(empty($error)))
            $delivery_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['nonstdstock_detail']['delivery_date'][$i])));
        else
            $delivery_date = $data['nonstdstock_detail']['delivery_date'][$i];
      }
    } else
        $delivery_date = $data['nonstdstock_detail']['delivery_date'][$i];

?>
		<td align="center"><?php if($data['nonstdstock_header']['status'] == '2'): ?>
            <?=$delivery_date;?>
         <?php else: ?>
            <?php if(!empty($error) && in_array("nonstdstock_detail[delivery_date][$i]", $error)):?>
                <?=form_input("nonstdstock_detail[delivery_date][$k]", $delivery_date, 'class="error_text" size="10"');?>
            <?php else: ?>
                <?=form_input("nonstdstock_detail[delivery_date][$k]", $delivery_date, 'class="input_text" size="10"');?>
            <?php endif?>
            <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'nonstdstock_detail[delivery_date][<?=$k;?>]'
					});
		</script>
        <?php endif?>
        </td>
		<?php if(($data['nonstdstock_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_change'))): ?>
        <td align="center">
        <?php if($data['nonstdstock_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['nonstdstock_detail']['id_nonstdstock_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['nonstdstock_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
        $k++;
        }
    }
 if($data['nonstdstock_header']['status'] != '2') :
    ?>
	<tr>
<?php if(empty($data['nonstdstock_header']['status']) || $data['nonstdstock_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['nonstdstock_header']['status']) || $data['nonstdstock_header']['status'] !== '0') : ?><?=form_hidden("nonstdstock_detail[id_nonstdstock_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		if(!empty($error) && in_array("nonstdstock_detail[material_no][$i]", $error)) {
			echo form_dropdown("nonstdstock_detail[material_no][$k]", $item, $data['nonstdstock_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" ');
		} else {
			echo form_dropdown("nonstdstock_detail[material_no][$k]", $item, $data['nonstdstock_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" ');
		}
		?>
		</td>
		<td>&nbsp;</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("nonstdstock_detail[requirement_qty][$i]", $error)) {
			echo form_input("nonstdstock_detail[requirement_qty][$k]", $data['nonstdstock_detail']['requirement_qty'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("nonstdstock_detail[requirement_qty][$k]", $data['nonstdstock_detail']['requirement_qty'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
        <td align="center">
		<?php
		if(!empty($error) && in_array("nonstdstock_detail[price][$i]", $error)) {
			echo form_input("nonstdstock_detail[price][$k]", $data['nonstdstock_detail']['price'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("nonstdstock_detail[price][$k]", $data['nonstdstock_detail']['price'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
		<td>&nbsp;</td>
	</tr>
<?php endif; ?>
</table>

<?php if($data['nonstdstock_header']['status'] != '2') : ?>
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
		<td align="center"><?php if($data['nonstdstock_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_change')) : ?>
        <?=form_submit($this->config->item('button_change'), $this->lang->line('button_change'));?>
        <?=form_submit($this->config->item('button_delete_item'),'Delete Item');?>
        <?php endif; ?>
        <?php else: ?>
        <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?><a href="#" onclick="window.open('<?=base_url();?>help/Request untuk Non Standard Stock.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
     <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('nonstdstock/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
<script language="javascript">
	function selectAll(){
		for(i=1; i <= <?=$j;?>; i++)
			document.form1[i].checked=document.form1[<?=++$j;?>].checked;
	}
</script>
<script type="text/javascript">
var config = {
  '.chosen-select'           : {search_contains:true},
  '.chosen-select-deselect'  : {allow_single_deselect:true},
  '.chosen-select-no-single' : {disable_search_threshold:10},
  '.chosen-select-no-results': {no_results_text:'Data tidak ditemukan!'},
  '.chosen-select-width'     : {width:"95%"}
}
for (var selector in config) {
  $(selector).chosen(config[selector]);
}
</script>