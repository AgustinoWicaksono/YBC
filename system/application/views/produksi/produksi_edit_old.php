<link href="<?=base_url();?>css/chosen.min.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css" media="all">
/* fix rtl for demo */
.chosen-rtl .chosen-drop { left: -9000px; }
</style>
<script src="<?=base_url();?>js/chosen.jquery.min.js" type="text/javascript"></script>
<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print 'array ';
//print_r($item_group);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('gisto_dept_header[id_gisto_dept_header]', $this->uri->segment(3));?>
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
		<td width="272" class="table_field_1"><strong>Purchase Order Number </strong></td>
		<td class="column_input"><?=empty($data['gisto_dept_header']['po_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['gisto_dept_header']['po_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Retur Number </strong></td>
		<td class="column_input"><?=empty($data['gisto_dept_header']['gisto_dept_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['gisto_dept_header']['gisto_dept_no'];?></td>
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
		<td class="table_field_1"><strong>Transfer Out to Outlet</strong> </td>
		<td class ="column_input"><?=$receiving_plant['plant'];?><?=" - ";?><?=$receiving_plant['plant_name'];?>
        <?=form_hidden("gisto_dept_header[receiving_plant]", $receiving_plant['plant']);?>
        <?=form_hidden("gisto_dept_header[receiving_plant_name]", $receiving_plant['plant_name']);?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['gisto_dept_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?>
        <?=$item_group['item_group_code'];?><?=form_hidden("gisto_dept_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['gisto_dept_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2') {
//		$posting_date = date('d-m-Y');
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	} else if(!empty($data['gisto_dept_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
    		$posting_date = $data['gisto_dept_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['gisto_dept_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['gisto_dept_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['gisto_dept_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('gisto_dept_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'gisto_dept_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("gisto_dept_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['gisto_dept_header']['status']) || $data['gisto_dept_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Remarks</strong></div></td>
		<?php if(($data['gisto_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['gisto_dept_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $gisto_dept_detail_tmp = $this->session->userdata('gisto_dept_detail');
    if(!empty($gisto_dept_detail_tmp)) {
       $data['gisto_dept_detail'] = $gisto_dept_detail_tmp;
    }

	$count = count($data['gisto_dept_detail']['id_gisto_dept_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($gisto_dept_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($gisto_dept_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['gisto_dept_header']['status'] == '1' || ( ($data['gisto_dept_header']['status'] == '2') && !empty($data['gisto_dept_detail']['gr_quantity'][$i])  && !empty($data['gisto_dept_detail']['reason'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("gisto_dept_detail[gr_quantity][$i]", $error) || in_array("gisto_dept_detail[material_no][$i]", $error) || in_array("gisto_dept_detail[reason][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['gisto_dept_detail']['material_no'][$i]);
            if (!empty($data['gisto_dept_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['gisto_dept_detail']['material_desc'][$i];
            }
			// dari sini
            if (!empty($data['gisto_dept_detail']['uom'][$i])) {
			  $item_x[$i]['uom'] = $data['gisto_dept_detail']['uom'][$i];
            }
			//====================
			 if (!empty($data['gisto_dept_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['gisto_dept_detail']['num'][$i];
            }
			if (!empty($data['gisto_dept_detail']['reason'][$i])) {
              $item_x[$i]['reason'] = $data['gisto_dept_detail']['reason'][$i];
            }

?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['gisto_dept_header']['status']) || $data['gisto_dept_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gisto_dept_header']['status']) || $data['gisto_dept_header']['status'] == '1') : ?>
        <?=form_hidden("gisto_dept_detail[id_gisto_dept_h_detail][$k]", $data['gisto_dept_detail']['id_gisto_dept_h_detail'][$k]);?>
        <?=form_hidden("gisto_dept_detail[id_gisto_dept_detail][$k]", $data['gisto_dept_detail']['id_gisto_dept_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("gisto_dept_detail[material_no][$k]", $data['gisto_dept_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("gisto_dept_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--dari sini -->
        <td>
        <?=$data['gisto_dept_detail']['num'][$i];?>
        <?=form_hidden("gisto_dept_detail[num][$k]", $data['gisto_dept_detail']['num'][$i]);?>
        </td>
        <!-- sampe siniii neehhh -->
		<td align="center">
<?php 
			if(!empty($error) && in_array("gisto_dept_detail[gr_quantity][$i]", $error)) {
				echo form_input("gisto_dept_detail[gr_quantity][$k]", number_format($data['gisto_dept_detail']['gr_quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("gisto_dept_detail[gr_quantity][$k]", $data['gisto_dept_detail']['gr_quantity'][$i]);
                if($data['gisto_dept_header']['status'] != '2')
    				echo form_input("gisto_dept_detail[gr_quantity][$k]", number_format($data['gisto_dept_detail']['gr_quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
    				echo number_format($data['gisto_dept_detail']['gr_quantity'][$i], 2, '.', ',');
			}
?></td>
		<td>
        <?php /* if (((strcmp($item_x[$i]['uom'],'KG')==0)||(strcmp($item_x[$i]['uom'],'G')==0))&&($data['gisto_dept_header']['status'] != '2')):
            if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['uom'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['uom'],'L')==0)||(strcmp($item_x[$i]['uom'],'ML')==0))&&($data['gisto_dept_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['uom'] = 'ML'; } ?>
        <?php endif; */?>
         <?=$item_x[$i]['uom'];?>
         <?=form_hidden("gisto_dept_detail[uom][$k]", $item_x[$i]['uom']);?>
        </td>
        <td>  <?=$item_x[$i]['reason'];?>
         <?=form_hidden("gisto_dept_detail[reason][$k]", $item_x[$i]['reason']);?></td>
		<?php if(($data['gisto_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['gisto_dept_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['gisto_dept_detail']['id_gisto_dept_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['gisto_dept_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}
		
	}
	
	// below is for new data
	if($data['gisto_dept_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['gisto_dept_header']['status']) || $data['gisto_dept_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['gisto_dept_header']['status']) || $data['gisto_dept_header']['status'] == '1') : ?><?=form_hidden("gisto_dept_detail[id_gisto_dept_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" >
		<?php
		if(!empty($error) && in_array("gisto_dept_detail[material_no][$i]", $error)) {
			echo form_dropdown("gisto_dept_detail[material_no][$k]", $item, $data['gisto_dept_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select error_text" style="width:450px;" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("gisto_dept_detail[material_no][$k]", $item, $data['gisto_dept_detail']['material_no'][$i], ' data-placeholder="Pilih material..." class="chosen-select input_text" style="width:450px;" onChange="document.form1.submit();"');
		}
		?>
		</td>
       
        <td>
         <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		$it=$data['gisto_dept_detail']['material_no'][$i];
		$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['num']] = $r['num'];
		}
		
		//print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("gisto_dept_detail[num][$i]", $error)) {
			echo form_dropdown("gisto_dept_detail[num][$k]", $item1, $data['gisto_dept_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("gisto_dept_detail[num][$k]", $item1  , $data['gisto_dept_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}
		?>
        
        </td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("gisto_dept_detail[gr_quantity][$i]", $error)) {
			echo form_input("gisto_dept_detail[gr_quantity][$k]", $data['gisto_dept_detail']['gr_quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("gisto_dept_detail[gr_quantity][$k]", $data['gisto_dept_detail']['gr_quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
        <!-- dari sini -->
        <td>
       <?php
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
	
		if(!empty($error) && in_array("gisto_dept_detail[uom][$i]", $error)) {
			echo form_dropdown("gisto_dept_detail[uom][$k]", $itemC, $data['gisto_dept_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("gisto_dept_detail[uom][$k]", $itemC  , $data['gisto_dept_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
	   ?>
        </td>
        <!-- sampe sini -->
        <td align="center">
		<?php
			echo form_input("gisto_dept_detail[reason][$k]", $data['gisto_dept_detail']['reason'][$i], 'class="input_number" size="24"');
		?>
		</td>
	</tr>
<?php
	endif;
?>
<?php if(($data['gisto_dept_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="5">&nbsp;</td>
		<td align="center"><?=form_checkbox('select_all', 'select_all', FALSE, '<b>'.$this->lang->line('select_all').'</b>', 'onclick="selectAll()"');?><?=form_hidden('count', $j);?></td>
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
<?php if($data['gisto_dept_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0" align="left">
	<tr>
		<td colspan="2" align="center">
         <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?></td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['gisto_dept_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?><a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue Stock Transfer Antar Plant.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a>
        </td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('gisto_dept/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
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