<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($mpaket_detail);
//echo "</pre>";
//echo '$item_paket_name'.$item_paket_name
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('mpaket_header[id_mpaket_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
 $whs=$this->session->userdata['ADMIN']['plant'];
if ($function=='edit') {
  $item_paket_code = $data['mpaket_header']['kode_paket'];
  $item_paket_name = $data['mpaket_header']['nama_paket'];
  $uom_paket = $data['mpaket_header']['uom_paket'];
 
}
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>BOM Item Code</strong></td>
		<td class="column_input"><?=form_hidden("mpaket_header[kode_paket]", $item_paket_code);?>
        <strong><?=$this->l_general->remove_0_digit_in_item_code($item_paket_code);?></strong> <? if($function!='edit') : echo anchor('mpaket/input', '<strong>Pilih Ulang Item paket</strong>'); endif; ?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>BOM Item Description</strong></td>
		<td class="column_input"><?=form_hidden("mpaket_header[nama_paket]", $item_paket_name);?>
        <strong><?=$item_paket_name;?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>BOM Quantity</strong></td>
        <td class = "column_input" >
		<?php
  		if(!empty($error) && in_array("mpaket_header[quantity_paket]", $error)) {
  			echo form_input("mpaket_header[quantity_paket]", number_format($data['mpaket_header']['quantity_paket'], 2, '.', ''), 'class="error_number" size="8"').' '.$uom_paket;
  		} else {
  			echo form_input("mpaket_header[quantity_paket]", number_format($data['mpaket_header']['quantity_paket'], 2, '.', ''), 'class="input_number" size="8"').' '.$uom_paket;
  		}
		?><?=form_hidden("mpaket_header[uom_paket]", $uom_paket);?>
        </td>
	</tr>
    <!--tr>
		<td class="table_field_1"><strong>Batch Number</strong></td>
        <td class = "column_input" >
		<?php
/*		mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		$to="SELECT * FROM m_batch WHERE ItemCode='$item_paket_code' AND Whs = '$whs'";
		$t=mysql_query($to);
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['DistNumber']] = $r['DistNumber'];
		}
  		if(!empty($error) && in_array("mpaket_header[num]", $error)) {
			echo form_dropdown("mpaket_header[num]", $item1, $data['mpaket_header']['num'], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("mpaket_header[num]", $item1  , $data['mpaket_header']['num'], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		} // echo $to;*/?>
        
        </td>
	</tr-->
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
		<td width="1038" class="table_header_1"><div align="center"><strong>BOM Item</strong></div></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['mpaket_header']['status']) || $data['mpaket_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1" width="200"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <!--td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td-->
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
	</tr>
<?php
//if($data['mpaket_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $mpaket_detail_tmp = $this->session->userdata('mpaket_detail');
    if(!empty($mpaket_detail_tmp)) {
       $data['mpaket_detail'] = $mpaket_detail_tmp;
    }

	$count = count($data['mpaket_detail']['id_mpaket_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($mpaket_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count - 1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['mpaket_header']['status'] == '1' || ( ($data['mpaket_header']['status'] == '2') && !empty($data['mpaket_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("mpaket_detail[quantity][$i]", $error) || in_array("mpaket_detail[material_no][$i]", $error) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['mpaket_detail']['material_no'][$i]);
            if (!empty($data['mpaket_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['mpaket_detail']['material_desc'][$i];
            }
            if (!empty($data['mpaket_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['mpaket_detail']['uom'][$i];
            }
			/* if (!empty($data['mpaket_detail']['num'][$i])) {
              $item_x[$i]['DistNumber'] = $data['mpaket_detail']['num'][$i];
            } */
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['mpaket_header']['status']) || $data['mpaket_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center">
        <?=form_hidden("mpaket_detail[id_mpaket_h_detail][$k]", $data['mpaket_detail']['id_mpaket_h_detail'][$k]);?>
        <?=form_hidden("mpaket_detail[id_mpaket_detail][$k]", $data['mpaket_detail']['id_mpaket_detail'][$k]);?>
        <?=$k;?></td>
		<td align="left"><?=form_hidden("mpaket_detail[material_no][$k]", $data['mpaket_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("mpaket_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td>
        <!--td>
        <?php //$item_x[$i]['DistNumber'];?>
        <?php //form_hidden("mpaket_detail[num][$k]", $item_x[$i]['DistNumber']);?>
        </td-->
		<td align="center">
<?php
			if(!empty($error) && in_array("mpaket_detail[quantity][$i]", $error)) {
				echo form_input("mpaket_detail[quantity][$k]", number_format($data['mpaket_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("mpaket_detail[quantity][$k]", $data['mpaket_detail']['quantity'][$i]);
                if($data['mpaket_header']['status'] != '2')
   				  echo form_input("mpaket_detail[quantity][$k]", number_format($data['mpaket_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
                else
   				  echo number_format($data['mpaket_detail']['quantity'][$i], 2, '.', ',');
			}
?></td>
		<td>
        <?php if (((strcmp($item_x[$i]['UNIT'],'KG')==0)||(strcmp($item_x[$i]['UNIT'],'G')==0))&&($data['mpaket_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'G'; } ?>
        <?php elseif (((strcmp($item_x[$i]['UNIT'],'L')==0)||(strcmp($item_x[$i]['UNIT'],'ML')==0))&&($data['mpaket_header']['status'] != '2')):
           if(isset($_POST['button']['add'])||isset($_POST['button']['delete'])) { $item_x[$i]['UNIT'] = 'ML'; } ?>
        <?php endif; ?>
         <?=$item_x[$i]['UNIT'];?>
         <?=form_hidden("mpaket_detail[uom][$k]", $item_x[$i]['UNIT']);?>
        </td>
  </tr>
<?php
			$k++;
		}

	}
	
	// below is for new data
	if($data['mpaket_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['mpaket_header']['status']) || $data['mpaket_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['mpaket_header']['status']) || $data['mpaket_header']['status'] == '1') : ?><?=form_hidden("mpaket_detail[id_mpaket_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		if(!empty($error) && in_array("mpaket_detail[material_no][$i]", $error)) {
			echo form_dropdown("mpaket_detail[material_no][$k]", $item, $data['mpaket_detail']['material_no'][$i], 'class="error_text" ');
		} else {
			echo form_dropdown("mpaket_detail[material_no][$k]", $item, $data['mpaket_detail']['material_no'][$i], 'class="input_text" ');
		}
		?>
		</td>
         <!--td>
         <?php
		/*$it=$data['mpaket_detail']['material_no'][$i];
		$tk="SELECT DistNumber FROM m_batch where ItemCode='$it' AND Whs ='$whs'";
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		while($r=mysql_fetch_array($ti))
		{
			$item3[$r['DistNumber']] = $r['DistNumber'];
		}
		
		
		if ($count > 0){
	
		if(!empty($error) && in_array("mpaket_detail[num][$i]", $error)) {
			echo form_dropdown("mpaket_detail[num][$k]", $item3, $data['mpaket_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("mpaket_detail[num][$k]", $item3  , $data['mpaket_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		} 
		//print_r($item3);
		//echo $tk; 
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		} */
		?>
        
        </td-->
		<td align="center">
		<?php
		if(!empty($error) && in_array("mpaket_detail[quantity][$i]", $error)) {
			echo form_input("mpaket_detail[quantity][$k]", $data['mpaket_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("mpaket_detail[quantity][$k]", $data['mpaket_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		?>
		</td>
	</tr>
<?php
	endif;
?>
<?php if(($data['mpaket_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="6">&nbsp;</td>
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
<?php if($data['mpaket_header']['status'] != '2') : ?>
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
		<td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue to Cost Center.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('mpaket/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
