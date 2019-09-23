<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($twts_detail);
?>

<script language="javascript">
function changeVal(obj, number) {
	var x = 'twts_detail[quantity]['+number+']';
	var y = 'twts_detail[konv_qty]['+number+']';
	var z = 'twts_detail[quantity_gr]['+number+']';
	var num = 0;
	var result = 0;

	if(obj.form.elements[x].value == '') {
		obj.form.elements[x].value = 0;
	} else if(obj.form.elements[y].value == '') {
		obj.form.elements[y].value = 0;
	}
    num = parseFloat(obj.form.elements[x].value) * parseFloat(obj.form.elements[y].value);
	result = num.toFixed(2);
	obj.form.elements[z].value = result;
}
</script>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string(), $form1);?>
<?=form_hidden('twts_header[id_twts_header]', $this->uri->segment(3));?>
<table width="1120" border="0" align="center">
<?php
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
$var_cek=1;
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Cutting Out No.</strong></td>
		<td class="column_input"><?=empty($data['twts_header']['gi_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['twts_header']['gi_no'];?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Cutting In No.</strong></td>
		<td class="column_input"><?=empty($data['twts_header']['gr_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['twts_header']['gr_no'];?></td>
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
		<td class="table_field_1"><strong>Status </strong></td>
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['twts_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_code'];?><?=form_hidden("twts_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['twts_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
//		$posting_date = date('d-m-Y');
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	else
    if(!empty($data['twts_header']['posting_date']))
        if(substr($data['twts_header']['posting_date'],2,1)=='-')
//        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
//        if($function!=='edit')
    		$posting_date = $data['twts_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['twts_header']['posting_date'])));
//    else
//      $posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['twts_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['twts_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('twts_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'twts_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("twts_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
	<tr>
	  <td colspan="2" align="right" class="table_field_1"><?php if($data['twts_header']['status'] == '2') : ?>
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
<table width="1120" border="0" align="center" id="table3">
	<tr bgcolor="#999999">
		<td width="500" class="table_header_1"><div align="center"><strong>Cutting Out</strong></div></td>
		<td width="30" class="table_header_1">&nbsp;</td>
		<td width="500" class="table_header_1"><div align="center"><strong>Cutting In</strong></div></td>
	</tr>
</table>
<table width="1120" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['twts_header']['status']) || $data['twts_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>POS Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>POS Material Desc</strong></div></td>
		<td class="table_header_1"><strong>Batch Number</strong></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Konv. Qty</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>POS Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>POS Material Desc</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Var</strong></div></td>
		<?php if(($data['twts_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['twts_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows

    $twts_detail_tmp = $this->session->userdata('twts_detail');
    if(!empty($twts_detail_tmp)) {
       $data['twts_detail'] = $twts_detail_tmp;
    }
	$count = count($data['twts_detail']['id_twts_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&($data['twts_detail']['quantity'][$count]>0)&&(empty($twts_detail_tmp))&&(empty($error))) {
		$count2 = $count;
	} else {
		$count2 = $count - 1;
    }

	for($i = 1; $i <= $count2; $i++) {

		if($data['twts_header']['status'] == '1' || ( ($data['twts_header']['status'] == '2') && !empty($data['twts_detail']['quantity'][$i]) && !empty($data['twts_detail']['uom_gr'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("twts_detail[quantity][$i]", $error)
                                                 || in_array("twts_detail[quantity_gr][$i]", $error)
                                                 || in_array("twts_detail[material_no][$i]", $error)
                                                 || in_array("twts_detail[material_no_gr][$i]", $error)
												 || in_array("twts_detail[num][$i]", $error)
												 || in_array("twts_detail[uom_gr][$i]", $error)
												 ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['twts_detail']['material_no'][$i]);
            if (!empty($data['twts_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['twts_detail']['material_desc'][$i];
            }
            if (!empty($data['twts_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['twts_detail']['uom'][$i];
            }

			$item_x_gr[$i] = $this->m_twts->twts_item_slice_select($data['twts_detail']['material_no'][$i],$data['twts_detail']['material_no_gr'][$i]);
            if (!empty($data['twts_detail']['material_desc_gr'][$i])) {
              $item_x_gr[$i]['MAKTX'] = $data['twts_detail']['material_desc_gr'][$i];
            }
            if (!empty($data['twts_detail']['uom'][$i])) {
              $item_x_gr[$i]['UNIT'] = $data['twts_detail']['uom_gr'][$i];
            }
            if (!empty($data['twts_detail']['konv_qty'][$i])) {
              $item_x_gr[$i]['quantity'] = $data['twts_detail']['konv_qty'][$i];
            }
			 if (!empty($data['twts_detail']['num'][$i])) {
              $item_x[$i]['DistNumber'] = $data['twts_detail']['num'][$i];
            }
			// if (!empty($data['twts_detail']['var'][$i])) {
             // $item_x[$i]['var'] = $data['twts_detail']['var'][$i];
            //}
		//	$var_cek=$data['twts_detail']['var'][$i];
			//echo '{'.$data['twts_detail']['var'][$i].'}';
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['twts_header']['status']) || $data['twts_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['twts_header']['status']) || $data['twts_header']['status'] == '1') : ?>
        <?=form_hidden("twts_detail[id_twts_h_detail][$k]", $data['twts_detail']['id_twts_h_detail'][$k]);?>
        <?=form_hidden("twts_detail[id_twts_detail][$k]", $data['twts_detail']['id_twts_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
		<td align="left"><?=form_hidden("twts_detail[material_no][$k]", $data['twts_detail']['material_no'][$i]);?>
        <?=$item_x[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x[$i]['MAKTX'];?>
        <?=form_hidden("twts_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>        </td>
		<td align="center"><?=$item_x[$i]['DistNumber'];?>
        <?=form_hidden("twts_detail[num][$k]", $item_x[$i]['DistNumber']);?></td>
		<td align="center">
<?php
			if(!empty($error) && in_array("twts_detail[quantity][$i]", $error)) {
				echo form_input("twts_detail[quantity][$k]", number_format($data['twts_detail']['quantity'][$i], 2, '.', ''), 'onChange="changeVal(this, '.$k.')" class="error_number" size="8"');
			} else {
                if($data['twts_header']['status'] != '2')
   				  echo form_input("twts_detail[quantity][$k]", number_format($data['twts_detail']['quantity'][$i], 2, '.', ''), 'onChange="changeVal(this, '.$k.')" class="input_number" size="8"');
                else {
   				  echo number_format($data['twts_detail']['quantity'][$i], 2, '.', ',');
 				  echo form_hidden("twts_detail[quantity][$k]", $data['twts_detail']['quantity'][$i]);
                }
			}
        ?></td>
		<td>
         <?=$data['twts_detail']['uom'][$i];?>
         <?=form_hidden("twts_detail[uom][$k]", $data['twts_detail']['uom'][$i]);?>        </td>
        <td align="right">
        <?=$item_x_gr[$i]['quantity'];?>
        <?=form_hidden("twts_detail[konv_qty][$k]", $item_x_gr[$i]['quantity']);?>        </td>
		<td align="left"><?=form_hidden("twts_detail[material_no_gr][$k]", $data['twts_detail']['material_no_gr'][$i]);?>
        <?=$item_x_gr[$i]['MATNR1'];?></td>
		<td align="left"><?=$item_x_gr[$i]['MAKTX'];?>
        <?=form_hidden("twts_detail[material_desc_gr][$k]", $item_x_gr[$i]['MAKTX']);?>        </td>
		<td align="center">
        <?php
            if (empty($data['twts_detail']['quantity_gr'][$i]))
              $qty_gr = 1;//$data['twts_detail']['quantity'][$i]*$item_x_gr[$i]['quantity'];
            else
              $qty_gr = 1;//$data['twts_detail']['quantity_gr'][$i];
            if(!empty($error) && in_array("twts_detail[quantity_gr][$i]", $error)) {
				echo form_input("twts_detail[quantity_gr][$k]", number_format($qty_gr, 2, '.', ''), 'class="error_number" size="8"  ');
			} else {
                if($data['twts_header']['status'] != '2')
   				  echo form_input("twts_detail[quantity_gr][$k]", number_format($qty_gr, 2, '.', ''), 'class="input_number" size="8" ');
                else {
   				  echo number_format($qty_gr, 2, '.', ',');
		          echo form_hidden("twts_detail[quantity_gr][$k]", $qty_gr);
                }
			}
        ?>        </td>
		<td>
         <?php /* echo $data['twts_detail']['uom_gr'][$i];?>
         <?=form_hidden("twts_detail[uom_gr][$k]",$data['twts_detail']['uom_gr'][$i])*/;?>
         <?php
		$ita=  $data['twts_detail']['material_no_gr'][$i];
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$ita'");
	   $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$ita' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$ita' 
group by m_uom.UomName 

");

		$count1=mysql_num_rows($tq);
		$ri=mysql_fetch_array($ti);
		$itemC[0]='';		
		while($r=mysql_fetch_array($tq))
		{
			$itemC[$r['UNIT']] = $r['UNIT'];
		}
		
		//print_r($item1);
		if ($count1 > 0){
	
		if(!empty($error) && in_array("twts_detail[uom_gr][$i]", $error)) {
			echo form_dropdown("twts_detail[uom_gr][$k]", $itemC, $data['twts_detail']['uom_gr'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:40px;" ');
		} else {
		echo form_dropdown("twts_detail[uom_gr][$k]", $itemC  , $data['twts_detail']['uom_gr'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:40px;"  ');  
		}
		}
	   ?>
         </td>
         <td>
		 <?php
		// echo $i;
		 $itemSlice=$item_x[$i]['MATNR1'];
		 $itemRec=$item_x_gr[$i]['MATNR1'];
		 if ($i == 1)
		 {
         $req=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemSlice'"));
		 $vol_hed=$req['VOL'];
		 }
		 else
		 {
		  $req=mysql_fetch_array(mysql_query("SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'"));
		  $vol_hed=$req['VOL_TEMP'];
		  //echo "SELECT VOL_TEMP FROM m_item WHERE MATNR='$itemSlice'";
		 }
		
		$req1=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$itemRec'"));
		$vol_det=$req1['VOL'];
		$var_cek=$vol_hed-$vol_det;
		//echo "$var_cek=$vol_hed-$vol_det;";
		mysql_query("update m_item set VOL_TEMP ='$var_cek' WHERE MATNR='$itemSlice' ");
		 ?>
		 <?=$var_cek;?>
        <?=form_hidden("twts_detail[var][$k]", $var_cek);?> </td>

		<?php if(($data['twts_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['twts_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['twts_detail']['id_twts_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['twts_detail']['ok_cancel'][$i];?><?php endif; ?>        </td>
        <?php endif; ?>
  </tr>
<?php
			$k++;
		}

	}
	
	// below is for new data
	if($data['twts_header']['status'] != '2' ) :
	
?>
	<tr>
<?php if(!isset($data['twts_header']['status']) || $data['twts_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['twts_header']['status']) || $data['twts_header']['status'] == '1') : ?><?=form_hidden("twts_detail[id_twts_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
		mysql_connect("localhost","root","");
		mysql_select_db("sap_php");
		$plant=$this->session->userdata['ADMIN']['plant'];
		$itemA['']='';
		$ta=mysql_query("SELECT kode_whi,nama_whi FROM m_mwts_header WHERE plant ='$plant'");
	 	while($r=mysql_fetch_array($ta))
		{
			$itemA[$r['kode_whi']] = $r['kode_whi'].' - '.$r['nama_whi'];
		}
		
		if(!empty($error) && in_array("twts_detail[material_no][$i]", $error)) {
			echo form_dropdown("twts_detail[material_no][$k]", $itemA, $data['twts_detail']['material_no'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("twts_detail[material_no][$k]", $itemA, $data['twts_detail']['material_no'][$i], 'class="input_text" onChange="document.form1.submit();"');
		}
		?>		</td>
        <td align="center">
        <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		
		$it=$data['twts_detail']['material_no'][$i];
		//select volume
		
		
		$t=mysql_query("SELECT DistNumber FROM m_batch where ItemCode='$it' AND Whs ='$whs'"); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		while($r=mysql_fetch_array($t))
		{
			$item1[$r['DistNumber']] = $r['DistNumber'];
		}
		
		$tq=mysql_query("select BATCH from m_item WHERE MATNR = '$it'");
		$rq=mysql_fetch_array($tq);
		$bt=$rq['BATCH'];
		
		//print_r($item1);
		if ($count > 0 /*&& $bt =='Y'*/){
		if(!empty($error) && in_array("twts_detail[num][$i]", $error)) {
			echo form_dropdown("twts_detail[num][$k]", $item1, $data['twts_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:450px;" ');
		} else {
		echo form_dropdown("twts_detail[num][$k]", $item1  , $data['twts_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:450px;"  ');  
		}
		}
		else
		{
		  echo "Tidak Ada Batch Number";
		  
		}
		?>
        </td>
        <?=form_hidden("count_k", $k);?>
		<td align="center">
		<?php
		if(!empty($error) && in_array("twts_detail[quantity][$i]", $error)) {
			echo form_input("twts_detail[quantity][$k]", $data['twts_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("twts_detail[quantity][$k]", $data['twts_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		?>		</td>
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
	
		if(!empty($error) && in_array("twts_detail[uom][$i]", $error)) {
			echo form_dropdown("twts_detail[uom][$k]", $itemC, $data['twts_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:40px;" ');
		} else {
		echo form_dropdown("twts_detail[uom][$k]", $itemC  , $data['twts_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:40px;"  ');  
		}
		}
	   ?>
        </td>
		<td>&nbsp;</td>
		<td colspan="2" align="center">
		<?php
		if ($var_cek > 0)
		{
		if(!empty($error) && in_array("twts_detail[material_no_gr][$i]", $error)) {
			echo form_dropdown("twts_detail[material_no_gr][$k]", $item_gr, $data['twts_detail']['material_no_gr'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("twts_detail[material_no_gr][$k]", $item_gr, $data['twts_detail']['material_no_gr'][$i], 'class="input_text" onChange="document.form1.submit();"');
		}
		}
		?>		</td>
		<td >&nbsp;</td>
        <td >
        <?php
		$ita=  $data['twts_detail']['material_no_gr'][$i];
		$req1=mysql_fetch_array(mysql_query("SELECT VOL FROM m_item WHERE MATNR='$ita'"));
		$vol_det=$req1['VOL'];
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$ita'");
	   $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$ita' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$ita' 
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
	
		if(!empty($error) && in_array("twts_detail[uom_gr][$i]", $error)) {
			echo form_dropdown("twts_detail[uom_gr][$k]", $itemC, $data['twts_detail']['uom_gr'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:40px;" ');
		} else {
		echo form_dropdown("twts_detail[uom_gr][$k]", $itemC  , $data['twts_detail']['uom_gr'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:40px;"  ');  
		}
		}
	   ?>
        </td>
        <td><?php
		//$tes="SELECT VOL FROM m_item WHERE MATNR='$ita'";
		$var=$vol_hed - $vol_det;
		if(!empty($error) && in_array("twts_detail[var][$i]", $error)) {
			echo form_input("twts_detail[var][$k]", $ita,$data['twts_detail']['var'][$i], 'class="error_number" size="8" disabled="disabled" ');
		} else {
			echo form_input("twts_detail[var][$k]", $ita,$data['twts_detail']['var'][$i], 'class="input_number" size="8" disabled="disabled" ');
		}
		
		?></td>
	</tr>
<?php
	endif;
?>
<?php if(($data['twts_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
	<tr>
		<td colspan="7">&nbsp;</td>
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
//endif;
?>
</table>
<?php if($data['twts_header']['status'] != '2') : ?>
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
		<td align="center"><a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue to Cost Center.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td>
  </tr>
	<tr>
    <td align="center"><?=anchor('twts/browse', $this->lang->line('button_back'));?></td>
  </tr>
	<tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?=form_close();?>
