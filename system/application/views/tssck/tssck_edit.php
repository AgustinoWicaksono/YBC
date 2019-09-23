<?php
$function = $this->uri->segment(2);
$function = $this->uri->segment(2);
//echo "<pre>";
//print 'array ';
//print_r($item_group);
//echo "</pre>";
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('tssck_header[id_tssck_header]', $this->uri->segment(3));?>
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
		<td class="column_input"><?=empty($data['tssck_header']['po_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['tssck_header']['po_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Goods Issue Number </strong></td>
		<td class="column_input"><?=empty($data['tssck_header']['tssck_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['tssck_header']['tssck_no'];?></td>
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
		<td class="table_field_1"><strong>Receiving Plant</strong> </td>
		<td class ="column_input"><?=$receiving_plant['plant'];?><?=" - ";?><?=$receiving_plant['plant_name'];?>
        <?=anchor('tssck/input', '<strong>Pilih ulang Receiving Plant dan Delivery Number</strong>');?>
        <?=form_hidden("tssck_header[receiving_plant]", $receiving_plant['plant']);?>
        <?=form_hidden("tssck_header[receiving_plant_name]", $receiving_plant['plant_name']);?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['tssck_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Delivery Order Number</strong></td>
        <td class = "column_input"><?=$do_no;?></td>
        <?=form_hidden("tssck_header[do_no]",$do_no);?>

	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['tssck_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	else if(!empty($data['tssck_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||!empty($error))
    		$posting_date = $data['tssck_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['tssck_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['tssck_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['tssck_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('tssck_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'tssck_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("tssck_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['tssck_header']['status']) || $data['tssck_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<?php if($data['tssck_header']['status'] == '2') : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['tssck_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $tssck_detail_tmp = $this->session->userdata('tssck_detail');
    if(!empty($tssck_detail_tmp)) {
       $data['tssck_detail'] = $tssck_detail_tmp;
    }

	$count = count($data['tssck_detail']['id_tssck_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($tssck_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

    unset($tssck_detail_tmp);

	for($i = 1; $i <= $count2; $i++) {

		if($data['tssck_header']['status'] == '1' || ( ($data['tssck_header']['status'] == '2') && !empty($data['tssck_detail']['gr_quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("tssck_detail[gr_quantity][$i]", $error) ||
                                                   in_array("tssck_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_tssck->tssck_do_item_select_by_material_no($do_no,$data['tssck_detail']['material_no'][$i]);
            if (!empty($data['tssck_detail']['material_desc'][$i])) {
              $item_x[$i]['material_desc'] = $data['tssck_detail']['material_desc'][$i];
            }
            if (!empty($data['tssck_detail']['uom'][$i])) {
              $item_x[$i]['uom'] = $data['tssck_detail']['uom'][$i];
            }
			
			 if (!empty($data['tssck_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['tssck_detail']['num'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['tssck_header']['status']) || $data['tssck_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['tssck_header']['status']) || $data['tssck_header']['status'] == '1') : ?>
        <?=form_hidden("tssck_detail[id_tssck_h_detail][$k]", $data['tssck_detail']['id_tssck_h_detail'][$k]);?>
        <?=form_hidden("tssck_detail[id_tssck_detail][$k]", $data['tssck_detail']['id_tssck_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("tssck_detail[material_no][$k]", $data['tssck_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['material_desc'];?>
        <?=form_hidden("tssck_detail[material_desc][$k]", $item_x[$i]['material_desc']);?>
        </td>
        <td> <?=$item_x[$i]['num'];?>
        <?=form_hidden("tssck_detail[num][$k]", $item_x[$i]['num']);?> </td>
		<td align="center">
<?php
			if(!empty($error) && in_array("tssck_detail[gr_quantity][$i]", $error)) {
				echo form_input("tssck_detail[gr_quantity][$k]", number_format($data['tssck_detail']['gr_quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("tssck_detail[gr_quantity][$k]", $data['tssck_detail']['gr_quantity'][$i]);
                if($data['tssck_header']['status'] == '2')
    				echo number_format($data['tssck_detail']['gr_quantity'][$i], 2, '.', ',');
                else
    				echo form_input("tssck_detail[gr_quantity][$k]", number_format($data['tssck_detail']['gr_quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
?></td>
		<td>
        <?=$data['tssck_detail']['uom'][$i];?>
        <?=form_hidden("tssck_detail[uom][$k]", $data['tssck_detail']['uom'][$i]);?>
        </td>
		<?php if($data['tssck_header']['status'] == '2'): ?>
        <td align="center">
        <?php if($data['tssck_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['tssck_detail']['id_tssck_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['tssck_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}
		
	}

	// below is for new data
	if($data['tssck_header']['status'] != '2') :

?>
	<tr>
<?php if(!isset($data['tssck_header']['status']) || $data['tssck_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['tssck_header']['status']) || $data['tssck_header']['status'] == '1') : ?><?=form_hidden("tssck_detail[id_tssck_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		
		if(!empty($error) && in_array("tssck_detail[material_no][$i]", $error)) {
			echo form_dropdown("tssck_detail[material_no][$k]", $item, $data['tssck_detail']['material_no'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("tssck_detail[material_no][$k]", $item, $data['tssck_detail']['material_no'][$i], 'class="input_text" onChange="document.form1.submit();"');
		}
		?>
		</td>
        <td align="center">
		<?php
		//mssql_connect("localhost","root","");
		//mssql_select_db("sap_php");
		$whs=$this->session->userdata['ADMIN']['storage_location'];
		mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		$it=$data['tssck_detail']['material_no'][$i];
		$t=mysql_query("SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['num']] = $r['num'];
		}
		if(!empty($error) && in_array("tssck_detail[num][$i]", $error)) {
			echo form_dropdown("tssck_detail[num][$k]", $item1, $data['tssck_detail']['num'][$i], 'class="error_text"');
		} else {
			echo form_dropdown("tssck_detail[num][$k]", $item1, $data['tssck_detail']['num'][$i], 'class="input_text"');
		}
		?>
		</td>
		<td align="center">
		<?php
		if(!empty($error) && in_array("tssck_detail[gr_quantity][$i]", $error)) {
			echo form_input("tssck_detail[gr_quantity][$k]", $data['tssck_detail']['gr_quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("tssck_detail[gr_quantity][$k]", $data['tssck_detail']['gr_quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
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
	
		if(!empty($error) && in_array("tssck_detail[uom][$i]", $error)) {
			echo form_dropdown("tssck_detail[uom][$k]", $itemC, $data['tssck_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:10px;" ');
		} else {
		echo form_dropdown("tssck_detail[uom][$k]", $itemC  , $data['tssck_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:10px;"  ');  
		}
		}
	   ?>
        </td>
	</tr>
<?php
	endif;
?>
<?php if($data['tssck_header']['status'] == '2') : ?>
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
<?php if($data['tssck_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
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
		<td align="center"><?php if($data['tssck_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
         <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
         <?php endif; ?>
         <?php endif; ?>
         <a href="#" onclick="window.open('<?=base_url();?>help/Transfer Selisih Stock ke CK.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('tssck/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
