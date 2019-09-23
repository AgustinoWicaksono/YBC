<?php
$function = $this->uri->segment(2);
//echo "<pre>";
//print_r($error);
//print_r($_POST);
//echo "</pre>";
?>

<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('tpaket_header[id_tpaket_header]', $this->uri->segment(3));?>
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
		<td width="272" class="table_field_1"><strong>Goods Receipt No.</strong></td>
		<td class="column_input"><?=empty($data['tpaket_header']['material_doc_no']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['tpaket_header']['material_doc_no'];?></td>
	</tr>
	<tr>
		<td width="272" class="table_field_1"><strong>Goods Issue No.</strong></td>
		<td class="column_input"><?=empty($data['tpaket_header']['material_doc_no_out']) ? '<em>(Auto Number after Posting to SAP)</em>' : $data['tpaket_header']['material_doc_no_out'];?></td>
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
		<td class = "column_input"><strong><?=($function == 'input2') ? 'Not Approved' : $data['tpaket_header']['status_string'];?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Material Group</strong></td>
		<td class="column_input"><?=form_hidden('item_group[item_group_code]', $item_group['item_group_code']);?><?=$item_group['item_group_code'];?><?=form_hidden("tpaket_header[item_group_code]", $item_group['item_group_code']);?></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong>Posting Date </strong></td>
<!--		<td class="column_input"><?=($function == 'input2') ? date("d-m-Y") : date("d-m-Y", strtotime($data['tpaket_header']['posting_date']));?></td>//-->
<?php
	if(empty($_POST) && $function == 'input2')
//		$posting_date = date("d-m-Y");
		$posting_date = date('d-m-Y',strtotime($this->m_general->posting_date_select_max()));
	else if(!empty($data['tpaket_header']['posting_date']))
        if ((isset($_POST['button']['add']))||(isset($_POST['button']['delete']))||(count($_POST['delete'])>0)||(!empty($error)))
    		$posting_date = $data['tpaket_header']['posting_date'];
        else
    		$posting_date = date("d-m-Y",strtotime($this->l_general->str_datetime_to_date($data['tpaket_header']['posting_date'])));
        //date("d-m-Y", strtotime($this->l_general->strtodate($data['tpaket_header']['posting_date'])));
?>
		<td class="column_input"><?php if(($data['tpaket_header']['status'] !== '2')&&($this->l_auth->is_have_perm('auth_backdate'))) : ?>
        <?=form_input('tpaket_header[posting_date]', $posting_date, 'class="input_text" size="10"');?> <script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'form1',
						// input name
						'controlname': 'tpaket_header[posting_date]'
					});
		</script><?php else: ?><?=$posting_date;?><?=form_hidden("tpaket_header[posting_date]", $posting_date);?><?php endif;?></td>
	</tr>
     <tr>
		<td class="table_field_1"><strong>Material No</strong></td>
        <td class = "column_input" >
		<?php
		$plant=$this->session->userdata['ADMIN']['plant'];
		$itemA['']='';
		$ta=mysql_query("SELECT kode_paket,nama_paket from m_mpaket_header where plant = '$plant'");
	 	while($r=mysql_fetch_array($ta))
		{
			$itemA[$r['kode_paket']] = $r['kode_paket'].' - '.$r['nama_paket'];
		}
		
		if(!empty($error) && in_array("tpaket_detail[material_no]", $error)) {
			echo form_dropdown("tpaket_detail[material_no]", $itemA, $data['tpaket_detail']['material_no'], 'class="error_text" onChange="document.form1.submit();" ');
		} else {
			echo form_dropdown("tpaket_detail[material_no]", $itemA, $data['tpaket_detail']['material_no'], 'class="input_text" onChange="document.form1.submit();" ');
		}
		 $tem= $data['tpaket_detail']['material_no'];
		  $tem1= $data['tpaket_detail']['material_no'][1];
		 
		?>
       
        </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>BOM Quantity</strong></td>
        <td class = "column_input" >
        <?php
        $wh=$this->session->userdata['ADMIN']['plant'];
		$ra=mysql_fetch_array(mysql_query("SELECT * FROM m_mpaket_header WHERE kode_paket ='$tem' AND plant ='$wh'"));
		$quat=$ra['quantity_paket'];
		if ($quat != ""){
		echo $quat;
		}
		else
		{
			$ra1=mysql_fetch_array(mysql_query("SELECT * FROM m_mpaket_header WHERE kode_paket ='$tem1' AND plant ='$wh'"));
		$quat1=$ra1['quantity_paket'];
		echo $quat1;
		}
		?>
        </td>
     </tr>
     <tr>
		<td class="table_field_1"><strong>Quantity</strong></td>
        <td class = "column_input" >
		<?php
		if ($function == 'input2')
		{
		if(!empty($error) && in_array("tpaket_detail[qty][1]", $error)) {
			echo form_input("tpaket_detail[qty][1]", $data['tpaket_detail']['qty'][1], 'class="error_number" size="8"');
		} else {
			echo form_input("tpaket_detail[qty][1]", $data['tpaket_detail']['qty'][1], 'class="input_number" size="8"');
		}
			
		}
		else
		{
		$h=$data['tpaket_detail']['id_tpaket_header'][1];
		//echo "($h)";
		$ra=mysql_fetch_array(mysql_query("SELECT * FROM t_tpaket_detail
JOIN t_tpaket_header ON t_tpaket_detail.id_tpaket_header=t_tpaket_header.id_tpaket_header
 WHERE t_tpaket_header.id_tpaket_header = '$h'"));
		$quat=$ra['quantity'];
		if(!empty($error) && in_array("tpaket_detail[qty][1]", $error)) {
			echo form_input("tpaket_detail[qty][1]",$quat, $data['tpaket_detail']['qty'][1], 'class="error_number" size="8"');
		} else {
			echo form_input("tpaket_detail[qty][1]",$quat, $data['tpaket_detail']['qty'][1], 'class="input_number" size="8"');
		}
		
		}
		
		
		?>
        
        </td>
	</tr>
    <tr>
   <td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
    <?php
	if ($function == "input2")
	{
	 $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$tem'");
	   $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$tem' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$tem' 
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
	
		if(!empty($error) && in_array("tpaket_detail[uom][1]", $error)) {
			echo form_dropdown("tpaket_detail[uom][1]", $itemC, $data['tpaket_detail']['uom'][1], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:50px;" ');
		} else {
		echo form_dropdown("tpaket_detail[uom][1]", $itemC  , $data['tpaket_detail']['uom'][1], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:50px;"  ');  
		}
		}
		
	}
	else
	{
	$tem = $tem1;
	$id =$data['tpaket_header']['id_tpaket_header'];
	$twr=mysql_query("
	SELECT A.uom FROM t_tpaket_detail A
JOIN t_tpaket_header B ON A.id_tpaket_header = B.id_tpaket_header
WHERE A.id_tpaket_header = '$id'
	");
	$rwr=mysql_fetch_array($twr);
	$uom=$rwr['uom'];
	 ?>
	  <?=$uom;?>
		<?=form_hidden("tpaket_detail[uom][1]", $uom);}?>
	 
       
    </td>
    </tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['tpaket_header']['status']) || $data['tpaket_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material No</strong></div></td>
		  <td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Total Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
		<?php if(($data['tpaket_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?><td class="table_header_1"><div align="center"><strong>Cancel</strong></div></td><?php endif; ?>
	</tr>
<?php
//if($data['tpaket_details'] !== FALSE) :
//	$i = 1; => already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows
	$sirah= $data['tpaket_header']['id_tpaket_header'];
	$ta="SELECT * FROM t_tpaket_detail_paket WHERE id_tpaket_header='$sirah'";
			//echo $i;
	$tq=mysql_query($ta);
	if ($function == 'edit')
	{
	$count=mysql_num_rows($tq);
	}
	else
	{
		$count = count($data['tpaket_detail']['id_tpaket_h_detail']);
	}

    $tpaket_detail_tmp = $this->session->userdata('tpaket_detail');
    if(!empty($tpaket_detail_tmp)) {
       $data['tpaket_detail'] = $tpaket_detail_tmp;
    }

	// for POST data
	if((!isset($_POST['delete']))&&(empty($tpaket_detail_tmp))&&(empty($error)))
		$count2 = $count;
	else
		$count2 = $count-1;

	for($i = 1; $i <= $count2; $i++) {

		if($data['tpaket_header']['status'] == '1' || ( ($data['tpaket_header']['status'] == '2') && !empty($data['tpaket_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("tpaket_detail[quantity][$i]", $error)  || in_array("delete[$i]", $error ) ))
				break;

			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['tpaket_detail']['material_no'][$i]);
            if (!empty($data['tpaket_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['tpaket_detail']['material_desc'][$i];
            }
            if (!empty($data['tpaket_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['tpaket_detail']['uom'][$i];
            }
			if (!empty($data['tpaket_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['tpaket_detail']['num'][$i];
            }
			if (!empty($data['tpaket_detail']['quantity]'][$i])) {
			$item_x[$i]['quantity']=$data['tpaket_detail']['quantity]'][$i];
			}
			if (!empty($data['tpaket_detail']['quantity_total]'][$i])) {
			$item_x[$i]['quantity_total']=$data['tpaket_detail']['quantity_total]'][$i];
			}
			
			while($rq=mysql_fetch_array($tq))
			{
			$gawan[$rq['material_no']]=$rq['material_no'];
			}
			
			if (!empty($data['tpaket_detail']['material_detail'][$i])) {
              $item_x[$i]['material_detail'] = $data['tpaket_detail']['material_detail'][$i];
            }
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['tpaket_header']['status']) || $data['tpaket_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['tpaket_header']['status']) || $data['tpaket_header']['status'] == '1') : ?>
        <?=form_hidden("tpaket_detail[id_tpaket_h_detail][$k]", $data['tpaket_detail']['id_tpaket_h_detail'][$k]);?>
        <?=form_hidden("tpaket_detail[id_tpaket_detail][$k]", $data['tpaket_detail']['id_tpaket_detail'][$k]);?>
        <?php endif; ?><?=$k;?></td>
        <?php
		$r=mysql_fetch_array(mysql_query("SELECT *, material_no material_detail FROM t_tpaket_detail_paket WHERE id_tpaket_header = '$sirah' AND id_tpaket_h_detail_paket ='$i'"));
		if ($function =='edit')
		{
		 ?>
         <td align="left"><?=form_hidden("tpaket_detail[material_detail][$k]", $r['material_detail']);?><?php if ($function=='edit') {echo $r['material_detail'];}?></td>
         <td align="left"><?=form_hidden("tpaket_detail[num][$k]", $r['num']);?><?php if ($function=='edit') {echo $r['num'];}?></td>
         <?php
		 }
         else
		 {
		 ?>
		<td align="left"><?=form_hidden("tpaket_detail[material_detail][$k]", $data['tpaket_detail']['material_detail'][$i]);?><?=$item_x[$i]['material_detail'];?><?php if ($function=='edit') {echo $r['material_detail'];}?></td>
		<!--td align="left"><?php  //$item_x[$i]['MAKTX'];?>
        <?php //form_hidden("tpaket_detail[material_desc][$k]", $item_x[$i]['MAKTX']);?>
        </td-->
        <td align="left"><?=form_hidden("tpaket_detail[num][$k]", $data['tpaket_detail']['num'][$i]);?><?=$item_x[$i]['num'];?><?php if ($function=='edit') {echo $r['num'];}?></td>
        <?php  }?>
		<td align="center">
<?php
if ($function =='input2')
{
			if(!empty($error) && in_array("tpaket_detail[quantity][$i]", $error)) {
				echo form_input("tpaket_detail[quantity][$k]", number_format($data['tpaket_detail']['quantity'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("tpaket_detail[quantity][$k]", $data['tpaket_detail']['quantity'][$i]);
                if($data['tpaket_header']['status'] == '2')
    				echo number_format($data['tpaket_detail']['quantity'][$i], 2, '.', ',');
                else
    				echo form_input("tpaket_detail[quantity][$k]", number_format($data['tpaket_detail']['quantity'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
}
else
{
	echo form_input("tpaket_detail[quantity][$k]", $r['quantity'], 'class="input_number" size="8"');
}
?></td>
<td align="center">
<?php
if ($function !='edit')
{
			if(!empty($error) && in_array("tpaket_detail[quantity_total][$i]", $error)) {
				echo form_input("tpaket_detail[quantity_total][$k]", number_format($data['tpaket_detail']['quantity_total'][$i], 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("tpaket_detail[quantity_total][$k]", $data['tpaket_detail']['quantity_total'][$i]);
                if($data['tpaket_header']['status'] == '2')
    				echo number_format($data['tpaket_detail']['quantity_total'][$i], 2, '.', ',');
                else
    				echo form_input("tpaket_detail[quantity_total][$k]", number_format($data['tpaket_detail']['quantity_total'][$i], 2, '.', ''), 'class="input_number" size="8"');
			}
}
else
{
	echo form_input("tpaket_detail[quantity_total][$k]", $r['quantity_total'], 'class="input_number" size="8"');
}
?></td>
		<td>
        <?php if ($function == "input2") {?>
        <?=$data['tpaket_detail']['detail_uom'][$i];?>
         <?=form_hidden("tpaket_detail[detail_uom][$k]", $data['tpaket_detail']['detail_uom'][$i]);
		 }
		 else
		 {
		 	echo $r['uom'];?>
         <?=form_hidden("tpaket_detail[detail_uom][$k]", $r['uom']);
		 }
		 ?>
        </td>
		<?php if(($data['tpaket_header']['status'] == '2') && ($this->l_auth->is_have_perm('auth_cancel'))): ?>
        <td align="center">
        <?php if($data['tpaket_detail']['ok_cancel'][$i]==FALSE): ?><?=form_checkbox('cancel['.$k.']', $data['tpaket_detail']['id_tpaket_h_detail'][$i], FALSE);?><?php else: ?>
        <?=$data['tpaket_detail']['ok_cancel'][$i];?><?php endif; ?>
        </td>
        <?php endif; ?>
<?php
			$k++;
		}

	}

	// below is for new data
	if($data['tpaket_header']['status'] != '2') :

?>
	<tr>
<?php if(!isset($data['tpaket_header']['status']) || $data['tpaket_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['tpaket_header']['status']) || $data['tpaket_header']['status'] == '1') : ?><?=form_hidden("tpaket_detail[id_tpaket_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		
        <td align="center">
         <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		$it=$data['tpaket_detail']['material_no'];
		$ti="SELECT material_no,material_desc FROM m_mpaket_detail 
		JOIN m_mpaket_header A ON m_mpaket_detail.id_mpaket_header = A.id_mpaket_header
		WHERE A.kode_paket = '$it' AND A.plant='$whs'";
		$t=mysql_query($ti); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		$item3['']='';
		while($r=mysql_fetch_array($t))
		{
			$item3[$r['material_no']] = $r['material_no']." - ".$r['material_desc'];
		}
		$qty_temp=$data['tpaket_detail']['qty'][1];
		//echo($qty_temp);
		//if ()
		
		if ($count > 0){
	
		if(!empty($error) && in_array("tpaket_detail[material_detail][$i]", $error)) {
			echo form_dropdown("tpaket_detail[material_detail][$k]", $item3, $data['tpaket_detail']['material_detail'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:200px;" onChange="document.form1.submit();" ');
		} else {
		echo form_dropdown("tpaket_detail[material_detail][$k]", $item3  , $data['tpaket_detail']['material_detail'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:200px;" onChange="document.form1.submit();"  ');  
		}
		}
		
		?>
        
        </td>
         <td align="center">
         <?php
		 $whs=$this->session->userdata['ADMIN']['storage_location'];
		//mysql_connect("localhost","root","");
		//mysql_select_db("sap_php");
		$it=$data['tpaket_detail']['material_detail'][$i];
		$ti="SELECT DistNumber FROM m_batch where ItemCode='$it' AND Whs ='$whs'";
		$t=mysql_query($ti); 
		$count=mysql_num_rows($t);
		$item2= "Tidak ada Batch Number";
		$item1[''] = '';
		while($r=mysql_fetch_array($t))
		{
			
			$item1[$r['DistNumber']] = $r['DistNumber'];
		}
		
		
	//	print_r($item1);
		if ($count > 0){
	
		if(!empty($error) && in_array("tpaket_detail[num][$i]", $error)) {
			echo form_dropdown("tpaket_detail[num][$k]", $item1, $data['tpaket_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select error_text" style="width:200px;" ');
		} else {
		echo form_dropdown("tpaket_detail[num][$k]", $item1  , $data['tpaket_detail']['num'][$i], ' data-placeholder="Pilih Batch Number..." class="chosen-select input_text" style="width:200px;"  ');  
		}
		}
		else
		{
		 echo "<center>--------</center>"; 
		}  //echo $ti;
		?>
        
        </td>
		<td align="center">
		<?php
		$te=mysql_query("SELECT quantity FROM m_mpaket_detail 
		JOIN m_mpaket_header A ON m_mpaket_detail.id_mpaket_header = A.id_mpaket_header
		WHERE A.kode_paket = '$tem' AND A.plant='$whs' AND m_mpaket_detail.material_no = '$it'");
		$re=mysql_fetch_array($te);
		$quaty=$re['quantity'];
		if(!empty($error) && in_array("tpaket_detail[quantity][$i]", $error)) {
			echo form_input("tpaket_detail[quantity][$k]",$quaty, $data['tpaket_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("tpaket_detail[quantity][$k]",$quaty, $data['tpaket_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
	/*	echo "SELECT quantity FROM m_mpaket_detail 
		JOIN m_mpaket_header A ON m_mpaket_detail.id_mpaket_header = A.id_mpaket_header
		WHERE A.kode_paket = '$tem' AND A.plant='$whs' AND m_mpaket_detail.material_no = '$it'";*/
		?>
		</td>
        <td align="center">
        <?php
		$q=$data['tpaket_detail']['qty'][1];
		$qt=$q*$quaty;
		if(!empty($error) && in_array("tpaket_detail[quantity_total][$i]", $error)) {
			echo form_input("tpaket_detail[quantity_total][$k]",$qt, $data['tpaket_detail']['quantity_total'][$i], 'class="error_number" size="8" disabled="disabled"');
		} else {
			echo form_input("tpaket_detail[quantity_total][$k]",$qt, $data['tpaket_detail']['quantity_total'][$i], 'class="input_number" size="8" disabled="disabled"');
		}
		?>
		</td>
		<td>
        <?php
		$ita=$data['tpaket_detail']['material_detail'][$i];
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
	
		if(!empty($error) && in_array("tpaket_detail[detail_uom][$i]", $error)) {
			echo form_dropdown("tpaket_detail[detail_uom][$k]", $itemC, $data['tpaket_detail']['detail_uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:50px;" ');
		} else {
		echo form_dropdown("tpaket_detail[detail_uom][$k]", $itemC  , $data['tpaket_detail']['detail_uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:50px;"  ');  
		}
		}
	   ?>
        </td>
	</tr>
<?php
	endif;
?>
<?php if(($data['tpaket_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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

</table>
<?php if($data['tpaket_header']['status'] != '2') : ?>
<table width="430" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center">
        <?=form_submit($this->config->item('button_add_item'), $this->lang->line('button_add'));?>
        <?=form_button($this->config->item('button_delete'), 'Hapus Baris', 'onClick="document.form1.submit();"');?> </td>
	</tr>
</table>
<?php endif; ?>
<p>&nbsp;</p>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center"><?php if($data['tpaket_header']['status'] == '2') : ?>
        <?php if ($this->l_auth->is_have_perm('auth_cancel')) : ?>
        <?=form_submit($this->config->item('button_cancel'), $this->lang->line('button_apply_cancel'));?>
        <?php endif; ?>
        <?php else: ?> <?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <?php if ($this->l_auth->is_have_perm('auth_approve')) : ?>
        <?=form_submit($this->config->item('button_approve'), $this->lang->line('button_approve'));?>
        <?php endif; ?>
        <?php endif; ?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Transaksi Paket.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
        <img src="<?=base_url();?>images/help.png"></a>
         </td>
	</tr>
	<tr>
    <td align="center">&nbsp;</td>
	</tr>
	<tr>
    <td align="center"><?=anchor('tpaket/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>

<?=form_close();?>
