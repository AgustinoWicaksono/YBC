<?php
$function = $this->uri->segment(2);
  $c=mssql_connect("SVR-S-2012-64","sa","abc123?");
		$b=mssql_select_db('MSI_GO',$c);
	//mysql_connect("localhost","root","");
//echo "<pre>";
//print_r($error);
//print_r($mpaket_prod_detail);
//echo "</pre>";
//echo '$item_paket_name'.$item_paket_name
?>
<div align="center" class="page_title"><?=$page_title;?></div>
<p>&nbsp;</p>
<?=form_open($this->uri->uri_string().'#table2', $form1);?>
<?=form_hidden('mpaket_prod_header[id_mpaket_prod_header]', $this->uri->segment(3));?>
<table width="1038" border="0" align="center">
<?php
 $whs=$this->session->userdata['ADMIN']['plant'];
if ($function=='edit') {
  $item_paket_code = $data['mpaket_prod_header']['kode_paket'];
  $item_paket_name = $data['mpaket_prod_header']['nama_paket'];
  $uom_paket = $data['mpaket_prod_header']['uom_paket'];
 
}
if(!empty($error)) {
	echo $this->l_form_validation->validation_errors($error, '<tr><td colspan="2" class="error">','</</td></tr>');
}
if(isset($_POST['button']['delete'])&&(empty($error))) {
	echo "Anda baru saja menghapus data";
}
?>
	<tr>
		<td width="272" class="table_field_1"><strong>Item Code</strong></td>
		<td class="column_input"><?=form_hidden("mpaket_prod_header[kode_paket]", $item_paket_code);?>
        <strong><?=$this->l_general->remove_0_digit_in_item_code($item_paket_code);?></strong> <? if($function!='edit') : echo anchor('mpaket_prod/input', '<strong>Pilih Ulang Item Production</strong>'); endif; ?>
        </td>
	</tr>
	<tr>
		<td class="table_field_1"><strong> Item Description</strong></td>
		<td class="column_input"><?=form_hidden("mpaket_prod_header[nama_paket]", $item_paket_name);?>
        <strong><?=$item_paket_name;?></strong></td>
	</tr>
	<tr>
		<td class="table_field_1"><strong> Quantity</strong></td>
        <td class = "column_input" >
		<?php
  		if(!empty($error) && in_array("mpaket_prod_header[quantity_paket]", $error)) {
  			echo form_input("mpaket_prod_header[quantity_paket]" ,number_format($data['mpaket_prod_header']['quantity_paket'], 2, '.', ''), 'class="error_number" size="8"').' '.$uom_paket;
  		} else {
  			echo form_input("mpaket_prod_header[quantity_paket]",number_format($data['mpaket_prod_header']['quantity_paket'], 2, '.', ''), 'class="input_number" size="8"').' '.$uom_paket;
  		}
		?><?php //form_hidden("mpaket_prod_header[uom_paket]", $uom_paket);?>
        </td>
	</tr>
    <tr>
		<td class="table_field_1"><strong>UOM</strong></td>
        <td class = "column_input" >
		<?php
	  
	   $ta=mysql_query("SELECT UNIT from m_item where MATNR = '$item_paket_code'");
	   $ra=mysql_fetch_array($ta);
	   $UOM=$ra['UNIT'];
$tq=mysql_query("
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$item_paket_code' 
and m_item_uom.UomEntry='$UOM'
group by m_uom.UomName 
union
SELECT m_uom.UomName UNIT 
FROM m_item_uom 
JOIN m_uom ON m_item_uom.UomEntry = m_uom.UomEntry 
JOIN m_item ON m_item_uom.ItemCode = m_item.MATNR 
WHERE m_item.MATNR = '$item_paket_code' 
group by m_uom.UomName 

");
while($r=mysql_fetch_array($tq))
		{
			$uomH[$r['UNIT']] = $r['UNIT'];
		}
       if(!empty($error) && in_array("mpaket_prod_header[uom_paket][$i]", $error)) {
			echo form_dropdown("mpaket_prod_header[uom_paket][$k]", $uomH, $data['mpaket_prod_header']['uom_paket'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("mpaket_prod_header[uom_paket][$k]", $uomH, $data['mpaket_prod_header']['uom_paket'][$i], 'class="input_text" width="20"');
		}
	   ?>
        
        </td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
		<td width="1038" class="table_header_1"><div align="center"><strong>BOM Item</strong></div></td>
	</tr>
</table>
<table width="1038" border="0" align="center" id="table2">
	<tr bgcolor="#999999">
<?php if(!isset($data['mpaket_prod_header']['status']) || $data['mpaket_prod_header']['status'] == '1') : ?>
		<td class="table_header_1"><div align="center">&nbsp;</div></td>
<?php endif;?>
		<td class="table_header_1"><div align="center"><strong>No.</strong></div></td>
		<td class="table_header_1" width="200"><div align="center"><strong>Material No</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Material Desc</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Batch Number</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Quantity</strong></div></td>
		<td class="table_header_1"><div align="center"><strong>Uom</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>QC</strong></div></td>
         <td class="table_header_1"><div align="center"><strong>On Hand</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Min Stock</strong></div></td>
        <td class="table_header_1"><div align="center"><strong>Oustanding Total</strong></div></td>
	</tr>
<?php
//if($data['mpaket_prod_details'] !== FALSE) :
	$i = 0; //=> already defined on FOR looping below
	$j = 0; // to count cancel checkbox
	$k = 1; // to count display number, after delete some rows
	
	$kd_plant = $this->session->userdata['ADMIN']['plant'];
		$tk="SELECT material_no,material_desc FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$item_paket_code' and b.plant='$kd_plant' AND material_no IN (SELECT MATNR FROM m_item)
		UNION
		SELECT material_no,material_desc FROM m_mpaket_detail WHERE material_no='EOI'
		";
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($ti);
		//echo $tk;
		
    $mpaket_prod_detail_tmp = $this->session->userdata('mpaket_prod_detail');
    if(!empty($mpaket_prod_detail_tmp)) {
       $data['mpaket_prod_detail'] = $mpaket_prod_detail_tmp;
    }

	//$count = count($data['mpaket_prod_detail']['id_mpaket_prod_h_detail']);

	// for POST data
	if((!isset($_POST['delete']))&&(empty($mpaket_prod_detail_tmp))&&(empty($error)))
		$count2 = $count+1;
	else
		$count2 = $count ;

	//for($i = 1; $i <= $count2; $i++) {
	while($r=mysql_fetch_array($ti))
		{
		$i++;

		if($data['mpaket_prod_header']['status'] == '1' || ( ($data['mpaket_prod_header']['status'] == '2') && !empty($data['mpaket_prod_detail']['quantity'][$i]) )) {
			$j++;
		}

		if(empty($_POST['delete'][$i])) {

			if($k == $count && !empty($error) && ( in_array("mpaket_prod_detail[quantity][$i]", $error) || in_array("mpaket_prod_detail[material_no][$i]", $error)  ))
				break;
			$item_x[$i] = $this->m_general->sap_item_select_by_item_code($data['mpaket_prod_detail']['material_no'][$i]);
            if (!empty($data['mpaket_prod_detail']['material_desc'][$i])) {
              $item_x[$i]['MAKTX'] = $data['mpaket_prod_detail']['material_desc'][$i];
            }
            if (!empty($data['mpaket_prod_detail']['uom'][$i])) {
              $item_x[$i]['UNIT'] = $data['mpaket_prod_detail']['uom'][$i];
            }
			 if (!empty($data['mpaket_prod_detail']['num'][$i])) {
              $item_x[$i]['num'] = $data['mpaket_prod_detail']['num'][$i];
            } 
			
			 if (!empty($data['mpaket_prod_detail']['qc'][$i])) {
              $item_x[$i]['qc'] = $data['mpaket_prod_detail']['qc'][$i];
            } 
			//echo $data['mpaket_prod_detail']['num'][$i];
?>
  <?php if($i % 2) : ?>
  <tr class="table_row_2">
    <?php else : ?>
  </tr>
  <tr class="table_row_1">
    <?php endif; ?>
<?php if(!isset($data['mpaket_prod_header']['status']) || $data['mpaket_prod_header']['status'] == '1') : ?>
		<td align="center"><?=form_checkbox("delete[$k]", $i, FALSE);?></td>
<?php endif; ?>
		<td align="center">
        <?=form_hidden("mpaket_prod_detail[id_mpaket_prod_h_detail][$k]", $data['mpaket_prod_detail']['id_mpaket_prod_h_detail'][$k]);?>
        <?=form_hidden("mpaket_prod_detail[id_mpaket_prod_detail][$k]", $data['mpaket_prod_detail']['id_mpaket_prod_detail'][$k]);?>
        <?=$k;?></td>
		<td align="left"><?=form_hidden("mpaket_prod_detail[material_no][$k]", $r['material_no']);?>
        <?=$r['material_no'];?></td>
		<td align="left"><?=$r['material_desc'];?>
        <?=form_hidden("mpaket_prod_detail[material_desc][$k]", $r['material_desc']);?>
        </td>
        <td><?php
		$it=$r['material_no'];
		 $temp1=mssql_fetch_array(mssql_query("SELECT OnHand,MinStock FROM OITW WHERE ItemCode='$it' AND WhsCode='$kd_plant'"));
		$trans='T.'.$kd_plant;
		$temp2=mssql_fetch_array(mssql_query("SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$trans'"));
		$onhand= $temp1['OnHand'];
		$cekBatch=mysql_fetch_array(mysql_query("SELECT BATCH FROM m_item where MATNR ='$it'"));
		$tka="SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$kd_plant'";
		$ta=mysql_query($tka); 
		$count1=mysql_num_rows($ta);
		//$item5= "Tidak ada Batch Number";
		//echo "SELECT BATCH FROM m_item where MATNR ='$it'";
		$bat=$cekBatch['BATCH'];
		while($r=mysql_fetch_array($ta))
		{
		//echo $iy++;
		$item1[0]='';
			$item1[$r['num']] = $r['num'];
			
		}
		
		//echo $tk;
		if ($function !='edit')
		{
		//echo '{'.$bat.'}'.'{'.$onhand.'}';
			if ($bat == 'Y' && $onhand > 0){
				if(!empty($error) && in_array("mpaket_prod_detail[num][$i]", $error)) {
					echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="error_text" width="30"');
				} else {
				echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="input_text" width="30"');
				}
			}
			else
			{
			 echo "Tidak Ada Batch Number"; 
			}
		}else
		{
		$id= $data['mpaket_prod_header']['id_mpaket_prod_header'];
		$tpNum="SELECT a.num FROM m_mpaket_prod_detail a 
		JOIN m_mpaket_prod_header b  on a.id_mpaket_prod_header=b.id_mpaket_prod_header
		where b.id_mpaket_prod_header='$id' AND a.material_no='$it'";
		$tlNUm=mysql_fetch_array(mysql_query($tpNum)); 
		 
		echo $tlNUm['num'];?>
        <?=form_hidden("mpaket_prod_detail[num][$k]",$tlNUm['num']);
		//echo $tp;
		}
		/*if(!empty($error) && in_array("mpaket_prod_detail[num][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="error_text" ');
		} else {
			echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="input_text" ');
		}*/?>
        <?php //$item_x[$i]['num'];?>
        <?php //form_hidden("mpaket_prod_detail[num][$k]", $item_x[$i]['num']);?>
        </td>
		<td align="center">
<?php
		$vol=$data['mpaket_prod_header']['quantity_paket'];
		$tp="SELECT quantity FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$item_paket_code' and b.plant='$kd_plant' AND a.material_no='$it'";
		$tl=mysql_fetch_array(mysql_query($tp)); 
		//echo $tp;
		$qty=$tl['quantity']*$vol;
		$ctl=mysql_num_rows(mysql_query($tp));
		if ($ctl > 0)
		{
			if(!empty($error) && in_array("mpaket_prod_detail[quantity][$i]", $error)) {
				echo form_input("mpaket_prod_detail[quantity][$k]", number_format($qty, 2, '.', ''), 'class="error_number" size="8"');
			} else {
				echo form_hidden("mpaket_prod_detail[quantity][$k]", $qty);
                if($data['mpaket_prod_header']['status'] != '2')
   				  echo form_input("mpaket_prod_detail[quantity][$k]", number_format($qty, 2, '.', ''), 'class="input_number" size="8"');
                else
   				  echo number_format($qty, 2, '.', ',');
			}
			}
?></td>
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
while($r=mysql_fetch_array($tq))
		{
			$uom[$r['UNIT']] = $r['UNIT'];
		}
       if(!empty($error) && in_array("mpaket_prod_detail[uom][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[uom][$k]", $uom, $data['mpaket_prod_detail']['uom'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("mpaket_prod_detail[uom][$k]", $uom, $data['mpaket_prod_detail']['uom'][$i], 'class="input_text" width="20"');
		}
	   ?>
       
         <?php //$item_x[$i]['UNIT1'];?>
         <?php //form_hidden("mpaket_prod_detail[uom][$k]", $item_x[$i]['UNIT1']);?>
        </td>
         <td>
         <?php
         $qc=array(
		''=>'',
		'tes'=>'tes',
		'tes2'=>'tes2'
		);
        if(!empty($error) && in_array("mpaket_prod_detail[qc][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[qc][$k]", $qc, $data['mpaket_prod_detail']['qc'][$i], 'class="error_text" width="20"');
		} else {
			echo form_dropdown("mpaket_prod_detail[qc][$k]", $qc, $data['mpaket_prod_detail']['qc'][$i], 'class="input_text" width="20"');
		}
		 ?>
        <?php //$item_x[$i]['qc'];?>
        <?php //form_hidden("mpaket_prod_detail[qc][$k]", $item_x[$i]['qc']);?>
        </td>
          <td>
          <?php
       
		echo $temp1['OnHand'];?>
        <?=form_hidden("mpaket_prod_detail[OnHand][$k]", $temp1['OnHand'],$data['mpaket_prod_detail']['OnHand'][$i]);?>
		
        </td>
        <td>
       <?=$temp1['MinStock'];?>
        <?=form_hidden("mpaket_prod_detail[MinStock][$k]", $temp1['MinStock'],$data['mpaket_prod_detail']['MinStock'][$i]);?>
        </td>
         <td>
       <?=$temp2['OpenQty'];?>
        <?=form_hidden("mpaket_prod_detail[OpenQty][$k]", $temp2['OpenQty'],$data['mpaket_prod_detail']['OpenQty'][$i]);?>
        </td>
  </tr>
<?php
			$k++;
		}

	}
	
	// below is for new data
	if($data['mpaket_prod_header']['status'] != '2') :
	
?>
	<tr>
<?php if(!isset($data['mpaket_prod_header']['status']) || $data['mpaket_prod_header']['status'] == '1') : ?>
		<td>&nbsp;</td>
<?php endif; ?>
		<td align="center"><?php if(!isset($data['mpaket_prod_header']['status']) || $data['mpaket_prod_header']['status'] == '1') : ?><?=form_hidden("mpaket_prod_detail[id_mpaket_prod_h_detail][$k]", $k);?><?php endif; ?><?=$k;?></td>
		<td colspan="2" align="center">
		<?php
	/*	$kd_plant = $this->session->userdata['ADMIN']['plant'];
		$tk="SELECT * FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$item_paket_code' and b.plant='$kd_plant' AND a.material_no IN(SELECT MATNR FROM m_item)";
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($ti);
		$item2= "Tidak ada Batch Number";
		$item3[0]='';
		while($r=mysql_fetch_array($ti))
		{
			$item3[$r['material_no']] = $r['material_no'].' - '.$r['material_desc'];
		}
		
		if(!empty($error) && in_array("mpaket_prod_detail[material_no][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[material_no][$k]", $item3, $data['mpaket_prod_detail']['material_no'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("mpaket_prod_detail[material_no][$k]", $item3, $data['mpaket_prod_detail']['material_no'][$i], 'class="input_text" onChange="document.form1.submit();"');
		}*/
		?>
		</td>
         <td>
         <?php
	/*	$it=$data['mpaket_prod_detail']['material_no'][$i];
		$tk="SELECT DistNumber num FROM m_batch where ItemCode='$it' AND Whs ='$whs'";
		$ti=mysql_query($tk); 
		$count=mysql_num_rows($ti);
		//$item5= "Tidak ada Batch Number";
		$item1[0]='';
		while($r=mysql_fetch_array($ti))
		{
			$item1[$r['num']] = $r['num'];
		}
		
		//echo $tk;
		
		if ($count > 0){
	
		if(!empty($error) && in_array("mpaket_prod_detail[num][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="error_text" ');
		} else {
			echo form_dropdown("mpaket_prod_detail[num][$k]", $item1, $data['mpaket_prod_detail']['num'][$i], 'class="input_text" ');
		}
		}
		else
		{
		 echo "Tidak Ada Batch Number"; 
		}*/
		?>
        
        </td>
		<td align="center">
		<?php
	/*	$mat=$data['mpaket_prod_detail']['material_no'][$i];
		$vol=$data['mpaket_prod_header']['quantity_paket'];
		$tp="SELECT * FROM m_mpaket_detail a 
		JOIN m_mpaket_header b  on a.id_mpaket_header=b.id_mpaket_header
		where b.kode_paket='$item_paket_code' and b.plant='$kd_plant' AND a.material_no='$mat'";
		$tl=mysql_fetch_array(mysql_query($tp)); 
		$qty=$tl['quantity']*$vol;
		$ctl=mysql_num_rows(mysql_query($tp));
		if ($ctl > 0)
		{
		
		if(!empty($error) && in_array("mpaket_prod_detail[quantity][$i]", $error)) {
			echo form_input("mpaket_prod_detail[quantity][$k]", $qty,$data['mpaket_prod_detail']['quantity'][$i], 'class="error_number" size="8"');
		} else {
			echo form_input("mpaket_prod_detail[quantity][$k]", $qty,$data['mpaket_prod_detail']['quantity'][$i], 'class="input_number" size="8"');
		}
		}*/
		?>
		</td>
        <td>
        <?php
	   /*$ta=mysql_query("SELECT UNIT from m_item where MATNR = '$it'");
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
	
		if(!empty($error) && in_array("mpaket_prod_detail[uom][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[uom][$k]", $itemC, $data['mpaket_prod_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select error_text" style="width:50px;" ');
		} else {
		echo form_dropdown("mpaket_prod_detail[uom][$k]", $itemC  , $data['mpaket_prod_detail']['uom'][$i], ' data-placeholder="Pilih UOM..." class="chosen-select input_text" style="width:50px;"  ');  
		}
		}*/
	   ?>
        </td>
        <td><?php
		
		/*$qc=array(
		''=>'',
		'tes'=>'tes',
		'tes2'=>'tes2'
		);
        if(!empty($error) && in_array("mpaket_prod_detail[qc][$i]", $error)) {
			echo form_dropdown("mpaket_prod_detail[qc][$k]", $qc, $data['mpaket_prod_detail']['qc'][$i], 'class="error_text" onChange="document.form1.submit();"');
		} else {
			echo form_dropdown("mpaket_prod_detail[qc][$k]", $qc, $data['mpaket_prod_detail']['qc'][$i], 'class="input_text" onChange="document.form1.submit();"');
		} */?>
        </td>
         <td>
          <?php
        $temp1=mssql_fetch_array(mssql_query("SELECT OnHand,MinStock FROM OITW WHERE ItemCode='$it' AND WhsCode='$kd_plant'"));
		$trans='T.'.$kd_plant;
		$temp2=mssql_fetch_array(mssql_query("SELECT SUM(OpenQty) as OpenQty FROM WTQ1 WHERE ItemCode='$it' AND WhsCode='$trans'"));
		echo $temp1['OnHand'];?>
        <?=form_hidden("mpaket_prod_detail[OnHand][$k]", $temp1['OnHand'],$data['mpaket_prod_detail']['OnHand'][$i]);?>
		
        </td>
        <td>
       <?=$temp1['MinStock'];?>
        <?=form_hidden("mpaket_prod_detail[MinStock][$k]", $temp1['MinStock'],$data['mpaket_prod_detail']['MinStock'][$i]);?>
        </td>
         <td>
       <?=$temp2['OpenQty'];?>
        <?=form_hidden("mpaket_prod_detail[OpenQty][$k]", $temp2['OpenQty'],$data['mpaket_prod_detail']['OpenQty'][$i]);?>
        </td>
	</tr>
<?php
	endif;
?>
<?php if(($data['mpaket_prod_header']['status'] == '2')&&($this->l_auth->is_have_perm('auth_cancel'))) : ?>
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
<?php if($data['mpaket_prod_header']['status'] != '2') : ?>
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
		<!--td align="center"><?=form_submit($this->config->item('button_save'), $this->lang->line('button_save'));?>
        <a href="#" onclick="window.open('<?=base_url();?>help/Goods Issue to Cost Center.htm','popup','left=900 height=600,width=800,scrollbars=yes'); return(false);">
         <img src="<?=base_url();?>images/help.png"></a></td-->
         <td align="center"><?php if($data['mpaket_prod_header']['status'] == '2') : ?>
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
    <td align="center"><?=anchor('mpaket_prod/browse', $this->lang->line('button_back'));?></td>
	</tr>
</table>
<?=form_close();?>
